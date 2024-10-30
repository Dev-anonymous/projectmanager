<?php
define('BASEF', 'https://backend.flexpay.cd/api/rest/v1');
define('FTKN', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzgxMTcyNzUzLCJzdWIiOiJiOWE4MDM3ZTEyM2YyMzY0OTNiODkxOGU1N2IyNmY1ZiJ9.r8cFNhWM1AC9_pt8usfuJlzaFMvGDvxNde0ZNfU2X0Q');
define('COMMISSION', 3.5 / 100);

use App\Models\Category;
use App\Models\Config;
use App\Models\Filiere;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

function v($v, $append = '')
{
    return number_format($v, 3, '.', ' ') . ($append ? " $append" : '');
}

function nnow()
{
    return now('Africa/Lubumbashi');
}

function defaultdata()
{
    $u = User::where('user_role', 'admin')->first();
    if (!$u) {
        User::create(['name' => 'Admin', 'email' => 'admin@admin.admin', 'user_role' => 'admin', 'password' => Hash::make('admin@2024')]);
    }

    $pr = Promotion::first();
    if (!$pr) {
        foreach (['Bac +1', 'BAC +2', 'BAC +3', 'Master 1', 'Master 2', 'Doctorat 1', 'Doctorat 2'] as $el) {
            Promotion::create(['promotion' => $el]);
        }
    }

    $fi = Filiere::first();
    if (!$fi) {
        foreach (['MEDECINE', 'DROIT', 'SCIENCES TECHNOLOGIQUES', 'SCIENCES INFORMATIQUES', 'ARCHITECTURE', 'SCIENCES DE GESTION', 'SCIENCES DES ALIMENTS ET DE L\'ENVIRONNEMENT', 'SCIENCES DE L\'INFORMATION ET DE LA COMMUNICATION'] as $el) {
            Filiere::create(['filiere' => $el]);
        }
    }

    $c = Category::first();
    if (!$c) {
        foreach (['Categorie 1'] as $el) {
            Category::create(['category' => $el]);
        }
    }
}


function transid($user)
{
    $t = Depot::where('profil_id', $user->profils()->first()->id)->count() + 1;

    if ($t <= 9) {
        $t = "00$t";
    } else if ($t >= 10 && $t <= 99) {
        $t = "0$t";
    }
    $v = "Trans-$t-";
    $rn = rand(1000, 9999);
    $v .= $rn;

    while (1) {
        if (Depot::where('ref', $v)->first()) {
            return transid($user);
        } else {
            break;
        }
    }
    return ($v);
}

function isvalidenumber($phone)
{
    return in_array(substr($phone, 0, 3), ['099', '097', '098', '090', '081', '082', '083', '084', '085', '080', '086']);
}

function ipf($devise, $montant, $telephone, $ref)
{
    $data = array(
        "merchant" => 'BCS',
        "type" => "1",
        "phone" => "$telephone",
        "reference" => "$ref",
        "amount" => "$montant",
        "currency" => "$devise",
        "callbackUrl" => route('login'),
    );

    $data = json_encode($data);
    $gateway = BASEF . "/paymentService";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $gateway);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: " . FTKN
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $response = curl_exec($ch);
    $rep['status'] = false;
    if (curl_errno($ch)) {
        $rep['message'] = "Erreur, veuillez reessayer.";
    } else {
        $jsonRes = json_decode($response);
        $code = $jsonRes->code ?? '';
        if ($code != "0") {
            $rep['message'] = "Erreur : " . @$jsonRes->message;
            $rep['data'] = $jsonRes;
        } else {
            $rep['status'] = true;
            $rep['message'] = "Veuillez saisir le Pin mobile Money pour confirmer la transaction.";
            $rep['data'] = $jsonRes;
        }
    }
    curl_close($ch);
    return $rep;
}


function transaction_was_success($orderNumber)
{
    $gateway = BASEF . "/check/" . $orderNumber;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $gateway);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: " . FTKN
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $response = curl_exec($ch);
    $status = null;
    if (!curl_errno($ch)) {
        curl_close($ch);
        $jsonRes = json_decode($response);
        $code = $jsonRes->code ?? '';
        if ($code == "0") {
            if ($jsonRes->transaction->status == '0') {
                $status = true;
            } else if ($jsonRes->transaction->status == '1') { // 2=> en attente
                $status = false;
            }
        }
    }
    return $status;
}

