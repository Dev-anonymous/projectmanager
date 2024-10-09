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
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Transactions Récentes
                                        </div>
                                    </div>
                                    <div class="card-body" style="height: 400px; overflow: auto;">
                                        <ul class="list-unstyled mb-0" recenttrans></ul>
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
                        var series = [data.nbchauffeurs, data.nbagents, data.nbadmins];

                        var transchartseries = data.transchart;
                        transchart.updateSeries(transchartseries);

                        var html = '';
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
                                    <div class="text-end" >
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

                        $('[soldeusd]').html(data.solde_usd);
                        $('[soldecdf]').html(data.solde_cdf);

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

            var options2 = {
                series: [],
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
