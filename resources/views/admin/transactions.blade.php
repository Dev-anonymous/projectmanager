<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Transactions | {{ config('app.name') }} </title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Transactions</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-primary">
                                                <i class="ti ti-wallet fs-16"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">CASH</span>
                                            <span cashval></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-secondary">
                                                <i class="ti ti-wallet fs-16"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">ILLICO CASH</span>
                                            <span illicoval></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-warning">
                                                <i class="ti ti-wallet fs-16"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">MOBILE MONEY</span>
                                            <span mobileval></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-success">
                                                <i class="ti ti-wallet fs-16"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="d-block text-muted">CARTE BANCAIRE</span>
                                            <span carteval></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Transactions</div>
                                <div class="m-2">
                                    <div class="">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-text text-muted"> <i
                                                        class="ri-calendar-line"></i> </div>
                                                <input type="text" class="form-control" id="daterange"
                                                    placeholder="Date">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover table-condensed text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th style="width:5px!important"><span ldr></span></th>
                                                <th>Client</th>
                                                <th>Montant</th>
                                                <th>Agent</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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

    <x-js-file />
    <x-datatable />

    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            flatpickr("#daterange", {
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: ["{{ now()->subdays(3)->format('Y-m-d') }}", "{{ date('Y-m-d') }}"],
                maxDate: "{{ date('Y-m-d') }}",
            });

            var table = $('#table');
            table.DataTable();

            function getdata() {
                $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('depot.index') }}',
                    data: {
                        date: $('#daterange').val()
                    },
                    success: function(res) {
                        table.DataTable().destroy();
                        var data = res.data;
                        var cash = data.cash;
                        var illico_cash = data.illico_cash;
                        var mobile_money = data.mobile_money;
                        var carte_bancaire = data.carte_bancaire;

                        var txt = [];
                        cash.forEach((el) => {
                            txt.push(`<span class="fs-16 fw-semibold">${el}</span>`);
                        });
                        $('[cashval]').html(txt.join('<br>'));

                        var txt = [];
                        illico_cash.forEach((el) => {
                            txt.push(`<span class="fs-16 fw-semibold">${el}</span>`);
                        });
                        $('[illicoval]').html(txt.join('<br>'));

                        var txt = [];
                        mobile_money.forEach((el) => {
                            txt.push(`<span class="fs-16 fw-semibold">${el}</span>`);
                        });
                        $('[mobileval]').html(txt.join('<br>'));

                        var txt = [];
                        carte_bancaire.forEach((el) => {
                            txt.push(`<span class="fs-16 fw-semibold">${el}</span>`);
                        });
                        $('[carteval]').html(txt.join('<br>'));

                        var html = '';
                        res.data.trans.forEach((user, i) => {
                            html += `<tr title="Montant reçu ${user.trans.montantrecu}">
                            <td class='p-0'>${i+1}</td>
                            <td class='p-0'>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <a href="javascript:void(0);">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <span class="avatar avatar-lg">
                                                            <img src="${user.user.image}" alt="">
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fw-semibold">${user.user.name}</p>
                                                        <p class="mb-0 fs-11 text-success fw-semibold">${user.user.phone}</p>
                                                        <p class="mb-0 fs-11 text-success fw-semibold">${user.user.email}</p>
                                                        <p class="mb-0 fs-11 text-success fw-semibold">${user.user.code??''}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <td class='p-0'>${user.trans.type}<i></i><br>
                                <span style="font-size:15px; font-weight:900">${user.trans.montant} <span class='text-danger'>(-${user.trans.commission}%)</span>
                                <br><b class='text-success'>+${user.trans.montantrecu}</b>
                            </td>
                            <td class='p-0'>${user.trans.agent}</td>
                            <td class='p-0'>${user.trans.date}</td>
                        </tr>
                        `;
                        });
                        table.find('tbody').html(html);
                        table.DataTable({
                            order: [],
                            dom: 'Bflrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                            layout: {
                                topStart: 'buttons'
                            }
                        });
                    },
                    error: function(res) {

                    }
                }).always(function() {
                    $('span[ldr]').removeClass();
                })
            }
            getdata();

            $('#daterange').change(function() {
                var v = this.value;
                if (v.length >= 20) {
                    getdata();
                }
            })
        });
    </script>

</body>

</html>
