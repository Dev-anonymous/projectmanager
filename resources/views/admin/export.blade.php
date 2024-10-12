<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Envoi fonds | {{ config('app.name') }} </title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Envoi fonds</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Envoi fonds</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Envoi fonds</div>

                                <div class="m-2">
                                    <button
                                        class="modal-effect btn btn-teal-light btn-border-down btn-sm btn-wave waves-effect waves-light"
                                        data-bs-effect="effect-flip-vertical" data-bs-toggle="modal"
                                        href="#mdl">Nouvelle exportation
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th style="width:5px!important"><span ldr></span></th>
                                                <th></th>
                                                <th>Créé par</th>
                                                <th>Total USD</th>
                                                <th>Total CDF</th>
                                                <th>Etat</th>
                                                <th>Date</th>
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

        <div class="modal fade" id="mdl" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Nouvelle exportation </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div userzone>
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <h5 class="m-2">Veuillez sélectionner les chauffeurs concernés</h5>
                                </div>
                                <div class="">
                                    <div class="m-2">
                                        <a href="javascript:void(0);" class="btn btn-outline-dark btn-sm" sall>
                                            <i class="bx bx-checkbox bx-"></i>
                                            Tous
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <form action="#" id="fusers">
                                    <table class="table text-nowrap table-sm table-hover" table2>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Contact</th>
                                                <th scope="col">Solde</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $el)
                                                @php
                                                    $pro = $el->profils()->first();
                                                @endphp
                                                <tr id="{{ $el->id }}" style="cursor: pointer">
                                                    <th scope="row">
                                                        <img src="{{ userimage($el) }}" alt="img" width="32"
                                                            height="32" class="rounded-circle">
                                                    </th>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $el->id }}" name="users_id[]"
                                                                id="checkebox-sm{{ $el->id }}">
                                                            <label class="form-check-label">
                                                                {{ $el->name }} <br>
                                                                {{ $el->code }}
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <td>{{ $el->phone }}<br>{{ $el->email }}</td>
                                                    <td>
                                                        <b style="font-size: 18px">
                                                            {{ v($pro->solde_cdf, 'CDF') }}
                                                            <br>
                                                            {{ v($pro->solde_usd, 'USD') }}
                                                        </b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div formzone style="display: none">
                            <div class="">
                                <h5 class="m-2">Veuillez adjuster les montant à envoyer</h5>
                                <form action="#" id="fval">
                                    <div class="table-responsive" formdata>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div id="rep00"></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <form action="#" id="fbtn">
                            <div class="ml-3">
                                <button backbtn style="display: none" class="btn btn-sm btn-outline-primary mr-2"
                                    type="button">
                                    <span class="bx bx-arrow-back"></span> Retour
                                </button>
                                <button nextbtn style="display: none" class="btn btn-sm btn-primary mr-2"
                                    type="button">
                                    <span class="bx bx-arrow-to-right"></span>
                                    Suivant
                                </button>
                                <button donebtn style="display: none" class="btn btn-sm btn-danger mr-2"
                                    type="button">
                                    <span class="bx bx-check-circle"></span>
                                    Valider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delmdl">
        <div class="modal-dialog  text-center" role="document">
            <div class="modal-content modal-content-demo">
                <form action="#" id="fdel">
                    <div class="modal-body text-start">
                        <input type="hidden" name="id">
                        <h3>Confirmer la suppression ?</h3>
                        <div class="mt-2">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" data-bs-dismiss="modal" type="button">NON</button>
                        <button class="btn btn-primary btn-sm" type="submit"><span></span> OUI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showmdl">
        <div class="modal-dialog  text-center" role="document">
            <div class="modal-content modal-content-demo">
                <form action="#" id="fdel">
                    <div class="modal-body text-start">
                        <input type="hidden" name="id">
                        <h5>Détails sur l'exportation</h5>
                        <div class="mt-3 pt-3" detazone>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" data-bs-dismiss="modal" type="button">Fermer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="valmdl">
        <div class="modal-dialog  text-center" role="document">
            <div class="modal-content modal-content-demo">
                <form action="#" id="fvalida">
                    <div class="modal-body text-start">
                        <input type="hidden" name="id">
                        <h3>Confirmer la validation ?</h3>
                        <div class="alert alert-danger">
                            <p>
                                <b>Une fois valider, les soldes des clients concernés seront deduits du montant
                                    correspondant</b>
                            </p>
                        </div>
                        <div class="mt-2">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" data-bs-dismiss="modal" type="button">NON</button>
                        <button class="btn btn-primary btn-sm" type="submit"><span></span> CONFIRMER</button>
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
            var table = $('#table');
            table.DataTable();

            $('tr[id]').click(function() {
                var id = $(this).attr('id');
                var inp = $(`#checkebox-sm` + id);
                inp[0].checked = !inp[0].checked;
            });
            $('[sall]').click(function() {
                var id = $(this).attr('id');
                var inp = $(`[name='users_id[]']`);
                var isallchecked = true;
                inp.each(function(i, e) {
                    if (!e.checked) {
                        isallchecked = false;
                        return false;
                    }
                });
                if (isallchecked) {
                    inp.each(function(i, e) {
                        e.checked = false;
                    });
                } else {
                    inp.each(function(i, e) {
                        e.checked = true;
                    });
                }
            });
            $('[table2]').DataTable();

            var userzone = $('[userzone]');
            var formzone = $('[formzone]');
            var backbtn = $('[backbtn]');
            var nextbtn = $('[nextbtn]');
            var donebtn = $('[donebtn]');

            function stepper(checkvisibility = true) {
                if (checkvisibility) {
                    if (userzone.is(':visible')) {
                        backbtn.slideUp();
                        donebtn.slideUp();
                        nextbtn.slideDown();
                    } else {
                        nextbtn.slideUp();
                        backbtn.slideDown();
                        donebtn.slideDown();
                    }
                }

                nextbtn.off('click').click(function() {
                    var inp = $(`[name='users_id[]']:checked`);
                    if (inp.length == 0) {
                        var r = $('#rep00');
                        r.removeClass().addClass('alert alert-danger').html(
                            "Veuillez séléctionner un client");
                        setTimeout(() => {
                            r.html('').removeClass();
                        }, 3000);
                        return false;
                    }

                    preview();
                    userzone.hide('scale');
                    formzone.show('scale');

                    nextbtn.slideUp();
                    backbtn.slideDown();
                    donebtn.slideDown();

                    stepper(false);
                });

                backbtn.off('click').click(function() {
                    formzone.hide('scale');
                    userzone.show('scale');

                    backbtn.slideUp();
                    donebtn.slideUp();
                    nextbtn.slideDown();

                    stepper(false);
                });
            }

            function preview() {
                var formdata = $('[formdata]');
                formdata.html('<div class="text-center"><span class="bx bx-spin bx-loader bx-lg"></span></div>');

                var data = $('#fusers').serialize();
                $(':button', $('#fbtn')).attr('disabled', true);
                $.ajax({
                    'url': '{{ route('export-preview') }}',
                    type: 'post',
                    data: data,
                    success: function(res) {

                        var html = `
                            <table class="table text-nowrap table-sm table-hover" table3>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Solde</th>
                                        <th scope="col">Montant à envoyer</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;
                        res.data.forEach((user, i) => {
                            html += `
                                <tr>
                                    <th scope="row">
                                        <img src="${user.image}" alt="img" width="32"
                                            height="32" class="rounded-circle">
                                        <input name="users_id[]" value='${user.id}' type='hidden' />
                                    </th>
                                    <th scope="row">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                ${user.name} <br> ${user.code}
                                            </label>
                                        </div>
                                    </th>
                                    <td>emmm</td>
                                    <td>
                                        <b style="font-size: 18px">
                                           ${user.solde_cdf}<br> ${user.solde_usd}
                                        </b>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="form-group pr-3">
                                                <label for="amount_cdf">Montant CDF</label>
                                                <input type="number" class="form-control" style="width:130px; margin-right:10px"
                                                    id="amount_cdf" name="amount_cdf[]"
                                                    placeholder="Montant CDF" value="${user.cdf}" min='0' step='0.001' max='${user.cdf}'>
                                            </div>
                                            <div class="form-group">
                                                <label for="amount">Montant USD</label>
                                                <input type="number" class="form-control" style="width:130px; margin-right:10px"
                                                    id="amount" name="amount_usd[]"
                                                    placeholder="Montant USD" value="${user.usd}" min='0' step='0.001' max='${user.usd}'>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        `;
                        });

                        html += `</tbody></table>`;

                        formdata.html(html);
                        $('[table3]').DataTable();
                    },
                    error: function(res) {
                        setTimeout(() => {
                            preview();
                        }, 2000);
                    }
                }).always(function() {
                    $(':button', $('#fbtn')).attr('disabled', false);
                })

            }

            $('#mdl').on('shown.bs.modal', function() {
                setTimeout(() => {
                    stepper(true);
                }, 800);
            });

            function getdata() {
                $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('export.index') }}',
                    success: function(res) {
                        table.DataTable().destroy();
                        var html = '';
                        res.data.forEach((user, i) => {
                            var etat = user.etat;
                            var btn = '';

                            var et =
                                '<span class="badge rounded-pill bg-warning">EN COURS</span>';
                            if (1 == etat) {
                                et =
                                    '<span class="badge rounded-pill bg-success">VALIDE</span>';
                                btn +=
                                    `<button class="btn btn-outline-info btn-sm m-1" value="${user.id}" bshow><i class="bx bx-eye"></i> Voir</button>`;
                            } else {
                                if (user.btn) {
                                    btn +=
                                        `<button class="btn btn-primary btn-sm m-1" value="${user.id}" bval><i class="bx bx-check"></i> Valider</button>`;
                                }

                                btn +=
                                    `<button class="btn btn-outline-info btn-sm m-1" value="${user.id}" bshow><i class="bx bx-eye"></i> Voir</button>`;
                                if (user.btn) {
                                    btn +=
                                        `<button class="btn btn-outline-success btn-sm m-1" value="${user.id}" bexcel><i class="bx bx-exel"></i> Excel</button>`;
                                    btn +=
                                        `<button class="btn btn-outline-danger btn-sm m-1"  value="${user.id}" bdel ><i class="bx bx-trash"></i> Supprimer</button>`;
                                }
                            }



                            html += `<tr>
                            <td>${i+1}</td>
                            <td><img src="${user.image}" alt="img" width="32" height="32" class="rounded-circle"></td>
                            <td>${user.name}</td>
                            <td><b>${user.montant_usd }</b></td>
                            <td><b>${user.montant_cdf }</b></td>
                            <td>${et }</td>
                            <td>${user.date }</td>
                            <td>
                                <div class='d-flex justify-content-end'>${btn}</div>
                            </td>
                        </tr>
                        `;
                        });

                        table.find('tbody').html(html);

                        $('[bdel]').off('click').click(function() {
                            event.preventDefault();
                            var v = this.value;
                            var mdl = $('#delmdl')
                            $('[name=id]', mdl).val(v);
                            mdl.modal('show');
                        });
                        $('[bshow]').off('click').click(function() {
                            event.preventDefault();
                            var v = this.value;
                            var mdl = $('#showmdl')
                            $('[name=id]', mdl).val(v);
                            mdl.modal('show');

                            var detazone = $('[detazone]');
                            detazone.html(
                                '<div class="text-center"><span class="bx bx-loader bx-lg bx-spin"></span></div>'
                            );
                            $.ajax({
                                url: '{{ route('export.show', '') }}/' + v,
                                success: function(r) {
                                    var html = `
                                        <p>Envoi de fonds aux clients</p>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-hover text-nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Client</th>
                                                        <th>Montant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    `;

                                    r.data.forEach((el, i) => {
                                        html += `
                                                <tr>
                                                    <td>${el.name}</td>
                                                    <td>${el.montant.join('<br>')}</td>
                                                </tr>`;
                                    });

                                    html += `
                                    </tbody>
                                            </table>
                                        </div>
                                    `;
                                    detazone.html(html);

                                },
                                error: function(r) {
                                    alert("une erreur s'est produite");
                                }
                            });
                        });

                        $('[bexcel]').off('click').click(function() {
                            event.preventDefault();
                            var v = this.value;
                            location.href = '{{ route('admin.excel', ['el' => '']) }}' + v;
                        });

                        $('[bval]').off('click').click(function() {
                            event.preventDefault();
                            var v = this.value;
                            var mdl = $('#valmdl')
                            $('[name=id]', mdl).val(v);
                            mdl.modal('show');
                        });
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

            donebtn.click(function() {
                event.preventDefault();
                var data = $('#fval').serialize();

                var form = $(this);
                var rep = $('#rep00');
                rep.html('');

                var btn = $(this);
                btn.attr('disabled', true);
                var cl = btn.find('span').attr('class')
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');

                $(':button', $('#fbtn')).attr('disabled', true);

                $.ajax({
                    type: 'post',
                    data: data,
                    url: '{{ route('export.store') }}',
                    success: function(r) {
                        if (r.success) {
                            rep.removeClass().addClass('alert alert-success');
                            getdata();
                            setTimeout(() => {
                                $('.modal').modal('hide');
                            }, 6000);
                        } else {
                            rep.removeClass().addClass('alert alert-danger');
                        }
                        rep.html(r.message);
                    },
                    error: function(r) {
                        alert("une erreur s'est produite");
                    }
                }).always(function() {
                    $(':button', $('#fbtn')).attr('disabled', false);
                    btn.find('span').removeClass().addClass(cl);
                });
            });

            $('#fdel').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                var id = $('[name=id]', form).val();

                $.ajax({
                    type: 'delete',
                    url: '{{ route('export.destroy', '') }}/' + id,
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

            $('#fvalida').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                var id = $('[name=id]', form).val();

                $.ajax({
                    type: 'put',
                    url: '{{ route('export.update', '') }}/' + id,
                    success: function(r) {
                        if (r.success) {
                            btn.attr('disabled', false);
                            rep.removeClass().addClass('text-success');
                            getdata();
                            setTimeout(() => {
                                location.reload();
                            }, 5000);
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


        });
    </script>

</body>

</html>
