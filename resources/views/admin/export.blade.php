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
                                                <th>Créé par</th>
                                                <th>Total USD</th>
                                                <th>Total CDF</th>
                                                <th>Nombre Chauffeurs</th>
                                                <th>Etat</th>
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
                                <table class="table text-nowrap table-sm table-hover" table2>
                                    <thead>
                                        <tr>
                                            <th scope="col">Chauffeur</th>
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
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users_id[]" id="checkebox-sm{{ $el->id }}">
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
                            </div>
                        </div>
                        <div formzone style="display: none">
                            <div class="">
                                <h5 class="m-2">Veuillez adjuster les montant à envoyer</h5>
                                <form action="#" >
                                    <div class="">
                                        <div class="form-group">
                                            <label for="amount">Montant USD</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                placeholder="Montant USD" value="0">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount_cdf">Montant CDF</label>
                                            <input type="number" class="form-control" id="amount_cdf" name="amount_cdf"
                                                placeholder="Montant CDF" value="0">
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div id="rep"></div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <div class="ml-3">
                            <button backbtn style="display: none" class="btn btn-sm btn-outline-primaryprimary mr-2"
                                type="button">
                                <span class="bx bx-arrow-back"></span> Retour
                            </button>
                            <button nextbtn style="display: none" class="btn btn-sm btn-primary" type="button">
                                <span class="bx bx-arrow-to-right"></span>
                                Suivant
                            </button>
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
                            <button class="btn btn-light btn-sm" data-bs-dismiss="modal">NON</button>
                            <button class="btn btn-primary btn-sm" type="submit"><span></span> OUI</button>
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

    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>

    <script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">


    <script>
        $(document).ready(function() {
            $('.phone').mask('0000000000');
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

            function stepper(checkvisibility = true) {
                if (checkvisibility) {
                    if (userzone.is(':visible')) {
                        backbtn.slideUp();
                        nextbtn.slideDown();
                    } else {
                        nextbtn.slideUp();
                        backbtn.slideDown();
                    }
                }

                nextbtn.off('click').click(function() {
                    userzone.hide('scale');
                    formzone.show('scale');

                    nextbtn.slideUp();
                    backbtn.slideDown();

                    stepper(false);
                });

                backbtn.off('click').click(function() {
                    formzone.hide('scale');
                    userzone.show('scale');

                    backbtn.slideUp();
                    nextbtn.slideDown();

                    stepper(false);
                });
            }

            $('#mdl').on('shown.bs.modal', function() {
                setTimeout(() => {
                    stepper(true);
                }, 800);
            });


            FilePond.registerPlugin(
                FilePondPluginImagePreview
            );

            pond1 = FilePond.create($('.filepond1')[0]);
            pond2 = FilePond.create($('.filepond2')[0]);


            function getdata() {
                $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('export.index') }}',
                    success: function(res) {
                        table.DataTable().destroy();
                        var html = '';
                        res.data.forEach((user, i) => {
                            var img = user.image;
                            if (img) {
                                img = '{{ asset('storage') }}/' + img;
                            } else {
                                img = '{{ asset('/assets/images/faces/9.jpg') }}';
                            }
                            html += `<tr>
                            <td>${i+1}</td>
                            <td><img src="${img}" alt="img" width="32" height="32" class="rounded-circle"></td>
                            <td>${user.name}</td>
                            <td>${user.phone??'-'}</td>
                            <td>${user.email??'-'}</td>
                            <td>
                                <div class='d-flex justify-content-end'>
                                    <button class="btn btn-primary btn-sm m-1" data="${escape(JSON.stringify(user))}"  value="${user.id}" bedit>Valider</button>
                                    <button class="btn btn-outline-danger btn-sm m-1"  value="${user.id}" bdel >Supprimer</button>
                                </div>
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
                        $('[bedit]').off('click').click(function() {
                            event.preventDefault();
                            var mdl = $('#editmdl')
                            var data = JSON.parse(unescape($(this).attr('data')));
                            $('[name=id]', mdl).val(data.id);
                            $('[name=name]', mdl).val(data.name);
                            $('[name=email]', mdl).val(data.email);
                            $('[name=phone]', mdl).val(data.phone);
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


            $('#f-add').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                var data = new FormData(form[0]);

                let pondFiles = pond1.getFiles();
                for (var i = 0; i < pondFiles.length; i++) {
                    data.append('image', pondFiles[i].file);
                }

                $.ajax({
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
                    url: '{{ route('users.store') }}',
                    success: function(r) {
                        if (r.success) {
                            btn.attr('disabled', false);
                            rep.removeClass().addClass('text-success');
                            form.get(0).reset();
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
                    url: '{{ route('users.destroy', '') }}/' + id,
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


        });
    </script>

</body>

</html>