function savedata($pd)
{
    // try {
    DB::transaction(function () use ($pd) {
        $pd0 = json_decode($pd->data);
        $insert = (array) $pd0->insertdata;
        $insert['date'] = nnow();

        Depot::create($insert);
        $profil = Profil::find($insert['profil_id']);
        $devise = $insert['devise_depot'];
        $devise = strtolower($devise);

        $agent = $insert['agentname'];

        $phone = $profil->user->phone;
        $type = $insert['type'];
        $commission = $insert['commission'];
        $montant = $insert["montant_$devise"];
        $montantrecu = $montant - ($montant * $commission);

        $profil->increment("solde_$devise", $montantrecu);

        $devise = strtoupper($devise);
        $montantrecu = v($montantrecu, $devise);

        $commission *= 100;
        $montant = v($montant, $devise);
        $txt = "Depot ($type) de $montant (-$commission%)\nMontant recu : $montantrecu\nAgent : $agent\nTransID : $pd->ref";
        if ('yes' == getconfig('sms')) {
            Pending::create(['to' => $phone, 'text' => $txt, 'retry' => 0]);
        }
        $pd->update(['saved' => 1, 'failed' => 0, 'date' => now('Africa/Lubumbashi')]);
    });
    // } catch (\Throwable $th) {
    //     //throw $th;
    // }
}

function iinit($tel, $montant, $devise, $invoiceid)
{
    $montant = (float) $montant;
    $tel = "00243" . ((int) $tel);
    $devise = strtoupper($devise);
    $montant = number_format($montant, 2, '.', '');
    $client = new \GuzzleHttp\Client();
    $tid = time() . rand(1, 1000000000);

    $headers = array(
        'LogInName' => 'fc46eb53f793b886f9fd4905d3cefe6c15385c9a49a5edc08079ee695e3bd222',
        'Content-Type' => 'application/json',
        'LoginPass' => 'd2d74e274526b085ee5a4aa4baebdec0c60620003a126fb7b7fe6fae64b25453',
        'Authorization' => 'Basic MzdjMTM1YWJlMWIxOGFhNDJmNDY0NzVkNDA5NzkzNmQzNTk0YzFjYzQxMDZkZGNlNGZlODM3MzgwNjE3Y2RjZToyZGI0ZjRiYTQzYTUyMzAxOTEyMTJhYjgzOWNiYTY5ZmJiOTNmM2Q0NmUwZjQwNjM3M2M1MjMyZDZjNmUzM2I1'
    );
    $url = 'https://new.rawbankillico.com:4004/RAWAPIGateway/ecommerce/payment';

    $data = '{
        "mobilenumber": "' . $tel . '",
        "trancurrency":"' . $devise . '",
        "amounttransaction": "' . $montant . '",
        "merchantid": "merch0000000000000201",
        "invoiceid":"' . $invoiceid . '",
        "terminalid":"' . $tid . '",
        "encryptkey": "AX8dsXSKqWlJqRhpnCeFJ03CzqMsCisQVUNSymXKqeiaQdHf8eQSyITvCD6u3CLZJBebnxj5LbdosC/4OvUtNbAUbaIgBKMC5MpXGRXZdfAlGsVRfHTmjaGDe1RIiHKP",
        "securityparams":{
            "gpslatitude": "24.864190",
            "gpslongitude": "67.090420"
        }
    }';

    try {
        $request = new GuzzleHttp\Psr7\Request('POST', $url);
        $response = $client->send($request, ['headers' => $headers, 'body' => $data]);
        return json_decode($response->getBody()->getContents());
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return json_decode($e->getResponse()->getBody()->getContents());
    }
}

function cmi($refnumber, $otpmsg)
{
    $client = new \GuzzleHttp\Client();

    $headers = array(
        'LogInName' => 'fc46eb53f793b886f9fd4905d3cefe6c15385c9a49a5edc08079ee695e3bd222',
        'Content-Type' => 'application/json',
        'LoginPass' => 'd2d74e274526b085ee5a4aa4baebdec0c60620003a126fb7b7fe6fae64b25453',
        'Authorization' => 'Basic MzdjMTM1YWJlMWIxOGFhNDJmNDY0NzVkNDA5NzkzNmQzNTk0YzFjYzQxMDZkZGNlNGZlODM3MzgwNjE3Y2RjZToyZGI0ZjRiYTQzYTUyMzAxOTEyMTJhYjgzOWNiYTY5ZmJiOTNmM2Q0NmUwZjQwNjM3M2M1MjMyZDZjNmUzM2I1'
    );
    $url = 'https://new.rawbankillico.com:4004/RAWAPIGateway/ecommerce/payment/' . $otpmsg . '/' . $refnumber;

    $request = new GuzzleHttp\Psr7\Request('GET', $url);
    try {
        $response = $client->send($request, ['headers' => $headers]);
        return json_decode($response->getBody()->getContents());
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return json_decode($e->getResponse()->getBody()->getContents());
    }
}

