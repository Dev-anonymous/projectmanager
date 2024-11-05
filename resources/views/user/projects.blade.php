<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Projets | {{ config('app.name') }} </title>
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
                                <li class="breadcrumb-item active" aria-current="page">Projets</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Projets</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th style="width:5px!important"><span ldr></span></th>
                                                <th>Projet</th>
                                                {{-- <th>Budget</th> --}}
                                                <th>Status</th>
                                                <th>Progression</th>
                                                <th>Date Début/Fin</th>
                                                <th></th>
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

    <script>
        $(document).ready(function() {

            var table = $('#table');
            table.DataTable();

            function getdata() {
                $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('project.index') }}',
                    success: function(res) {
                        table.DataTable().destroy();
                        var html = '';
                        res.data.forEach((user, i) => {
                            var st = user.status;

                            var s = '';
                            var btn = '';
                            if (0 == st) {
                                s = '<span class="badge bg-warning">EN COURS</span>';
                            }
                            if (1 == st) {
                                s = '<span class="badge bg-success">FINI</span>'
                            }

                            var cl = 'success';
                            if (user.progress < 50) {
                                cl = 'danger';
                            }
                            if (user.progress >= 50 && user.progress <= 99) {
                                cl = 'warning';
                            }

                            html += `<tr>
                            <td>${i+1}</td>
                            <td>${user.name}</td>
                            <td>${s}</td>
                            <td>
                                <div class="task-details-progress">
                                    <div class="d-flex align-items-center">
                                        <div class="progress progress-xs progress-animate flex-fill me-2" role="progressbar" aria-valuenow="${user.progress}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-${cl}" style="width: ${user.progress}%"></div>
                                        </div>
                                        <div class="text-muted fs-11">${user.progress}%</div>
                                    </div>
                                </div>
                            </td>
                            <td>${user.startdate} ... ${user.enddate}</td>
                            <td>
                                <div class='d-flex justify-content-end'>
                                    <a href="{{ route('user.projects', ['item' => '']) }}${user.id}" class="btn btn-outline-info btn-sm m-1"   ><i class='bx bxs-cog'></i></a>
                                </div>
                            </td>
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
        });
    </script>

</body>

</html>
