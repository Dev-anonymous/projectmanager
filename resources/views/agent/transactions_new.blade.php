<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Nouvelle Transaction | {{ config('app.name') }} </title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Nouvelle Transaction</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Nouvelle Transaction</div>
                                <div class="m-2">
                                    <div class="">
                                        <a class="btn btn-danger-light btn-border-down btn-sm btn-wave waves-effect waves-light"
                                            href="{{ route('agent.transactions') }}">Retour
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <form action="#" id="fpay">
                                            <div class="form-group mb-2">
                                                <label for="signin-username"
                                                    class="form-label text-default">Chauffeur</label>
                                                <select name="users_id" id="" class="form-control select2"
                                                    required>
                                                    <option value="">Choisir un chauffeur</option>
                                                    @foreach ($chauffeurs as $el)
                                                        <option value="{{ $el->id }}">
                                                            {{ $el->name }}###{{ $el->code }}###{{ $el->phone }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="signin-username" class="form-label text-default">Mode de
                                                    paiement</label>
                                                <select name="type" id="" class="form-control">
                                                    @foreach (modepaie() as $el)
                                                        <option> {{ strtoupper($el) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="signin-username" class="form-label text-default">
                                                    Montant
                                                </label>
                                                <div class="input-group mb-3 d-flex flex-nowrap">
                                                    <input required type="text" name="montant" id="amount"
                                                        class="form-control form-control-sm crypto-buy-sell-input"
                                                        placeholder="Montant">
                                                    <select class="form-control" data-trigger name="devise"
                                                        id="choices-single-default2">
                                                        <option>CDF</option>
                                                        <option>USD</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="divmobile hidediv" style="display: none">
                                                <div class="form-group mb-2">
                                                    <label for="signin-username" class="form-label text-default">
                                                        Téléphone <span label></span>
                                                    </label>
                                                    <input type="text" id="phone_number" name="phone"
                                                        value="" class="form-control" placeholder="Ex : 099xxx">
                                                </div>
                                            </div>
                                            <div class="divcarte hidediv" style="display: none">
                                                <div class="form-group">
                                                    <label for="card_number" class="form-label text-default">Numéro de
                                                        carte</label>
                                                    <input type="text" id="card_number" class="form-control"
                                                        minlength="16" name="card_number">
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="expiry_date"
                                                                class="form-label text-default">Date
                                                                d'expiration</label>
                                                            <input type="text" class="form-control" id="expiry_date"
                                                                name="expiry_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cvv"
                                                                class="form-label text-default">CVV</label>
                                                            <input type="text" id="cvv" class="form-control"
                                                                name="cvv">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <div id="rep"></div>
                                            </div>
                                            <div class="">
                                                <button
                                                    class="btn btn-info m-2 btn-sm btn-wave waves-effect waves-light"
                                                    type="submit"> <span></span> Valider
                                                </button>
                                                <button cancelbtn style="display: none"
                                                    class="btn m-2 btn-warning btn-sm btn-wave waves-effect waves-light"
                                                    type="button">
                                                    Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footer />
    </div>

    <div id="responsive-overlay"></div>

    <div class="modal fade" id="otpmdl" data-bs-backdrop="static">
        <div class="modal-dialog  text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Confirmer le paiement Illico Cash </h6><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" id="f-otp">
                    <div class="modal-body text-start">
                        <div class="col-xl-12">
                            <label for="illico_otp">Code OTP</label>
                            <input type="text" id="illico_otp" minlength="6" placeholder="XXXXXX"
                                class="form-control" name="otp" required>
                        </div>
                        <div class="mt-2">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button class="btn btn-primary" type="submit"><span></span> Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlconf" data-bs-backdrop="static">
        <div class="modal-dialog  text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Confirmer la transaction </h6><button aria-label="Close"
                        class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                    <h3>Voulez vous confirmer cette transaction Cash ?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button class="btn btn-primary" btncash><span></span> Confirmer</button>
                </div>

            </div>
        </div>
    </div>

    <x-js-file />
    <x-datatable />

    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.css') }}">
    <script src="{{ asset('assets/imask.js') }}"></script>
    <script>
        $(document).ready(function() {
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var tab = JSON.parse('{!! $img !!}');
                var img = tab[state.element.value];

                var txt = state.text.split('###');
                var $state = $(
                    `<span><img src="${img}" class="img-flag" > ${txt[0]}</span><span> (${txt[2]})</span>`
                );
                return $state;
            };

            $(".select2").select2({
                templateResult: formatState,
                templateSelection: formatState,
            });

            IMask(
                document.getElementById('amount'), {
                    mask: 'num',
                    blocks: {
                        num: {
                            mask: Number,
                            thousandsSeparator: ' '
                        }
                    }
                }
            )

            IMask(
                document.getElementById('phone_number'), {
                    mask: '0000000000'
                }
            );
            IMask(
                document.getElementById('illico_otp'), {
                    mask: '000000'
                }
            );
            IMask(
                document.getElementById('card_number'), {
                    mask: '0000000000000000'
                }
            );
            IMask(
                document.getElementById('cvv'), {
                    mask: '0000000'
                }
            );
            IMask(
                document.getElementById('expiry_date'), {
                    mask: 'MM/AA 00/00',
                    lazy: false,
                    overwrite: 'shift',
                }
            );

            var seltype = $('select[name=type]');

            function showinput() {
                var v = seltype.val();
                $('.hidediv').stop().slideUp();
                if (v == 'MOBILE_MONEY' || 'ILLICO_CASH' == v) {
                    $('.divmobile').stop().slideDown();
                    if (v == 'MOBILE_MONEY') {
                        $('span[label]').html('Mobile Money');
                    }
                    if (v == 'ILLICO_CASH') {
                        $('span[label]').html('Illico Cash');
                    }
                }
                if (v == 'CARTE_BANCAIRE') {
                    $('.divcarte').stop().slideDown();
                }
            }

            showinput();
            seltype.change(function() {
                showinput();
            });

            var formpay = $('#fpay');
            var cancelbtn = $('[cancelbtn]');

            formpay.submit(function() {
                event.preventDefault();
                var type = $('[name=type]').val();
                if ('CASH' == type) {
                    $('#mdlconf').modal('show');
                }
                if ('ILLICO_CASH' == type) {
                    illicopay();
                }
                if ('MOBILE_MONEY' == type) {
                    mobilepay();
                }
                if ('CARTE_BANCAIRE' == type) {
                    cartepay();
                }
            });

            $('[btncash]').click(function() {
                $('.modal').modal('hide');
                cashpay();
            });

            var uid = $('[name=users_id]');

            function filln() {
                var v = $('option:selected', uid).text();
                if (v) {
                    v = v.split('###');
                    v = v[v.length - 1];
                    if (v) {
                        v = v.trim();
                        $('[name=phone]').val(v);
                    }
                }
            }
            filln();
            uid.change(function() {
                filln();
            })

            function cashpay() {
                var data = formpay.serialize();
                var re = $('#rep', formpay);
                re.removeClass().html('');

                $(':input', formpay).attr('disabled', true);
                var btn = $(':submit', formpay);
                btn.find('span').removeClass().addClass('bx bx-loader bx-spin');

                $.ajax({
                    type: 'post',
                    url: '{{ route('cpa') }}',
                    data: data,
                    success: function(r) {
                        if (r.success) {
                            re.removeClass().removeClass().addClass('alert alert-success');
                            $(':input', formpay).attr('disabled', false);
                            setTimeout(() => {
                                location.assign('{{ route('agent.transactions') }}');
                            }, 3000);
                        } else {
                            re.removeClass().addClass('alert alert-danger').addClass(
                                'alert alert-danger');
                        }
                        re.html(r.message);
                    },
                    error: function(r) {
                        re.removeClass().addClass('alert alert-danger').html(
                            "une erreur s'est produite");
                    }
                }).always(function() {
                    $(':input', formpay).attr('disabled', false);
                    btn.find('span').removeClass();
                });
            }

            function illicopay() {
                var data = formpay.serialize();
                var re = $('#rep', formpay);
                re.removeClass().html('');

                $(':input', formpay).attr('disabled', true);
                var btn = $(':submit', formpay);
                btn.find('span').removeClass().addClass('bx bx-loader bx-spin');

                $.ajax({
                    type: 'post',
                    url: '{{ route('sti') }}',
                    data: data,
                    success: function(r) {
                        if (r.success) {
                            re.removeClass().removeClass().addClass('alert alert-success');
                            $(':input', formpay).attr('disabled', false);
                            REF = r.ref;
                            setTimeout(() => {
                                $('#otpmdl').modal('show');
                            }, 2000);
                        } else {
                            re.removeClass().addClass('alert alert-danger').addClass(
                                'alert alert-danger');
                        }
                        re.html(r.message);
                    },
                    error: function(r) {
                        re.removeClass().addClass('alert alert-danger').html(
                            "une erreur s'est produite");
                    }
                }).always(function() {
                    $(':input', formpay).attr('disabled', false);
                    btn.find('span').removeClass();
                });
            }

            $('#f-otp').submit(function() {
                event.preventDefault();

                var formpay = $(this);
                var data = formpay.serialize();
                var re = $('#rep', formpay);
                re.removeClass().html('');

                $(':input', formpay).attr('disabled', true);
                var btn = $(':submit', formpay);
                btn.find('span').removeClass().addClass('bx bx-loader bx-spin');
                data = data + '&ref=' + REF;
                $.ajax({
                    type: 'post',
                    url: '{{ route('cmi') }}',
                    data: data,
                    success: function(r) {
                        if (r.success) {
                            re.removeClass().removeClass().addClass('alert alert-success');
                            $(':input', formpay).attr('disabled', false);
                            setTimeout(() => {
                                location.assign('{{ route('agent.transactions') }}');
                            }, 3000);
                        } else {
                            re.removeClass().addClass('alert alert-danger').addClass(
                                'alert alert-danger');
                        }
                        re.html(r.message);
                    },
                    error: function(r) {
                        re.removeClass().addClass('alert alert-danger').html(
                            "une erreur s'est produite");
                    }
                }).always(function() {
                    $(':input', formpay).attr('disabled', false);
                    btn.find('span').removeClass();
                });
            });

            function mobilepay() {
                var data = formpay.serialize();
                var re = $('#rep', formpay);
                re.removeClass().html('');

                $(':input', formpay).attr('disabled', true);
                var btn = $(':submit', formpay);
                btn.find('span').removeClass().addClass('bx bx-loader bx-spin');

                $.ajax({
                    type: 'post',
                    url: '{{ route('fpi') }}',
                    data: data,
                    success: function(r) {
                        if (r.success) {
                            re.removeClass().removeClass().addClass('alert alert-success');
                            REF = r.ref;
                            callback();
                            btn.html(
                                '<span class="bx bx-loader bx-spin"></span> En attente de validation'
                            );
                            cancelbtn.slideDown().attr('disabled', false);

                        } else {
                            $(':input', formpay).attr('disabled', false);
                            btn.find('span').removeClass();
                            re.removeClass().addClass('alert alert-danger').addClass(
                                'alert alert-danger');
                        }
                        re.html(r.message);
                    },
                    error: function(r) {
                        $(':input', formpay).attr('disabled', false);
                        btn.find('span').removeClass();
                        re.removeClass().addClass('alert alert-danger').html(
                            "une erreur s'est produite");
                    }
                });
            }

            cancelbtn.click(function() {
                var ok = confirm("Voulez vous annuler la transaction ?");
                if (ok) {
                    location.reload();
                }
            })

            REF = '';

            var callback = function() {
                $.ajax({
                    url: '{{ route('fpc') }}',
                    type: 'post',
                    data: {
                        ref: REF
                    },
                    success: function(res) {
                        var trans = res.transaction;
                        var status = trans?.status;
                        if (status === 'success') {
                            var btn = $(':submit', formpay);
                            cancelbtn.slideUp();
                            btn.slideUp();

                            var re = $('#rep', formpay);
                            re.removeClass().addClass('alert alert-success');
                            re.html(res.message);

                            setTimeout(() => {
                                location.assign('{{ route('agent.transactions') }}');
                            }, 3000);

                        } else if (status === 'failed') {
                            var btn = $(':submit', formpay);
                            cancelbtn.slideUp().attr('disabled', false);
                            $(':input', formpay).attr('disabled', false);

                            var re = $('#rep', formpay);
                            re.removeClass().addClass('alert alert-danger');
                            re.html("La transaction a échouée.");
                            btn.html('<span></span> Valider');

                        } else {
                            setTimeout(() => {
                                callback();
                            }, 2000);
                        }
                    },
                    error: function() {
                        setTimeout(() => {
                            callback();
                        }, 2000);
                    }
                });
            }

            function cartepay() {
                var data = formpay.serialize();
                var re = $('#rep', formpay);
                re.removeClass().html('');

                $(':input', formpay).attr('disabled', true);
                var btn = $(':submit', formpay);
                btn.find('span').removeClass().addClass('bx bx-loader bx-spin');

                $.ajax({
                    type: 'post',
                    url: '{{ route('smc') }}',
                    data: data,
                    success: function(r) {
                        if (r.success) {
                            re.removeClass().removeClass().addClass('alert alert-success');
                            setTimeout(() => {
                                var pay_url = r.pay_url;
                                if (pay_url) {
                                    location.assign(pay_url);
                                }
                            }, 2000);

                        } else {
                            $(':input', formpay).attr('disabled', false);
                            btn.find('span').removeClass();
                            re.removeClass().addClass('alert alert-danger').addClass(
                                'alert alert-danger');
                        }
                        re.html(r.message);
                    },
                    error: function(r) {
                        $(':input', formpay).attr('disabled', false);
                        btn.find('span').removeClass();
                        re.removeClass().addClass('alert alert-danger').html(
                            "une erreur s'est produite");
                    }
                });
            }

        });
    </script>

</body>

</html>
