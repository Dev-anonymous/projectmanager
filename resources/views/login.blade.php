<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Connexion | {{ config('app.name') }} </title>
    <script>
        localStorage.setItem("loaderEnable", "true")
    </script>
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-5 d-flex justify-content-center">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                            class="desktop-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                            class="desktop-dark">
                    </a>
                </div>
                <div class="card custom-card">
                    <div class="card-body p-5">
                        <p class="h5 fw-semibold mb-2 text-center">Connexion</p>
                        <p class="mb-4 text-muted op-7 fw-normal text-center">{{ config('app.name') }}</p>
                        <div class="row gy-3">
                            <form action="#" id="flog">
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">Email</label>
                                    <input required type="text" name="email" class="form-control form-control-lg"
                                        id="signin-username" placeholder="Email">
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="signin-password" class="form-label text-default d-block">Mot de passe
                                        {{-- <a href="reset-password-basic.html" class="float-end text-danger">Forget password
                                        ?</a> --}}
                                    </label>
                                    <div class="input-group">
                                        <input required type="password" name="pass"
                                            class="form-control form-control-lg" id="signin-password"
                                            placeholder="Mot de passe">
                                        <button class="btn btn-light" type="button"
                                            onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                                class="ri-eye-line align-middle"></i></button>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                Rester connecté
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div id="rep"></div>
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        <span></span>
                                        Connexion
                                    </button>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="text-center">
                            <p class="fs-12 text-muted mt-3">Dont have an account? <a href="sign-up-basic.html"
                                    class="text-primary">Sign Up</a></p>
                        </div>
                        <div class="text-center my-3 authentication-barrier">
                            <span>OR</span>
                        </div>
                        <div class="btn-list text-center">
                            <button class="btn btn-icon btn-light">
                                <i class="ri-facebook-line fw-bold text-dark op-7"></i>
                            </button>
                            <button class="btn btn-icon btn-light">
                                <i class="ri-google-line fw-bold text-dark op-7"></i>
                            </button>
                            <button class="btn btn-icon btn-light">
                                <i class="ri-twitter-x-line fw-bold text-dark op-7"></i>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jq.min.js') }}"></script>
    <script src="{{ asset('assets/js/show-password.js') }}"></script>

    <script>
        @if (!Auth::check())
            localStorage.setItem('_t', '')
        @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': 'Bearer ' + localStorage.getItem('_t'),
                'Accept': 'application/json'
            }
        });
        $('[logout]').click(function() {
            var rl = $(this);
            rl.closest('li').html('<span class="fa fa-spinner fa-spin text-white fa-2x mt-2"></span>');
            // $.post('{{ route('auth-logout') }}', function() {
            //     location.reload();
            // })
        })
    </script>

    <script>
        $(function() {
            $('#flog').submit(function() {
                event.preventDefault();
                var form = $(this);
                var rep = $('#rep', form);
                rep.html('');

                var btn = $(':submit', form);
                btn.attr('disabled', true);
                btn.find('span').removeClass().addClass('bx bx-spin bx-loader');
                var d = form.serialize() + '&r={{ request('r') }}';

                $.ajax({
                    type: 'post',
                    url: '{{ route('auth-login') }}',
                    data: d,
                    success: function(r) {
                        if (r.success) {
                            btn.attr('disabled', false);
                            rep.removeClass().addClass('text-success');
                            localStorage.setItem('_t', r.token);
                            setTimeout(() => {
                                location.reload();
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
                        alert("une erreur s'est produite");
                    }
                });
            })
        })
    </script>

</body>

</html>
