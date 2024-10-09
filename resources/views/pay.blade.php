<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        #redirectTo3ds1Frame {
            border: none;
        }

        #redirectTo3ds1AcsSimple {
            height: 100vh;
        }

        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('assets/images/media/loader.svg') }}") 50% 50% no-repeat #fff;
            opacity: 1;
        }

        html,
        body {
            background: #ccc !important;
        }
    </style>
</head>

<body>

    <div class="loader"></div>

    @php
        $api_action = request('_action');

        $apiBaseUrl = 'https://ap-gateway.mastercard.com/api/rest/version/57/merchant/';
        $merchant = 'MBANGUIT';
        $headers = [
            // 'Authorization: Basic bWVyY2hhbnQuTUJBTkdVSVQ6MDVmZTE1YzlhY2M2MDdjNGExYTdmM2ZmN2JmZDQ2MmU=', // test
            'Authorization: Basic bWVyY2hhbnQuTUJBTkdVSVQ6ZjdmNWM5MDgwZDJjNzU0NGMwN2ViY2I0NmNmY2ZiY2Q=', //
            'Content-Type: application/json',
        ];

        $apidata = json_decode($pd->data)->api->apidata;

        $montant = $apidata->data->montant;
        $devise = $apidata->data->devise;
        $label = number_format($montant, 2, '.', ' ') . " $devise";
        $ref = $apidata->paycode;

        $payBody = $apidata->paydata;
        $init_auth = $apidata->initiate_auth;
        $auth_payer = $apidata->auth_payer;
        $redirecthtmlInitiateAuth = $init_auth->authentication->redirectHtml;
        $redirecthtmlAuthPayer = $auth_payer->authentication->redirectHtml;
        $msg = $title = $apiMsg = '';

    @endphp


    @if ($api_action != 'mz')
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12">
                    <div class="p-1">
                        <h2 class="d-flex justify-content-center mb-3 mt-5">Payement</h2>
                        <div id="init-auth" style="display:none;">
                            <?= $redirecthtmlInitiateAuth ?>
                        </div>
                        <div id="auth-payer">
                            <?= $redirecthtmlAuthPayer ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @php
            $orderId = $auth_payer->order->id;
            $retreiveAuthenticationUrl = $apiBaseUrl . $merchant . '/order/' . $orderId . '/transaction/' . $orderId;

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $retreiveAuthenticationUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $headers,
            ]);
            $result = curl_exec($curl);
            if (@curl_errno($curl)) {
                $title = 'Echec de payement.';
                $msg =
                    "<h5 class='text-danger' >Une erreur s'est produite lors du payement, veuillez relancer la transaction.</h5>";
            } else {
                $result = json_decode($result);
                $authenticationStatus = @$result->response->gatewayCode;
                $gatewayRecommandation = @$result->response->gatewayRecommendation;

                if ($gatewayRecommandation != 'PROCEED') {
                    $apiMsg = @$result->response->acquirerMessage;
                    $title = 'Echec de payement.';
                    $msg =
                        "<h5 class='text-danger'>Votre payement a échoué, veuillez vérifier les informations de votre carte et le code OTP saisi s'il correspond à celui que vous avez récu à votre numéro de téléphone.</h5>";
                } else {
                    $tId = rand(1000000, 9000000) . rand(1000000, 9000000);
                    $payTransactionUrl = $apiBaseUrl . $merchant . "/order/$orderId/transaction/$tId";
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $payTransactionUrl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                    curl_setopt($curl, CURLOPT_POSTFIELDS, $payBody);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($curl);

                    if (@curl_errno($curl)) {
                        $title = 'Echec de payement.';
                        $msg =
                            "<h5 class='text-danger' >Une erreur s'est produite lors du payement, veuillez fermer cette page et relancer la transaction.</h5>";
                    } else {
                        $result = json_decode($result);
                        if (is_object($result) && isset($result->response) && $result->response->acquirerCode == '00') {
                            savedata($pd);

                            $title = 'Payement effectué.';
                            $msg = "<h5 class='text-success' >Votre payement de $label a été effectué avec success !</h5>";
                            $msg .= "<h4 class='text-success' >Réference : $ref </h4>";
                        } else {
                            $title = '';
                            $msg = "<h5 class='text-danger'>Payement échoué.</h5>";
                        }
                    }
                    @curl_close($curl);

                    $apiMsg = @$result->response->acquirerMessage;
                }
            }
            @curl_close($curl);
        @endphp

        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12">
                    <div class="jumbotron p-2">
                        <small><?= $title ?></small>
                        <?= $msg ?>
                        <i class="small text-muted ">#<?= @$apiMsg ?></i>
                    </div>
                    <div class="text-start">
                        <a class='btn btn-link mt-3' href='#'
                            onclick="parent.location.assign('{{ route('agent.transactions') }}')">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script src="{{ asset('assets/js/jq.min.js') }}"></script>
    <script>
        $(window).on("load", function() {
            $(".loader").fadeOut("slow");
        });
    </script>

</body>

</html>
