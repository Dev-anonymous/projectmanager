<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ $project->name }} | {{ config('app.name') }} </title>
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
                    <div class="col-xl-9">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">Détails du projet</div>

                            </div>
                            <div class="card-body">
                                <h5 class="fw-semibold mb-4 task-title">
                                    {{ $project->name }}
                                </h5>
                                <div class="fs-15 fw-semibold mb-2">Description :</div>
                                <p class="text-muted task-description">{{ $project->description }}</p>

                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <div>
                                        <span class="d-block text-muted fs-12">Budget</span>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="d-block fs-14 fw-semibold">{{ v($project->budget, 'CDF') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="d-block text-muted fs-12">Status</span>
                                        <span class="d-block fs-14 fw-semibold">
                                            @if ($project->status == 0)
                                                <span class="badge bg-warning">EN COURS</span>
                                            @endif
                                            @if ($project->status == 1)
                                                <span class="badge bg-success">FINI</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="d-block text-muted fs-12">Date</span>
                                        <span
                                            class="d-block fs-14 fw-semibold">{{ $project->startdate?->format('d-m-Y H:i') }}
                                            ... {{ $project->enddate?->format('d-m-Y H:i') }} </span>
                                    </div>
                                    @php
                                        $perc = 100;
                                        $task1 = $project->tasks()->where('status', 1)->count();
                                        $task0 = $project->tasks()->where('status', 0)->count();
                                        $tot = $task0 + $task1;
                                        if ($tot) {
                                            $perc = (int) (($task1 / $tot) * 100);
                                        }

                                        $cl = 'success';
                                        if ($perc < 50) {
                                            $cl = 'danger';
                                        }
                                        if ($perc >= 50 && $perc <= 99) {
                                            $cl = 'warning';
                                        }
                                    @endphp
                                    <div class="task-details-progress">
                                        <span class="d-block text-muted fs-12 mb-1">Progress</span>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-xs progress-animate flex-fill me-2"
                                                role="progressbar" aria-valuenow="{{ $perc }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-{{ $cl }}"
                                                    style="width: {{ $perc }}%"></div>
                                            </div>
                                            <div class="text-muted fs-11">{{ $perc }}%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title">Taches</div>
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
                                                <th>Tache</th>
                                                <th>Status</th>
                                                <th>Etudiant</th>
                                                <th>Description</th>
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
                    <div class="col-xl-3">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header">
                                <div class="card-title">
                                    Etudiants liés au projet
                                </div>
                            </div>
                            <div class="card-body p-0" style="max-height: 95vh; overflow: auto;">
                                <ul class="list-group list-group-flush">
                                    @foreach ($project->users()->orderBy('name')->get() as $el)
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="lh-1">
                                                    <span class="avatar avatar-rounded bg-light">
                                                        <img src="{{ userimage($el) }}" alt="">
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <span class="d-block fw-semibold">{{ $el->name }}</span>
                                                    @php
                                                        $h = $el->filiere_has_promotion()->first();
                                                    @endphp
                                                    <span
                                                        class="d-blocke text-muted fs-12 fw-normal">{{ $h->promotion->promotion }}
                                                        {{ $h->filiere->filiere }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
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
                        <h6 class="modal-title">Nouvelle tache </h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" id="f-add">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="modal-body text-start">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Tache (*)</label>
                                <input required type="text" name="name"
                                    class="form-control form-control-sm mb-2" id="signin-username">
                            </div>
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Description (*)</label>
                                <textarea name="description" required rows="3" class="form-control form-control-sm  mb-2"></textarea>
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
                                <select name="users_id[]" multiple id="" class="form-control" required>
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
                        <input type="hidden" name="id">
                        <div class="modal-body text-start">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Tache (*)</label>
                                <input required type="text" name="name"
                                    class="form-control form-control-sm mb-2" id="signin-username">
                            </div>
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Description (*)</label>
                                <textarea name="description" required rows="3" class="form-control form-control-sm  mb-2"></textarea>
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
                                <select name="users_id[]" multiple id="" class="form-control" required>
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
                                        Marquer la tache comme finie
                                    </label>
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


    <script>
        $(document).ready(function() {

            flatpickr(".daterange", {
                mode: "range",
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                defaultDate: ["{{ now()->adddays(7)->format('Y-m-d') }}", "{{ date('Y-m-d') }}"],
            });

            var table = $('#table');
            table.DataTable();

            function getdata() {
                $('span[ldr]').removeClass().addClass('bx bx-spin bx-loader bx-sm');
                $.ajax({
                    'url': '{{ route('task.index', ['project_id' => $project->id]) }}',
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

                            html += `<tr>
                            <td>${i+1}</td>
                            <td>${user.name}</td>
                            <td>${s}</td>
                            <td class="text-wrap">${user.users.join(', ')}</td>
                            <td class="text-wrap">${user.description ?? ''}</td>
                            <td>${user.startdate} ... ${user.enddate}</td>
                            <td>
                                <div class='d-flex justify-content-end'>
                                    ${btn}
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
                    url: '{{ route('task.store') }}',
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
                    url: '{{ route('task.destroy', '') }}/' + id,
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

                var data = form.serialize();
                data += '&date=' + $('.daterange', form).val();

                var id = $('[name=id]', form).val();
                $.ajax({
                    type: 'Patch',
                    data: data,
                    url: '{{ route('task.store', '') }}/' + id,
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
