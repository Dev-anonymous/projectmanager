<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Dashboard | {{ config('app.name') }} </title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-3">
                            <span ldr></i></span>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-12">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-body" style="min-height: 135px">
                                        <div class="row">
                                            <div
                                                class="col-xxl-3 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon px-0">
                                                <span class="rounded p-3 bg-primary-transparent">
                                                    <i class="bx bx-wallet bx-md"></i>
                                                </span>
                                            </div>
                                            <div class="col-xxl-9 col-xl-10 col-lg-9 col-md-9 col-sm-8 col-8 px-0">
                                                <div class="mb-2">CASH</div>
                                                <div class="text-muted mb-1 fs-12">
                                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"
                                                        cashval>
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="fs-12 mb-0" cemois></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-body" style="min-height: 135px">
                                        <div class="row">
                                            <div
                                                class="col-xxl-3 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon secondary  px-0">
                                                <span class="rounded p-3 bg-primary-transparent">
                                                    <i class="bx bx-wallet bx-md"></i>
                                                </span>
                                            </div>
                                            <div class="col-xxl-9 col-xl-10 col-lg-9 col-md-9 col-sm-8 col-8 px-0">
                                                <div class="mb-2">ILLICO CASH</div>
                                                <div class="text-muted mb-1 fs-12">
                                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"
                                                        illicoval></span>
                                                </div>
                                                <div><span class="fs-12 mb-0" cemois></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <div class="card custom-card" style="min-height: 135px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div
                                                class="col-xxl-3 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon success px-0">
                                                <span class="rounded p-3 bg-success-transparent">
                                                    <i class="bx bx-wallet bx-md"></i>
                                                </span>
                                            </div>
                                            <div class="col-xxl-9 col-xl-10 col-lg-9 col-md-9 col-sm-8 col-8 px-0">
                                                <div class="mb-2">CARTE BANCAIRE</div>
                                                <div class="text-muted mb-1 fs-12">
                                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"
                                                        carteval></span>
                                                </div>
                                                <div><span class="fs-12 mb-0" cemois></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-body" style="min-height: 135px">
                                        <div class="row">
                                            <div
                                                class="col-xxl-3 col-xl-2 col-lg-3 col-md-3 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon warning px-0">
                                                <span class="rounded p-3 bg-warning-transparent">
                                                    <i class="bx bx-wallet bx-md"></i>
                                                </span>
                                            </div>
                                            <div class="col-xxl-9 col-xl-10 col-lg-9 col-md-9 col-sm-8 col-8 px-0">
                                                <div class="mb-2">MOBILE MONEY</div>
                                                <div class="text-muted mb-1 fs-12">
                                                    <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"
                                                        mobileval></span>
                                                </div>
                                                <div><span class="fs-12 mb-0" cemois></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Transactions Récentes
                                        </div>
                                    </div>
                                    <div class="card-body" style="height: 510px; overflow: auto;">
                                        <ul class="list-unstyled mb-0" recenttrans></ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">Transactions</div>
                                    </div>
                                    <div class="card-body">
                                        <div id="transchart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Utilisateurs
                                        </div>
                                    </div>
                                    <div class="card-body p-0 overflow-hidden">
                                        <div
                                            class="leads-source-chart d-flex align-items-center justify-content-center">
                                            <div id="cmptgraph"></div>
                                        </div>
                                        <div class="row row-cols-12 border-top border-block-start-dashed">
                                            <div class="col p-0">
                                                <a href="{{ route('admin.drivers') }}">
                                                    <div
                                                        class="ps-4 py-3 pe-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend mobile d-inline-block">Chauffeurs
                                                        </span>
                                                        <div>
                                                            <span class="fs-16 fw-semibold" nbchauffeurs></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col p-0">
                                                <a href="{{ route('admin.agents') }}">
                                                    <div class="p-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend desktop d-inline-block">Agents
                                                        </span>
                                                        <div><span class="fs-16 fw-semibold" nbagents></span></div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col p-0">
                                                <a href="{{ route('admin.admins') }}">
                                                    <div class="p-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend laptop d-inline-block">Admins
                                                        </span>
                                                        <div><span class="fs-16 fw-semibold" nbadmins></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
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
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Top Chauffeurs
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-hover" table>
                                        <thead>
                                            <tr>
                                                <th scope="col">Chauffeur</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Tel</th>
                                                <th scope="col">Solde USD</th>
                                                <th scope="col">Solde CDF</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <a href="{{ route('admin.drivers') }}">
                                            Tout voir <i class="bi bi-arrow-right ms-2 fw-semibold"></i>
                                        </a>
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

    <x-js-file />
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        $(function() {

            var ldr = true;

            function getdata(interval = false) {
                if (ldr) {
                    ldr = false;
                    $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-lg');
                }
                $.ajax({
                    'url': '{{ route('dash.index') }}',
                    success: function(data) {
                        $('[nbchauffeurs]').html(data.nbchauffeurs);
                        $('[nbadmins]').html(data.nbadmins);
                        $('[nbagents]').html(data.nbagents);

                        var series = [data.nbchauffeurs, data.nbagents, data.nbadmins];

                        cmptgraph.updateSeries(series);

                        var transchartseries = data.transchart;
                        transchart.updateSeries(transchartseries);

                        var html = '';
                        var topdrivers = data.topdrivers;
                        $(topdrivers).each(function(i, e) {
                            html += `
                                <tr>
                                    <td class='p-2'>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 lh-1">
                                                <span class="avatar avatar-sm">
                                                    <img src="${e.image}" alt="">
                                                </span>
                                            </div>
                                            <div class="fs-14">${e.name}</div>
                                        </div>
                                    </td>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.email}</span>
                                    </td>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.phone}</span>
                                    </td>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.solde_usd}</span>
                                    </td>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.solde_cdf}</span>
                                    </td>
                                </tr>
                            `;
                        });
                        $('[table]').find('tbody').html(html);

                        html = '';
                        var recenttrans = data.recenttrans;
                        $(recenttrans).each(function(i, e) {
                            html += `
                            <li class="mb-3" title="Montant reçu ${e.trans.montantrecu}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="lh-1">
                                            <span class="avatar avatar-md">
                                                <img src="${e.user.image}"
                                                    alt="">
                                            </span>
                                        </div>
                                        <div class="p-2">
                                            <p class="mb-0 fw-semibold">${e.user.name}</p>
                                            <p class="mb-0 fs-11 text-success fw-semibold">${e.user.phone}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold">
                                            ${e.trans.montant} <span class='text-danger'>(-${e.trans.commission}%)</span>
                                            <br>
                                            <b class='text-success'>+${e.trans.montantrecu}</b>
                                        </p>
                                        <p class="mb-0 op-7 text-muted fs-11">
                                            ${e.trans.type}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            `;
                        });
                        $('[recenttrans]').html(html);

                        $('[cemois]').html(data.cemois);
                        $('[cashval]').html(data.cash.join('<br>'));
                        $('[illicoval]').html(data.illico_cash.join('<br>'));
                        $('[mobileval]').html(data.mobile_money.join('<br>'));
                        $('[carteval]').html(data.carte_bancaire.join('<br>'));


                    },
                    error: function(res) {

                    }
                }).always(function() {
                    $('span[ldr]').removeClass();
                    if (interval) {
                        setTimeout(() => {
                            getdata(true);
                        }, 3000);
                    }
                })
            }
            getdata(true);

            var options = {
                series: [],
                chart: {
                    height: 290,
                    type: "pie",
                },
                labels: ["Chauffeurs", "Agents", "Admins"],
                theme: {
                    monochrome: {
                        enabled: true,
                        color: "#845adf",
                    },
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            offset: -5,
                        },
                    },
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex];
                        return [name];
                    },
                    dropShadow: {
                        enabled: false,
                    },
                },
                legend: {
                    show: false,
                },
            };
            var cmptgraph = new ApexCharts(document.querySelector("#cmptgraph"), options);
            cmptgraph.render();

            var options2 = {
                series: [
                    // {
                    //     type: 'line',
                    //     name: 'Carte_bancaire',
                    //     data: [{
                    //             x: 'Jan',
                    //             y: 200
                    //         },
                    //         {
                    //             x: 'Feb',
                    //             y: 310
                    //         },
                    //         {
                    //             x: 'Mar',
                    //             y: 280
                    //         },
                    //         {
                    //             x: 'Apr',
                    //             y: 454
                    //         },
                    //         {
                    //             x: 'May',
                    //             y: 30
                    //         },
                    //         {
                    //             x: 'Jun',
                    //             y: 420
                    //         },
                    //         {
                    //             x: 'Jul',
                    //             y: 556
                    //         },
                    //         {
                    //             x: 'Aug',
                    //             y: 230
                    //         },
                    //         {
                    //             x: 'Sep',
                    //             y: 350
                    //         },
                    //         {
                    //             x: 'Oct',
                    //             y: 350
                    //         },
                    //         {
                    //             x: 'Nov',
                    //             y: 210
                    //         },
                    //         {
                    //             x: 'Dec',
                    //             y: 410
                    //         }
                    //     ]
                    // },
                    // {
                    //     type: 'line',
                    //     name: 'Mobile_money',
                    //     data: [{
                    //             x: 'Jan',
                    //             y: 100
                    //         },
                    //         {
                    //             x: 'Feb',
                    //             y: 210
                    //         },
                    //         {
                    //             x: 'Mar',
                    //             y: 180
                    //         },
                    //         {
                    //             x: 'Apr',
                    //             y: 454
                    //         },
                    //         {
                    //             x: 'May',
                    //             y: 230
                    //         },
                    //         {
                    //             x: 'Jun',
                    //             y: 320
                    //         },
                    //         {
                    //             x: 'Jul',
                    //             y: 656
                    //         },
                    //         {
                    //             x: 'Aug',
                    //             y: 830
                    //         },
                    //         {
                    //             x: 'Sep',
                    //             y: 350
                    //         },
                    //         {
                    //             x: 'Oct',
                    //             y: 350
                    //         },
                    //         {
                    //             x: 'Nov',
                    //             y: 210
                    //         },
                    //         {
                    //             x: 'Dec',
                    //             y: 410
                    //         }
                    //     ]
                    // },
                    // {
                    //     type: 'line',
                    //     name: 'Illico_cash',
                    //     chart: {
                    //         dropShadow: {
                    //             enabled: true,
                    //             enabledOnSeries: undefined,
                    //             top: 5,
                    //             left: 0,
                    //             blur: 3,
                    //             color: '#000',
                    //             opacity: 0.1
                    //         }
                    //     },
                    //     data: [{
                    //             x: 'Jan',
                    //             y: 180
                    //         },
                    //         {
                    //             x: 'Feb',
                    //             y: 620
                    //         },
                    //         {
                    //             x: 'Mar',
                    //             y: 476
                    //         },
                    //         {
                    //             x: 'Apr',
                    //             y: 220
                    //         },
                    //         {
                    //             x: 'May',
                    //             y: 520
                    //         },
                    //         {
                    //             x: 'Jun',
                    //             y: 780
                    //         },
                    //         {
                    //             x: 'Jul',
                    //             y: 435
                    //         },
                    //         {
                    //             x: 'Aug',
                    //             y: 515
                    //         },
                    //         {
                    //             x: 'Sep',
                    //             y: 738
                    //         },
                    //         {
                    //             x: 'Oct',
                    //             y: 454
                    //         },
                    //         {
                    //             x: 'Nov',
                    //             y: 525
                    //         },
                    //         {
                    //             x: 'Dec',
                    //             y: 230
                    //         }
                    //     ]
                    // },
                    // {
                    //     type: 'area',
                    //     name: 'Cash',
                    //     chart: {
                    //         dropShadow: {
                    //             enabled: true,
                    //             enabledOnSeries: undefined,
                    //             top: 5,
                    //             left: 0,
                    //             blur: 3,
                    //             color: '#000',
                    //             opacity: 0.1
                    //         }
                    //     },
                    //     data: [{
                    //             x: 'Jan',
                    //             y: 200
                    //         },
                    //         {
                    //             x: 'Feb',
                    //             y: 530
                    //         },
                    //         {
                    //             x: 'Mar',
                    //             y: 110
                    //         },
                    //         {
                    //             x: 'Apr',
                    //             y: 130
                    //         },
                    //         {
                    //             x: 'May',
                    //             y: 480
                    //         },
                    //         {
                    //             x: 'Jun',
                    //             y: 520
                    //         },
                    //         {
                    //             x: 'Jul',
                    //             y: 780
                    //         },
                    //         {
                    //             x: 'Aug',
                    //             y: 435
                    //         },
                    //         {
                    //             x: 'Sep',
                    //             y: 475
                    //         },
                    //         {
                    //             x: 'Oct',
                    //             y: 738
                    //         },
                    //         {
                    //             x: 'Nov',
                    //             y: 454
                    //         },
                    //         {
                    //             x: 'Dec',
                    //             y: 480
                    //         }
                    //     ]
                    // }
                ],
                chart: {
                    height: 350,
                    animations: {
                        speed: 500,
                        enabled: false,
                    },
                    dropShadow: {
                        enabled: true,
                        enabledOnSeries: undefined,
                        top: 8,
                        left: 0,
                        blur: 3,
                        color: '#000',
                        opacity: 0.1
                    },
                    zoom: {
                        enabled: false,
                    }
                },
                colors: ["rgba(120, 190, 12, 0.75)", "rgb(132, 90, 223)", "rgba(35, 183, 229, 0.5)",
                    "rgba(119, 119, 142, 0.15)"
                ],
                dataLabels: {
                    enabled: false
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 3
                },
                stroke: {
                    curve: 'smooth',
                    width: [2, 2, 2, 2],
                    dashArray: [0, 5, 0],
                },
                xaxis: {
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return "$ " + value;
                        }
                    },
                },
                tooltip: {
                    y: [{
                        formatter: function(e) {
                            return void 0 !== e ? "$" + e.toFixed(3) : e
                        }
                    }, ]
                },
                legend: {
                    show: true,
                },
                markers: {
                    hover: {
                        sizeOffset: 5
                    }
                }
            };
            var transchart = new ApexCharts(document.querySelector("#transchart"), options2);
            transchart.render();
        })
    </script>

</body>

</html>
