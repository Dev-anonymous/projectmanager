<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Clients | {{ config('app.name') }} </title>
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Clients</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Clients</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 mb-2">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Comptes Clients</div>

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
                                                <th></th>
                                                <th>Nom</th>
                                                <th>Catégorie</th>
                                                <th>Tel.</th>
                                                <th>Email</th>
                                                <th>Adresse</th>
                                                <th>Pièce identité</th>
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
                        <h6 class="modal-title">Nouveau client </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" id="f-add">
                        <div class="modal-body text-start">
                            <input type="hidden" name="user_role" value="user">
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Catégorie</label>
                                <select name="categorie_id" id="" class="form-control" required="required">
                                    @foreach ($categories as $el)
                                        <option value="{{ $el->id }}">{{ $el->categorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Nom</label>
                                <input required type="text" name="name" class="form-control form-control-sm"
                                    placeholder="Nom">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Téléphone</label>
                                <input required type="text" minlength="10" maxlength="10" name="phone"
                                    class="form-control form-control-sm phone" placeholder="Téléphone, Ex: 099xxx">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Email</label>
                                <input required type="email" name="email" class="form-control form-control-sm"
                                    placeholder="Email">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Adresse</label>
                                <textarea name="adresse" id="" cols="30" rows="3" required name="adresse"
                                    class="form-control form-control-sm" placeholder="Adresse"></textarea>

                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Type de pièce d'identité</label>
                                <select name="typepiece" id="" class="form-control">
                                    @foreach (typepiece() as $type)
                                        <option>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="text-area" class="form-label">Image pièce d'identité</label>
                                <input type="file" required class="filepond0" name="pieceidentite"
                                    accept="image/png, image/jpeg" data-max-file-size="500KB" data-max-files="1">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="text-area" class="form-label">Image profil</label>
                                <input type="file" required class="filepond1" name="image"
                                    accept="image/png, image/jpeg" data-max-file-size="500KB" data-max-files="1">
                            </div>
                            <div class="col-xl-12 mb-1 mt-2">
                                <label for="signin-password" class="form-label text-default d-block">Mot de passe
                                </label>
                                <div class="input-group">
                                    <input required autocomplete="off" type="password" name="password"
                                        class="form-control form-control-sm" id="signin-password"
                                        placeholder="Mot de passe">
                                    <button class="btn btn-light" type="button"
                                        onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                            class="ri-eye-line align-middle"></i></button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div id="rep"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button class="btn btn-primary" type="submit"><span></span> Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editmdl">
            <div class="modal-dialog  text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Modification </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" id="f-edit">
                        <div class="modal-body text-start">
                            <input type="hidden" name="id">
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Nom</label>
                                <input required type="text" name="name" class="form-control form-control-sm"
                                    placeholder="Nom">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Téléphone</label>
                                <input required type="text" minlength="10" maxlength="10" name="phone"
                                    class="form-control form-control-sm phone" placeholder="Téléphone, Ex: 099xxx">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Email</label>
                                <input required type="email" name="email" class="form-control form-control-sm"
                                    placeholder="Email">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Adresse</label>
                                <textarea name="adresse" id="" cols="30" rows="3" required name="adresse"
                                    class="form-control form-control-sm" placeholder="Adresse"></textarea>

                            </div>
                            <div class="col-xl-12 mb-2">
                                <label class="form-label text-default">Type de pièce d'identité</label>
                                <select name="typepiece" id="" class="form-control">
                                    @foreach (typepiece() as $type)
                                        <option>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="text-area" class="form-label">Image pièce d'identité (optionnel)</label>
                                <input type="file" class="filepond00" name="pieceidentite"
                                    accept="image/png, image/jpeg" data-max-file-size="500KB" data-max-files="1">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="text-area" class="form-label">Image profil (optionnel)</label>
                                <input type="file" class="filepond11" name="image"
                                    accept="image/png, image/jpeg" data-max-file-size="500KB" data-max-files="1">
                            </div>
                            <div class="col-xl-12 mb-1 mt-2">
                                <label for="signin-password" class="form-label text-default d-block">Mot de passe
                                    (optionnel)
                                </label>
                                <div class="input-group">
                                    <input autocomplete="off" type="password" name="password"
                                        class="form-control form-control-sm" id="signin-password"
                                        placeholder="Mot de passe">
                                    <button class="btn btn-light" type="button"
                                        onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                            class="ri-eye-line align-middle"></i></button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div id="rep"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button class="btn btn-primary" type="submit"><span></span> Valider</button>
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

            FilePond.registerPlugin(
                FilePondPluginImagePreview
            );

            pond0 = FilePond.create($('.filepond0')[0]);
            pond1 = FilePond.create($('.filepond1')[0]);

            pond00 = FilePond.create($('.filepond00')[0]);
            pond11 = FilePond.create($('.filepond11')[0]);

            function getdata() {
                $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('users.index', ['type' => 'user']) }}',
                    success: function(res) {
                        table.DataTable().destroy();
                        var html = '';
                        res.data.forEach((user, i) => {

                            html += `<tr>
                            <td>${i+1}</td>
                            <td><img src="${user.image}" alt="img" width="32" height="32" class="rounded-circle"></td>
                            <td>${user.name}<br><i>${user.code??''}</i></td>
                            <td>${user.categorie}</td>
                            <td>${user.phone??'-'}</td>
                            <td>${user.email??'-'}</td>
                            <td>${user.adresse??'-'}</td>
                            <td>
                                <a href="${user.pieceidentite??'#'}" target='_blanck'>${user.typepiece??'-'}</a>
                            </td>
                            <td>
                                <div class='d-flex justify-content-end'>
                                    <button class="btn btn-primary btn-sm m-1" data="${escape(JSON.stringify(user))}"  value="${user.id}" bedit>Modifier</button>
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
                            $('[name=adresse]', mdl).val(data.adresse);
                            $('[name=typepiece]', mdl).val(data.typepiece);
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

                let pondFiles = pond0.getFiles();
                for (var i = 0; i < pondFiles.length; i++) {
                    data.append('pieceidentite', pondFiles[i].file);
                }

                pondFiles = pond1.getFiles();
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

            $('#f-edit').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                var data = new FormData(form[0]);

                let pondFiles = pond00.getFiles();
                for (var i = 0; i < pondFiles.length; i++) {
                    data.append('pieceidentite', pondFiles[i].file);
                }

                pondFiles = pond11.getFiles();
                for (var i = 0; i < pondFiles.length; i++) {
                    data.append('image', pondFiles[i].file);
                }

                var id = $('[name=id]', form).val();
                $.ajax({
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
                    url: '{{ route('users.store', '') }}/' + id,
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
