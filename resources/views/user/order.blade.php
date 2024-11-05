<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Commandes | {{ config('app.name') }} </title>
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
                                <li class="breadcrumb-item active" aria-current="page">Commandes</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Mes Commandes</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th style="width:5px!important"><span ldr></span></th>
                                                <th>ID</th>
                                                <th>Total Cmd</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order as $k => $el)
                                                <tr style="cursor: pointer">
                                                    <td>{{ $k + 1 }}</td>
                                                    <td>{{ $el->ref }}</td>
                                                    <td>{{ v($el->total_cdf, 'CDF') }}</td>
                                                    <td>{{ $el->date?->format('d-m-Y H:i:s') }}</td>
                                                    <td>
                                                        <a href="#mdl{{ $el->id }}"
                                                            class="modal-effect btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                                            data-bs-effect="effect-flip-vertical"
                                                            data-bs-toggle="modal"><i
                                                                class='ri-eye-line align-middle'></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($order as $k => $el)
            <div class="modal fade" id="mdl{{ $el->id }}">
                <div class="modal-dialog  text-center" role="document">
                    <div class="modal-content modal-content-demo">
                        <form action="#" id="fdel">
                            <div class="modal-body text-start">
                                <h6>Articles commandés</h6>
                                <div class="table-responsive">
                                    <table id="table2" class="table table-hover text-nowrap w-100">
                                        <thead>
                                            <th>#</th>
                                            <th>Article</th>
                                            <th>Qte</th>
                                            <th>Prix</th>
                                            <th>Total</th>
                                        </thead>

                                        @php
                                            $articles = (array) json_decode($el->articles);
                                        @endphp
                                        <tbody>
                                            @foreach ($articles as $k2 => $el2)
                                                <tr>
                                                    <td>{{ $k2 + 1 }}</td>
                                                    <td>{{ $el2->name }}</td>
                                                    <td>{{ $el2->qty }}</td>
                                                    <td>{{ v($el2->price, 'CDF') }}</td>
                                                    <td>{{ $el2->total }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light btn-sm" data-bs-dismiss="modal"
                                    type="button">Fermer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <x-footer />
    </div>

    <div id="responsive-overlay"></div>

    <x-js-file />
    <x-datatable />

    <script>
        $(document).ready(function() {
            var table = $('#table');
            table.DataTable();
        });
    </script>

</body>

</html>
