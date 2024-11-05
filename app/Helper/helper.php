<?php
$xApiKey = "S2VsdWhpdXY5K3gva1V1eGI0Mi9QQT09";
define('API_BASE', 'https://gopay.gooomart.com/api/v2');
define('API_HEADEARS',  [
    "Accept: application/json",
    "Content-Type: application/json",
    "x-api-key: $xApiKey"
]);

use App\Models\Cart;
use App\Models\Category;
use App\Models\Commande;
use App\Models\Config;
use App\Models\Filiere;
use App\Models\Pay;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

function v($v, $append = '')
{
    return number_format($v, 2, '.', ' ') . ($append ? " $append" : '');
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

function isvalidenumber($phone)
{
    return in_array(substr($phone, 0, 3), ['099', '097', '098', '090', '081', '082', '083', '084', '085', '080', '086', '089']);
}


function gopay_init_payment($amount, $devise, $telephone, $myref)
{
    $_api_headers = API_HEADEARS;
    $telephone = (float) $telephone;
    $data = array(
        "telephone" => "+$telephone",
        "amount" => $amount,
        "devise" => $devise,
        "myref" => $myref,
    );

    $data = json_encode($data);
    $gateway = API_BASE . "/payment/init";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $gateway);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $_api_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $response = curl_exec($ch);
    $rep['success'] = false;
    if (curl_errno($ch)) {
        $rep['message'] = "Erreur, veuillez reessayer.";
    } else {
        $jsonRes = json_decode($response);
        $rep['success'] = @$jsonRes->success;
        $rep['message'] = @$jsonRes->message;
        $rep['data'] = @$jsonRes->data;
    }
    curl_close($ch);
    return (object) $rep;
}

function completeTrans()
{
    $pendingPayments = Pay::where(['saved' => '0', 'failed' => '0'])->get();
    foreach ($pendingPayments as $trans) {
        $myref = $trans->myref;
        $t = transaction_status($myref);
        $status = @$t->status;
        if ($status === 'success') {
            saveData($trans);
        } else if ($status === 'failed') {
            $trans->update(['failed' => 1]);
        }
    }
}

function transaction_status($myref)
{
    $_api_headers = API_HEADEARS;

    $gateway = API_BASE . "/payment/check/" . $myref;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $gateway);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $_api_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $response = curl_exec($ch);
    $status = null;
    if (!curl_errno($ch)) {
        curl_close($ch);
        $status = @json_decode($response)->transaction;
    }
    return $status;
}


function saveData($trans)
{
    DB::transaction(function () use ($trans) {
        $data =  json_decode($trans->data);
        $insert = (array) $data->insertdata;
        Commande::create($insert);
        Cart::where('users_id', $insert['users_id'])->delete();
        $art = json_decode($insert['articles']);
        foreach ($art as $el) {
            $p = Product::where('id', $el->id)->first();
            if ($p) {
                $st = $p->stock - $el->qty;
                $p->update(['stock' => $st]);
            }
        }
        $trans->update(['saved' => 1, 'failed' => 0]);
    });
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

function userimage($user)
{
    $img = $user?->image;
    if ($img) {
        $img =   asset('storage/' . $img);
    } else {
        $img =   asset('/assets/images/faces/9.jpg');
    }
    return $img;
}
