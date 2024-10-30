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
                    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
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
                                <a href="{{ route('admin.projects') }}">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-2">Projets Finis</p>
                                                <h4 class="mb-0 fw-semibold mb-2" projetfini></h4>
                                            </div>
                                            <div>
                                                <span class="avatar avatar-md bg-primary p-2">
                                                    <i class="ti ti-file-check fs-20 op-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <a href="{{ route('admin.projects') }}">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-2">Projets en retard</p>
                                                <h4 class="mb-0 fw-semibold mb-2" projetenretard></h4>
                                            </div>
                                            <div>
                                                <span class="avatar avatar-md bg-secondary p-2">
                                                    <i class="ti ti-briefcase fs-20 op-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <a href="{{ route('admin.projects') }}">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-2">Total Projets</p>
                                                <h4 class="mb-0 fw-semibold mb-2" totalprojet></h4>
                                            </div>
                                            <div>
                                                <span class="avatar avatar-md bg-success p-2">
                                                    <i class="ti ti-album fs-20 op-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                                <a href="{{ route('admin.projects') }}">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-2">Projets en cours</p>
                                                <h4 class="mb-0 fw-semibold mb-2" projetencours></h4>
                                            </div>
                                            <div>
                                                <span class="avatar avatar-md bg-warning p-2">
                                                    <i class="ti ti-chart-pie-2 fs-20 op-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Projets Récents
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
                                        <div class="card-title">Statistiques annuelles des projets</div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart001"></div>
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
                                                <a href="{{ route('admin.users') }}">
                                                    <div
                                                        class="ps-4 py-3 pe-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend mobile d-inline-block">Utilisateurs
                                                        </span>
                                                        <div>
                                                            <span class="fs-16 fw-semibold" nbchauffeurs></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col p-0">
                                                <a href="{{ route('admin.students') }}">
                                                    <div class="p-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend desktop d-inline-block">Etudiants
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
                                    Top projets
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-hover" table>
                                        <thead>
                                            <tr>
                                                <th scope="col">Projet</th>
                                                <th scope="col">Budget</th>
                                                <th scope="col">Progression</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <a href="{{ route('admin.projects') }}">
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
                        $('[projetenretard]').html(data.projetenretard);
                        $('[projetencours]').html(data.projetencours);
                        $('[projetfini]').html(data.projetfini);
                        $('[totalprojet]').html(data.totalprojet);

                        var series = [data.nbclients, data.nbstudents, data.nbadmins];

                        cmptgraph.updateSeries(series);

                        chart001.updateSeries(data.chart001);

                        var html = '';
                        var topproject = data.topproject;
                        $(topproject).each(function(i, e) {
                            var cl = 'success';
                            if (e.progress < 50) {
                                cl = 'danger';
                            }
                            if (e.progress >= 50 && e.progress <= 99) {
                                cl = 'warning';
                            }
                            html += `
                                <tr>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.name}</span>
                                    </td>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.budget}</span>
                                    </td>
                                    <td>
                                        <div class="task-details-progress">
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-xs progress-animate flex-fill me-2" role="progressbar" aria-valuenow="${e.progress}" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-${cl}" style="width: ${e.progress}%"></div>
                                                </div>
                                                <div class="text-muted fs-11">${e.progress}%</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class='p-2'>
                                        <span class="fw-semibold">${e.startdate} ... ${e.enddate}</span>
                                    </td>
                                </tr>
                            `;
                        });
                        $('[table]').find('tbody').html(html);

                        html = '';
                        var recentproject = data.recentproject;
                        $(recentproject).each(function(i, e) {
                            html += `
                            <li class="mb-3" >
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="lh-1">
                                            <i class="bx bx-check-circle bx-sm"></i>
                                        </div>
                                        <div class="p-2">
                                            <p class="mb-0 fw-semibold">${e.name}</p>
                                            <p class="mb-0 fs-11 text-success fw-semibold">${e.budget}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold">
                                            ${e.startdate}
                                        </p>
                                        <p class="mb-0 op-7 text-muted fs-11">
                                            ${e.enddate}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            `;
                        });
                        $('[recenttrans]').html(html);
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
                labels: ["Clients", "Etudiants", "Admins"],
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
                    // labels: {
                    //     formatter: function(value) {
                    //         return "$ " + value;
                    //     }
                    // },
                },
                tooltip: {
                    // y: [{
                    //     formatter: function(e) {
                    //         return void 0 !== e ? "$" + e.toFixed(3) : e
                    //     }
                    // }, ]
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
            var chart001 = new ApexCharts(document.querySelector("#chart001"), options2);
            chart001.render();
        })
    </script>

</body>

</html>