function _3ds($data)
{
    $apidata['data'] = $data->data;
    $numOrder = 'order.' . mt_rand(100, 10000) * mt_rand(100, 10000) . uniqid('.');
    $numTrans = 'trans.' . mt_rand(100, 10000) * mt_rand(100, 10000) . uniqid('.');
    $code = $data->ref; // uniqid('', true) . rand(1000000, 9000000);
    $apidata['paycode'] = $code;

    $url_1 = "https://ap-gateway.mastercard.com/api/rest/version/57/merchant/MBANGUIT/order/$numOrder/transaction/$numOrder";
    $url_2 = "https://ap-gateway.mastercard.com/api/rest/version/57/merchant/MBANGUIT/order/$numOrder/transaction/$numTrans";

    // $url_1 = "https://test-gateway.mastercard.com/api/rest/version/57/merchant/MBANGUIT/order/$numOrder/transaction/$numOrder";
    // $url_2 = "https://test-gateway.mastercard.com/api/rest/version/57/merchant/MBANGUIT/order/$numOrder/transaction/$numTrans";

    $headers = [
        // 'Authorization: Basic bWVyY2hhbnQuTUJBTkdVSVQ6MDVmZTE1YzlhY2M2MDdjNGExYTdmM2ZmN2JmZDQ2MmU=', // test
        'Authorization: Basic bWVyY2hhbnQuTUJBTkdVSVQ6ZjdmNWM5MDgwZDJjNzU0NGMwN2ViY2I0NmNmY2ZiY2Q=', //
        'Content-Type: application/json'
    ];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url_1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => '{
            "apiOperation":"INITIATE_AUTHENTICATION",
            "authentication":{
            "acceptVersions":"3DS1,3DS2",
            "channel":"PAYER_BROWSER",
            "purpose":"PAYMENT_TRANSACTION"
            },
            "order":{
            "currency":"' . $data->devise . '"
            },
            "sourceOfFunds":{
            "provided":{
                "card":{
                    "number":"' . $data->numcarte . '"
                }
                }
            }
        }',
        CURLOPT_HTTPHEADER => $headers,
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    if ($response == null) {
        return (object) ['status' => false, 'message' => "Une petite erreur s'est produite, veuillez relancer la transaction."];
    }
    if (@$response->response->gatewayRecommendation != 'PROCEED') {
        $ame = @$response->error->explanation;
        $ame = empty($ame) ? @$response->response->gatewayCode : $ame;
        return (object) ['status' => false, 'message' => "Echec de transaction : " .  @$ame];
    }
    $apidata['initiate_auth'] = $response;
    $paydata = '{
        "apiOperation":"PAY",
        "authentication":{
            "transactionId":"' . $numOrder  . '"
        },
        "order":{
            "currency": "' . $data->devise . '",
            "amount": "' . $data->montant . '",
            "description": "' . $data->description . '",
            "reference": "' . $numOrder . '"
        },
        "transaction":{
            "reference":"' . $numTrans . '"
        },
        "sourceOfFunds":{
            "type":"CARD",
            "provided":{
                "card": {
                    "number":"' . $data->numcarte . '",
                    "expiry":{
                        "month": "' . $data->mois_exp . '",
                        "year": "' . $data->annee_exp . '"
                    },
                    "securityCode": "' . $data->cvv . '"
                }
            }
        }
    }';
    $apidata['paydata'] = $paydata;

    if (@$response->response->gatewayCode == 'DECLINED') {
        return (object) [
            'status' => true,
            'payNow' => true,
            'apidata' => (object) $apidata,
            'pay_url' => $url_2,
            'pay_body' => $paydata,
            'headers' => $headers
        ];
    }

    $redir = route('pay', ['ref' => $code]);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url_1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => '{
            "apiOperation": "AUTHENTICATE_PAYER",
            "authentication":{
              "redirectResponseUrl":"' . $redir . '&_action=mz' . '"
            },
            "device": {
              "browser": "MOZILLA",
              "browserDetails": {
                "3DSecureChallengeWindowSize": "FULL_SCREEN",
                "acceptHeaders": "application/json",
                "colorDepth": 24,
                "javaEnabled": true,
                "language": "en-US",
                "screenHeight": 640,
                "screenWidth": 480,
                "timeZone": 273
              },
              "ipAddress": "127.0.0.1"
             },
             "order":{
                "amount":"' . $data->montant . '",
                "currency":"' . $data->devise . '"
             },
             "sourceOfFunds":{
                  "provided":{
                    "card":{
                        "number":"' . $data->numcarte . '",
                        "expiry":{
                            "month": "' . $data->mois_exp . '",
                            "year": "' . $data->annee_exp . '"
                        }
                    }
                  }
              }
          }',
        CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    if ($response == null) {
        return (object) ['status' => false, 'message' => "Une erreur s'est produite, veuillez relancer la transaction."];
    }
    if (@$response->response->gatewayRecommendation != 'PROCEED') {
        $ame = @$response->error->explanation;
        $ame = empty($ame) ? @$response->response->gatewayCode : $ame;
        return (object) ['status' => false, 'message' => "Echec de transaction : " . @$ame];
    }
    $apidata['auth_payer'] = $response;

    return (object) [
        'status' => true,
        'message' => "Votre transaction a été initialisée!",
        'apidata' => (object) $apidata,
        'pay_url' => $redir
    ];
}

