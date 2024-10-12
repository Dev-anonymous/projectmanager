<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Profil | {{ config('app.name') }} </title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Profil</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profil</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="accordion accordion-primary" id="accordionPrimaryExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingPrimaryOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapsePrimaryOne" aria-expanded="true"
                                                aria-controls="collapsePrimaryOne">
                                                Mon Profil
                                            </button>
                                        </h2>
                                        <div id="collapsePrimaryOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingPrimaryOne" style="">
                                            <div class="accordion-body">
                                                @php
                                                    $user = auth()->user();
                                                    $img = userimage($user);
                                                @endphp
                                                <div class="card custom-card">
                                                    <a href="javascript:void(0);" class="card-anchor"></a>
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3">
                                                                <span class="avatar avatar-xl">
                                                                    <img src="{{ $img }}" alt="img">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <p class="card-text text-info mb-1 fs-14 fw-semibold">
                                                                    {{ $user->name }}
                                                                </p>
                                                                <div class="card-title fs-12 mb-1">
                                                                    <p class="m-0">{{ $user->phone }}</p>
                                                                    <p class="m-0">{{ $user->email }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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
                var to = $(this).is(':checked') ? 1 : 0;
                $('[txldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
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
            })
        });
    </script>

</body>

</html>
