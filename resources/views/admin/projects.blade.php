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
                                <div class="card-title">Gestion de projets</div>
                                <div class="m-2">
                                    <button
                                        class="modal-effect btn btn-teal-light btn-border-down btn-sm btn-wave waves-effect waves-light"
                                        data-bs-effect="effect-flip-vertical" data-bs-toggle="modal"
                                        href="#mdl">Ajouter
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table" class="table table-hover text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th style="width:5px!important"><span ldr></span></th>
                                                <th>Projet</th>
                                                <th>Budget</th>
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

        <div class="modal fade" id="mdl">
            <div class="modal-dialog  text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Nouveau projet </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" id="f-add">
                        <div class="modal-body text-start">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Projet (*)</label>
                                <input required type="text" name="name" class="form-control form-control-sm mb-2"
                                    id="signin-username">
                            </div>
                            <div class="col-xl-12">
                                <label for="text-area" class="form-label">Budget (CDF) (*)</label>
                                <input type="number" value="0" name="budget"
                                    class="form-control form-control-sm mb-2">
                            </div>
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Description</label>
                                <textarea name="description" rows="3" class="form-control form-control-sm  mb-2"></textarea>
                            </div>
                            <div class="col-xl-12">
                                <label class="form-label text-default">Date début/Fin du
                                    projet (*)</label>
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                    <input type="text" class="form-control daterange" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Etudiants</label>
                                <select name="users_id[]" multiple id="" class="form-control">
                                    @foreach ($students as $el)
                                        <option value="{{ $el->id }}">{{ $el->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <div id="rep"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal" type="button">Fermer</button>
                            <button class="btn btn-primary" type="submit"><span></span> Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editmdl">
            <div class="modal-dialog modal-lg text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Modification </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" id="f-edit">
                        <div class="modal-body text-start">
                            <input type="hidden" name="id">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Projet (*)</label>
                                <input required type="text" name="name"
                                    class="form-control form-control-sm mb-2" id="signin-username">
                            </div>
                            <div class="col-xl-12">
                                <label for="text-area" class="form-label">Budget (CDF) (*)</label>
                                <input type="number" value="0" name="budget"
                                    class="form-control form-control-sm mb-2">
                            </div>
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Description</label>
                                <textarea name="description" rows="3" class="form-control form-control-sm  mb-2"></textarea>
                            </div>
                            <div class="col-xl-12">
                                <label class="form-label text-default">Date début/Fin du
                                    projet (*)</label>
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                    <input type="text" class="form-control daterange" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Etudiants</label>
                                <select name="users_id[]" multiple id="" class="form-control">
                                    @foreach ($students as $el)
                                        <option value="{{ $el->id }}">{{ $el->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="finish"
                                        id="defaultCheck0003">
                                    <label class="form-check-label text-muted fw-normal" for="defaultCheck0003">
                                        Marquer le projet comme fini
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3" style="display: none" dmess>
                                <b>Ce projet a-t produit un article ? </b>
                                <div class="d-flex my-3">
                                    <div class="form-check form-check-md m-2">
                                        <input class="form-check-input" type="radio" ino checked name="yesno"
                                            id="Radio-md" value="0">
                                        <label class="form-check-label" for="Radio-md">
                                            NON
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md m-2">
                                        <input class="form-check-input" value="1" iyes type="radio"
                                            name="yesno" id="r001">
                                        <label class="form-check-label" for="r001">
                                            OUI
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" style="display: none" dart>
                                <hr>
                                <h5 class="mt-3">Nouvel article</h5>
                                <div class="col-xl-12 mb-2">
                                    <label class="form-label text-default">Catégorie</label>
                                    <select name="category_id" id="" class="form-control">
                                        @foreach ($category as $el)
                                            <option value="{{ $el->id }}">{{ $el->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">Article (*)</label>
                                    <input isrequired type="text" name="articlename"
                                        class="form-control form-control-sm mb-2" id="signin-username">
                                </div>
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">Description</label>
                                    <textarea name="articledescription" rows="3" class="form-control form-control-sm  mb-2"></textarea>
                                </div>
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">Prix (CDF)
                                        (*)</label>
                                    <input isrequired type="number" name="articleprice" min="0"
                                        class="form-control form-control-sm  mb-2" id="signin-username">
                                </div>
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">Stock (*)</label>
                                    <input isrequired type="number" name="articlestock" min="1"
                                        value="1" class="form-control form-control-sm  mb-2"
                                        id="signin-username">
                                </div>
                                <div class="col-xl-12">
                                    <label for="text-area" class="form-label">Image (*)</label>
                                    <input type="file" isrequired class="filepond1" name="articleimage" multiple
                                        accept="image/png, image/jpeg" data-max-file-size="500KB" data-max-files="5">
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="forsale" checked
                                            id="defaultCheck0003000">
                                        <label class="form-check-label text-muted fw-normal"
                                            for="defaultCheck0003000">
                                            Disponible pour l'achat
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-2">
                                <div id="rep"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal" type="button">Fermer</button>
                            <button class="btn btn-primary" type="submit"><span></span> Valider</button>
                        </div>
                    </form>
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


    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">


    <script>
        $(document).ready(function() {
            FilePond.registerPlugin(
                FilePondPluginImagePreview
            );
            pond1 = FilePond.create($('.filepond1')[0]);

            flatpickr(".daterange", {
                mode: "range",
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                defaultDate: ["{{ now()->adddays(7)->format('Y-m-d') }}", "{{ date('Y-m-d') }}"],
            });

            var defaultCheck0003 = $('#defaultCheck0003');
            var yesno = $('[name="yesno"]');

            defaultCheck0003.change(function() {
                mess();
            });

            yesno.change(function() {
                yn($(this));
            })

            function yn(el) {
                if (el.val() == 1) {
                    $('[dart]').stop().slideDown();
                    $('[iyes]')[0].checked = true;
                    $('[ino]')[0].checked = false;
                    $('[isrequired]').attr('required', true);
                } else {
                    $('[dart]').stop().slideUp();
                    $('[iyes]')[0].checked = false;
                    $('[ino]')[0].checked = true;
                    $('[isrequired]').attr('required', false);
                }
            }
            yn(yesno);

            function mess() {
                if (defaultCheck0003.is(':checked')) {
                    $('[dmess]').stop().slideDown();
                } else {
                    $('[dmess]').stop().slideUp();
                }
            }
            mess();

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
                                btn = `
                                    <button class="btn btn-primary btn-sm m-1" data="${escape(JSON.stringify(user))}"  value="${user.id}" bedit><i class='bx bx-edit'></i></button>
                                    <button class="btn btn-outline-danger btn-sm m-1"  value="${user.id}" bdel ><i class='bx bx-trash'></i></button>
                                `;
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
                            <td>${user.budget}</td>
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
                                    ${btn}
                                    <a href="{{ route('admin.projects', ['item' => '']) }}${user.id}" class="btn btn-outline-info btn-sm m-1"   ><i class='bx bxs-cog'></i></a>
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
                            $('[name=description]', mdl).val(data.description);
                            $('[name=budget]', mdl).val(data.budgetv);
                            $('[name="users_id[]"]', mdl).val(data.users_id);

                            var inp = $('.daterange', mdl);
                            inp.flatpickr('destroy');
                            inp.flatpickr({
                                mode: "range",
                                dateFormat: "Y-m-d H:i",
                                enableTime: true,
                                defaultDate: [data.startdate, data.enddate]
                            });
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
                data.append('date', $('.daterange', form).val());

                $.ajax({
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
                    url: '{{ route('project.store') }}',
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
                    url: '{{ route('project.destroy', '') }}/' + id,
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

            $('#f-edit').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');

                var data = new FormData(form[0]);
                data.append('date', $('.daterange', form).val());

                let pondFiles = pond1.getFiles();
                for (var i = 0; i < pondFiles.length; i++) {
                    data.append('articleimage[]', pondFiles[i].file);
                }

                var id = $('[name=id]', form).val();
                $.ajax({
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    url: '{{ route('project.store', '') }}/' + id,
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
        });
    </script>

</body>

</html>
