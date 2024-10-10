<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Paramètres | {{ config('app.name') }} </title>
    <x-css-file />
</head>

<body>
    <x-switcher />
    <div class="page">
        <x-header />
        <x-aside />

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Paramètres</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Paramètres</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Paramètres</div>
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>Taux</h5>
                                </div>
                                <div taux>

                                </div>
                                <div class="mt-3">
                                    <button remotetx
                                        class="modal-effect btn btn-danger-light btn-border-down btn-sm btn-wave waves-effect waves-light"
                                        data-bs-effect="effect-flip-vertical"><span></span> Récupérer les taux en ligne
                                    </button>

                                    <button
                                        class="modal-effect btn btn-teal-light btn-border-down btn-sm btn-wave waves-effect waves-light"
                                        data-bs-effect="effect-flip-vertical" data-bs-toggle="modal"
                                        href="#mdl"><span></span> Modifier manuellement les taux
                                    </button>
                                </div>
                                <h5 class="mt-3">Mise à jour automatique des taux</h5>
                                <div class="mt-3">
                                    <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                        <input id="toggleswitchSuccess" name="toggleswitch001" type="checkbox"
                                            @if (isremoteon()) checked @endif>
                                        <label for="toggleswitchSuccess" class="label-success"></label><span
                                            class="ms-3">Récupérer les taux en ligne automatiquement</span>
                                    </div>
                                    <div txldr=""></div>
                                </div>
                                <h5 class="mt-5">SMS</h5>
                                <div class="mt-3">
                                    <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                        <input id="toggleswitchSuccess00" name="bsms" type="checkbox"
                                            @if (getconfig('sms') == 'yes') checked @endif>
                                        <label for="toggleswitchSuccess00" class="label-success"></label><span
                                            class="ms-3">Envoyer un SMS au chauffeur à chaque transaction</span>
                                    </div>
                                    <div smsldr=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mdl">
            <div class="modal-dialog  text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Taux </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" id="f-add">
                        <div class="modal-body text-start">
                            <input type="hidden" name="action" value="update">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">1 USD en CDF</label>
                                <input required type="number" value="{{ gettaux()->usd_cdf }}" step="0.0000001"
                                    min="0.0000001" name="usd_cdf" class="form-control form-control-sm"
                                    id="signin-username">
                            </div>
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">1 CDF en USD</label>
                                <input required type="number" value="{{ gettaux()->cdf_usd }}" step="0.0000001"
                                    min="0.0000001" name="cdf_usd" class="form-control form-control-sm"
                                    id="signin-username">
                            </div>
                            <div class="mt-2">
                                <div id="rep"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button class="btn btn-primary" type="submit"><span></span> Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <x-footer />
    </div>

    <div id="responsive-overlay"></div>

    <x-js-file />
    <x-datatable />
    <script>
        $(document).ready(function() {
            function getdata() {
                $('[taux]').removeClass().html('').addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('taux.index') }}',
                    success: function(res) {
                        var ht = `
                            <p class="m-0">1 CDF = ${res.cdf_usd} USD</p>
                            <p class="m-0">1 USD = ${res.usd_cdf} CDF</p>
                        `;
                        $('[taux]').html(ht);
                    },
                    error: function(res) {

                    }
                }).always(function() {
                    $('[taux]').removeClass();
                })
            }
            getdata();

            $('[name=toggleswitch001]').change(function() {
                var ip = $(this);
                var to = $(this).is(':checked') ? 1 : 0;
                $('[txldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                ip.attr('disabled', true);
                $.ajax({
                    'url': '{{ route('taux.store') }}',
                    type: 'post',
                    data: {
                        to: to,
                        action: 'setauto'
                    },
                    success: function(res) {

                    },
                    error: function(res) {
                        alert("Erreur");
                    }
                }).always(function() {
                    $('[txldr]').removeClass();
                    ip.attr('disabled', false);
                })
            });

            $('[remotetx]').click(function() {
                var btn = $(this);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                btn.attr('disabled', true);
                $.ajax({
                    'url': '{{ route('taux.store') }}',
                    type: 'post',
                    data: {
                        action: 'remote'
                    },
                    success: function(res) {
                        getdata();
                    },
                    error: function(res) {
                        alert("Erreur");
                    }
                }).always(function() {
                    btn.find('span').removeClass();
                    btn.attr('disabled', false);
                })
            });

            $('#f-add').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                var data = new FormData(form[0]);
                $.ajax({
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
                    url: '{{ route('taux.store') }}',
                    success: function(r) {
                        if (r.success) {
                            btn.attr('disabled', false);
                            rep.removeClass().addClass('text-success');
                            getdata();
                            setTimeout(() => {
                                $('.modal').modal('hide');
                            }, 2000);
                        } else {
                            btn.attr('disabled', false);
                            rep.removeClass().addClass('text-danger');
                        }
                        btn.find('span').removeClass();
                        rep.html(r.message);
                    },
                    error: function(r) {
                        btn.attr('disabled', false);
                        btn.find('span').removeClass();
                        alert("une erreur s'est produite");
                    }
                });
            });

            $('[name="usd_cdf"]').keyup(function() {
                var val = $(this).val();
                $('[name="cdf_usd"]').val(1 / val);
            });

            $('[name=bsms]').change(function() {
                var ip = $(this);
                var to = $(this).is(':checked') ? 'yes' : 'no';
                $('[smsldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                ip.attr('disabled', true);
                $.ajax({
                    'url': '{{ route('config.store') }}',
                    type: 'post',
                    data: {
                        value: to,
                        name: 'sms'
                    },
                    success: function(res) {

                    },
                    error: function(res) {
                        alert("Erreur");
                    }
                }).always(function() {
                    $('[smsldr]').removeClass();
                    ip.attr('disabled', false);
                })
            });
        });
    </script>

</body>

</html>