function _payWithNo3ds($url, $body, $headers)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result);

    $res['status'] = false;
    if (!is_object($result)) {
        $res['message'] = "Une erreur s'est produite lors du payement, veuillez relancer la transaction.";
    } else {
        if (isset($result->response) && @$result->response->acquirerCode == "00") {
            $res['message'] = "Votre payement a été effectué avec succès !";
            $res['status'] = true;
            $res['api_result'] = $result;
        } else {
            $res['message'] = "Une erreur s'est produite lors du payement, veuillez relancer la transaction.";
        }
    }

    return (object) $res;
}


function getconfig($name)
{
    $conf = json_decode(@Config::first()->config ?? '[]');
    if (isset($conf->{$name})) {
        return $conf->{$name};
    }
    return null;
}

function setconfig($name, $value)
{
    if ($name and $value) {
        $conf = (object) json_decode(@Config::first()->config ?? '[]');
        $conf->{$name} = $value;

        $o = Config::first();
        if ($o) {
            $o->update(['config' => json_encode($conf)]);
        } else {
            Config::create(['config' => json_encode($conf)]);
        }
    }
}


function sms($to = '', $msg = '')
{
    if (empty($to) or empty($msg)) {
        return false;
    }

    $to = "+243" . (int) $to;

    if (orangeSms((int) $to, $msg)) {
        return true;
    }

    $account_sid = 'ACe53f2cb9eca5a7240beee2cf58a006a5';
    $auth_token = 'fcc340470dcdb5bee98d75e6d59a0998';

    $client = new Client($account_sid, $auth_token);
    try {
        $a = $client->messages->create(
            $to,
            array(
                'from' => 'PoroCash',
                'body' => $msg
            )
        );
        return true;
    } catch (\Throwable $th) {
        $m = $th->getMessage();
        // dd($m);
        return false;
    }
}

function orangeSms($to = '', $msg = '')
{
    $rep = false;
    $curl = curl_init();
    if (!file_exists('token.auth')) {
        touch('token.auth');
    }
    $file = fopen("token.auth", "r+");
    $token = file_get_contents("token.auth");
    fclose($file);

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B2430000/requests',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "outboundSMSMessageRequest": {
                "address": "tel:+' . $to . '",
                "senderAddress":"tel:+2430000",
                "outboundSMSTextMessage": {
                    "message": "' . $msg . '"
                }
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Bearer $token"
        ),
    ));
    $response = curl_exec($curl);
    $code = curl_getinfo($curl)['http_code'];
    if ($code == 401) {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://api.orange.com/oauth/v3/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic M3U5dWRoVHJOVGJ2bDFGTnBUR1h3Rk9XcUp3eFBrdjU6R1R0VnNXWVVia252eDhOcw=='
            ),
        ));
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);
        if (is_object($resp)) {
            $file = fopen("token.auth", "w+");
            fwrite($file, $resp->access_token);
            fclose($file);
            return orangeSms($to, $msg);
        }
    } else if ($code == 201) {
        $rep = true;
    }
    curl_close($curl);
    return $rep;
}


function userimage($user)
{
    $img = $user->image;
    if ($img) {
        $img =   asset('storage/' . $img);
    } else {
        $img =   asset('/assets/images/faces/9.jpg');
    }
    return $img;
}
