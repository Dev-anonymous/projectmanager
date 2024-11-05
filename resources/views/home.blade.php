<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Accueil</title>
    <script>
        localStorage.setItem("loaderEnable", "true")
    </script>
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/nouislider/nouislider.min.css') }}">

</head>

<body>
    <div id="loader">
        <img src="../assets/images/media/loader.svg" alt="">
    </div>

    <div class="page">
        <x-header />

        <div class="container-fluid" style="margin-top: 7vh">
            <div class="my-4">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body p-0">
                                <nav class="navbar navbar-expand-xxl bg-white">
                                    <div class="container-fluid">
                                        <a class="navbar-brand" href="{{ route('home') }}">
                                            <img src="../assets/images/brand-logos/toggle-logo.png" alt=""
                                                class="d-inline-block align-text-top">
                                        </a>
                                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#navbarSupportedContent"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>
                                        <div class="collapse navbar-collapse navbar-justified flex-wrap gap-2"
                                            id="navbarSupportedContent">
                                            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-xxl-center">
                                                @foreach ($topcat as $el)
                                                    <li class="nav-item mb-1">
                                                        <a class="nav-link afilter" isa='yes' href="#"
                                                            filtre='{{ $el->id }}'>{{ $el->category }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                                <li class="nav-item mb-xxl-0 mb-2 ms-xxl-0 ms-3">
                                                    <div class="btn-group d-xxl-flex d-block">
                                                        <button class="btn btn-sm btn-primary-light dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Trier par <span sfilter></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item afilter" filtre='name'
                                                                    href="javascript:void(0);">Nom</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item afilter" filtre='priceASC'
                                                                    href="javascript:void(0);">Prix (ASC)</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item afilter" filtre='priceDESC'
                                                                    href="javascript:void(0);">Prix (DESC)</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item afilter" filtre='date'
                                                                    href="javascript:void(0);">Date</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="d-flex" role="search">
                                                <input class="form-control me-2" type="search" id="search"
                                                    placeholder="Recherche" aria-label="Search">
                                                {{-- <button class="btn btn-light" type="submit">Recherche</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-12">
                        <div class="card custom-card products-navigation-card">
                            <div class="card-body p-0">
                                <div class="p-4 border-bottom">
                                    <p class="fw-semibold mb-0 text-muted">CATEGORIES</p>
                                    <div class="px-2 py-3 pb-0" style="max-height: 50vh; overflow:auto;">
                                        <form action="#" id="fcate">
                                            @foreach ($categories as $el)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="categories[]"
                                                        value="{{ $el->id }}"
                                                        id="electronics{{ $el->id }}">
                                                    <label class="form-check-label"
                                                        for="electronics{{ $el->id }}">
                                                        {{ $el->category }}
                                                    </label>
                                                    <span
                                                        class="badge bg-light text-muted float-end">{{ $el->products_count }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="p-4 border-bottom">
                                    <p class="fw-semibold mb-0 text-muted">PRIX</p>
                                    <div class="px-2 py-3 pb-0">
                                        <div class="mt-5 mx-3" id="product-price-range"></div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-12">
                        <div class="row text-center">
                            <i class="bx bx-lg bx-spin bx-loader" style="display: none" loader></i>
                            <p><b class="text-info-emphasis" searchtext></b></p>
                        </div>
                        <div class="row" insertdata>

                        </div>
                        <div class="auto-load text-center mt-5"></div>
                        <div class="div-observer"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="m401">
            <div class="modal-dialog modal-sm text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <form action="#" id="fdel">
                        <div class="modal-body text-start">
                            <h6 alert>Veuillez vous connecter avant d'ajouter un article au panier.</h3>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light btn-sm" data-bs-dismiss="modal"
                                type="button">Annuler</button>
                            <a class="btn btn-primary btn-sm" aclose href="{{ route('login') }}">Je me connecte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="mdetails">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row gx-5">
                                    <div class="col-xxl-4 col-xl-12">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-md-5 mb-3">
                                                <div
                                                    class="swiper swiper-preview-details bg-light product-details-page">
                                                    <div class="swiper-wrapper" img0>
                                                        {{-- <div class="swiper-slide" id="img-container">
                                                            <img class="img-fluid"
                                                                src="../assets/images/ecommerce/png/15.png"
                                                                alt="img">
                                                        </div> --}}
                                                    </div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                                <div class="swiper swiper-view-details mt-2">
                                                    <div class="swiper-wrapper" img1>
                                                        {{-- <div class="swiper-slide">
                                                            <img class="img-fluid"
                                                                src="../assets/images/ecommerce/png/15.png"
                                                                alt="img">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xxl-8 col-xl-12">
                                        <div class="row gx-5">
                                            <div>
                                                <p atitle class="fs-18 fw-semibold mb-0">
                                                </p>
                                                <hr>
                                                <div class="row mb-4">
                                                    <div class="col-xxl-3 col-xl-12">
                                                        <p class="mb-1">
                                                            <span class="h3" aprice>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <p class="fs-15 fw-semibold mb-1">Description :</p>
                                                    <p class="text-muted mb-0" adesc>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" data-bs-dismiss="modal" type="button">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mpay" data-bs-backdrop="static">
            <div class="modal-dialog  text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <form action="#" id="fpay">
                        <div class="modal-body text-start">
                            <h6>Paiement</h6>
                            <div class="">
                                <h4>Total panier : <span tpanier></span></h4>
                                <div class="mb-2">
                                    <div class="text-center">
                                        <b class="mr-2">Nous acceptons les paiements par </b>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a class="m-1">
                                            <img class="img-thumbnail shadow-lg"
                                                src="{{ asset('img/payment-method/airtel.png') }}" width="100px"
                                                height="50px" alt="" />
                                        </a>
                                        <a class="m-1">
                                            <img class="img-thumbnail shadow-lg"
                                                src="{{ asset('img/payment-method/vodacom.png') }}" width="100px"
                                                height="50px" alt="" />
                                        </a>
                                        <a class="m-1">
                                            <img class="img-thumbnail shadow-lg"
                                                src="{{ asset('img/payment-method/orange.png') }}" width="100px"
                                                height="50px" alt="" />
                                        </a>
                                        <a class="m-1">
                                            <img class="img-thumbnail shadow-lg"
                                                src="{{ asset('img/payment-method/afrimoney.png') }}" width="100px"
                                                height="50px" alt="" />
                                        </a>
                                    </div>
                                </div>

                                <div class="col-xl-12 mb-2">
                                    <label class="form-label text-default">Téléphone Mobile Money</label>
                                    <input required type="text" minlength="10" maxlength="10" name="phone"
                                        class="form-control form-control-sm phone"
                                        value="{{ auth()->user()?->phone }}" placeholder="Téléphone, Ex: 099xxx">
                                </div>
                                <div class="mt-2">
                                    <div id="rep"></div>
                                </div>
                                <button class="btn btn-outline-danger btn-sm my-2" id="btncancel"
                                    style="display: none" type="button">Annuler </button>
                                <button class="btn btn-primary btn-sm my-2" type="submit"><i></i> Payer
                                </button>

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
        <x-footer />
    </div>


    <div id="responsive-overlay"></div>

    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/libs/wnumb/wNumb.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/jq.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>

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
            rl.closest('li').html('<span class="bx bx-spin bx-loader"></span>');
            $.post('{{ route('auth-logout') }}', function() {
                location.reload();
            })
        });
    </script>
    <script>
        $(function() {
            $('.phone').mask('0000000000');

            spin = `<svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                    viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                    <path fill="#000"
                        d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                        <animateTransform attributeName="transform" attributeType="XML"
                            type="rotate" dur="1s" from="0 50 50" to="360 50 50"
                            repeatCount="indefinite" />
                    </path>
                </svg>`;

            function getParam(segment) {
                var url_s = new URL(location.href);
                return url_s.searchParams.get(segment);
            }

            var ENDPOINT = "{{ route('productlist') }}";

            var page = 1;
            var can = true;
            var p = getParam('page');

            if (Number(p)) {
                page = p;
            };

            function getData(append = true) {
                if (can) {
                    var _url;
                    var p = getParam('page');
                    if (p == null) {
                        _url = ENDPOINT + "?page=" + page;
                    } else {
                        var u = new URL(location.href);
                        var s = u.search.replace(`page=${p}`, `page=${page}`);
                        _url = ENDPOINT + s;
                    }

                    $('[loader]').fadeIn();
                    $.ajax({
                            url: _url,
                            datatype: "html",
                            beforeSend: function() {
                                $('.auto-load').html(spin).show();
                            }
                        })
                        .done(function(response) {
                            $('[searchtext]').html(response.searchtext);
                            if (response.data.length == 0 && response.next_page_url == null) {
                                var p = getParam('page');
                                if (removeIfEmpty && p == 1) {
                                    $("[insertdata]").html('');
                                }
                                $('.auto-load').html(
                                        `<div class="mt-5 jumbotron"><b class='text-danger mt-5'>Aucun article à afficher.</b></div>`
                                    )
                                    .fadeIn('slow');
                                can = false;
                                removeIfEmpty = false;
                                return;
                            }
                            removeIfEmpty = false;

                            window.history.pushState({}, null, _url.replace('api/products', ''));
                            str1 = '';
                            $(response.data).each(function(i, el) {
                                str1 += `
                                    <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card product-card">
                                            <div class="text-center">
                                                <i class="" success${el.id}></i>
                                            </div>
                                            <div class="card-body">
                                                <a href="#" details data='${escape(JSON.stringify(el))}' class="product-image">
                                                    <img src="${el.image}" class="card-img mb-3" style="height:150px;object-fit:contain">
                                                </a>
                                                <div class="product-icons">
                                                    <a href="#" class="wishlist addtocart" item=${el.id}>
                                                        <i class="ri-shopping-cart-line"></i>
                                                    </a>
                                                </div>
                                                <p
                                                    class="product-name fw-semibold mb-0 d-flex align-items-center justify-content-between">
                                                    ${el.name}
                                                </p>
                                                <p class="product-description fs-11 text-muted mb-2">${el.category?.category}</p>
                                                <p
                                                    class="mb-1 fw-semibold fs-16 d-flex align-items-center justify-content-between">
                                                    <span>${el.price}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                            })
                            if (append) {
                                $("[insertdata]").append(str1);
                            } else {
                                $("[insertdata]").html(str1);
                            }

                            $('.addtocart').off('click').click(function() {
                                var item = $(this).attr('item');
                                var i = $(this).find('i');
                                var txt = i.attr('class');
                                i.removeClass().addClass('bx bx-loader bx-spin');
                                var success = $('[success' + item + ']');
                                success.removeClass();
                                $.ajax({
                                    url: '{{ route('cart.store') }}',
                                    type: 'post',
                                    data: {
                                        item: item
                                    },
                                    success: function(data) {
                                        panier();
                                        success.removeClass().addClass(
                                            'bx bx-check-circle bx-sm text-success');
                                        setTimeout(() => {
                                            success.removeClass();
                                        }, 800);
                                    },
                                    error: function(data, b, c) {
                                        var mdl = $('#m401');
                                        if (401 == data.status) {
                                            mdl.modal('show');
                                        }
                                        if (403 == data.status) {
                                            $('[alert]', mdl).html("Action non autorisée.");
                                            $('[aclose]', mdl).hide();
                                            mdl.modal('show');
                                        }
                                    }
                                }).always(function() {
                                    i.removeClass().addClass(txt);
                                });
                            });

                            $('[details]').off('click').click(function() {
                                event.preventDefault();
                                var data = unescape($(this).attr('data'));
                                var mdl = $('#mdetails');
                                data = JSON.parse(data);
                                $('[atitle]').html(data.name);
                                $('[aprice]').html(data.price);
                                $('[adesc]').html(data.description);
                                var img = data.images;
                                var img0 = img1 = '';
                                img.forEach(function(e, i) {
                                    img0 += `
                                        <div class="swiper-slide">
                                            <img class="img-fluid" src="${e}" alt="img" style="height:250px;object-fit:contain">
                                        </div>
                                    `;
                                    img1 += `
                                            <div class="swiper-slide">
                                                <img class="img-fluid" src="${e}" alt="img" style="height:80px;width:80px;object-fit:cover;">
                                            </div>
                                    `;
                                });

                                $('[img0]').html(img0);
                                $('[img1]').html(img1);

                                var swiper = new Swiper(".swiper-view-details", {
                                    spaceBetween: 10,
                                    slidesPerView: 4,
                                    freeMode: true,
                                    watchSlidesProgress: true,
                                });
                                var swiper2 = new Swiper(".swiper-preview-details", {
                                    spaceBetween: 10,
                                    navigation: {
                                        nextEl: ".swiper-button-next",
                                        prevEl: ".swiper-button-prev",
                                    },
                                    thumbs: {
                                        swiper: swiper,
                                    }
                                });
                                mdl.modal('show');

                            });

                        }).always(function() {
                            $('[loader]').fadeOut();
                            $('.auto-load').hide();
                        });
                }
            }

            $('.afilter').click(function() {
                event.preventDefault();
                var vfilter = $(this).attr('filtre');
                var _url = location.href;

                if ('yes' == $(this).attr('isa')) {
                    var cat = [];
                    $('#fcate').serializeArray().forEach(function(e) {
                        cat.push(e['value']);
                    });
                    if (!cat.includes(vfilter)) {
                        cat.push(vfilter);
                    }
                    cat = cat.join(',');
                    var ucat = getParam('categories');
                    var p = getParam('page');
                    if (ucat != null) {
                        _url = _url.replace(`categories=${ucat}`, `categories=${cat}`);
                        var p = getParam('page');
                        _url = _url.replace(`page=${p}`, `page=1`);
                    } else {
                        var p = getParam('page');
                        if (p == null) {
                            _url = _url + `?categories=${cat}`;
                        } else {
                            _url = _url + `&categories=${cat}`;
                            _url = _url.replace(`page=${p}`, `page=1`);
                        }
                    }
                } else {
                    if (vfilter) {
                        $('[sfilter]').html(' : ' + vfilter);
                    }
                    var filter = getParam('filter');
                    if (filter != null) {
                        _url = _url.replace(`filter=${filter}`, `filter=${vfilter}`);
                        var p = getParam('page');
                        _url = _url.replace(`page=${p}`, `page=1`);
                    } else {
                        var p = getParam('page');
                        if (p == null) {
                            _url = _url + `?filter=${vfilter}`;
                        } else {
                            _url = _url + `&filter=${vfilter}`;
                            _url = _url.replace(`page=${p}`, `page=1`);
                        }
                    }
                }

                page = 1;
                can = true;
                window.history.pushState({}, null, _url);
                getData(false);
            });

            $('#search').keyup(function() {
                var v = this.value;
                if (v.trim().length == 0) {
                    var url_s = new URL(location.href);
                    var u = url_s.searchParams.set('q', '');
                    window.history.pushState({}, null, url_s.href);
                    this.value = '';
                }

                var _url = location.href;

                var q = getParam('q');
                if (q != null) {
                    _url = _url.replace(`q=${q}`, `q=${v}`);
                    var p = getParam('page');
                    _url = _url.replace(`page=${p}`, `page=1`);
                } else {
                    var p = getParam('page');
                    if (p == null) {
                        _url = _url + `?q=${v}`;
                    } else {
                        _url = _url + `&q=${v}`;
                        _url = _url.replace(`page=${p}`, `page=1`);
                    }
                }
                page = 1;
                can = true;
                removeIfEmpty = true;
                window.history.pushState({}, null, _url);
                getData(false);

            })

            removeIfEmpty = false;

            function getByCat() {
                $('#fcate').change(function() {
                    event.preventDefault();
                    var _url = location.href;

                    var cat = [];
                    $(this).serializeArray().forEach(function(e) {
                        cat.push(e['value']);
                    });
                    cat = cat.join(',');
                    var ucat = getParam('categories');
                    var p = getParam('page');
                    if (ucat != null) {
                        _url = _url.replace(`categories=${ucat}`, `categories=${cat}`);
                        var p = getParam('page');
                        _url = _url.replace(`page=${p}`, `page=1`);
                    } else {
                        var p = getParam('page');
                        if (p == null) {
                            _url = _url + `?categories=${cat}`;
                        } else {
                            _url = _url + `&categories=${cat}`;
                            _url = _url.replace(`page=${p}`, `page=1`);
                        }
                    }
                    page = 1;
                    can = true;
                    window.history.pushState({}, null, _url);
                    removeIfEmpty = true;
                    getData(false);
                })
            }

            $('#search').val(getParam('q'));
            getData();
            getByCat();
            (new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        page++;
                        getData();
                    }
                });
            }, {})).observe(document.querySelectorAll('.div-observer')[0]);

            function panier() {
                $.ajax({
                    url: '{{ route('cart.index') }}',
                    success: function(data) {
                        var txt = '';
                        var txt2 = '';
                        data.cart.forEach(function(e) {
                            txt += `
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start cart-dropdown-item">
                                        <img src="${e.image}" alt="img"
                                            class="avatar avatar-sm avatar-rounded br-5 me-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between mb-0">
                                                <div class="mb-0 fs-13 text-dark fw-semibold">
                                                    ${e.product}
                                                </div>
                                                <div>
                                                    <span class="text-black mb-1">${e.total}</span>
                                                    <a href="javascript:void(0);"
                                                        class="header-cart-remove float-end dropdown-item-close" item=${e.id}>
                                                        <i class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                            <div
                                                class="min-w-fit-content d-flex align-items-start justify-content-between">
                                                <ul class="header-product-item d-flex">
                                                    <li><input class='form-control form-control-sm addtocart2' item="${e.product_id}" style="width:60px" type="number" min=1 value="${e.qty}"/></li>
                                                    <li class='mt-2'>X ${e.price}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            `;
                        });
                        $('#header-cart-items-scroll').html(txt);

                        $('[npanier]').html(data.n);
                        $('[tpanier]').html(data.total);

                        if (data.n == 0) {
                            $('.empty-item').removeClass('d-none');
                            $('[dvalide]').hide();
                        } else {
                            $('.empty-item').addClass('d-none');
                            $('[dvalide]').show();
                        }

                        $('.header-cart-remove').off('click').click(function() {
                            var item = $(this).attr('item');
                            var i = $(this).find('i');
                            var txt = i.attr('class');
                            i.removeClass().addClass('bx bx-loader bx-spin');
                            $.ajax({
                                url: '{{ route('cart.destroy', '') }}/' + item,
                                type: 'delete',
                                success: function(data) {
                                    panier();
                                },
                            }).always(function() {
                                i.removeClass().addClass(txt);
                            });
                        });

                        $('.addtocart2').off('change').change(function() {
                            var field = $(this);
                            var item = $(this).attr('item');
                            var qty = this.value;
                            field.attr('disabled', true);
                            $.ajax({
                                url: '{{ route('cart.store') }}',
                                type: 'post',
                                data: {
                                    item: item,
                                    qty: qty,
                                },
                                success: function(data) {
                                    panier();
                                },
                                error: function(data, b, c) {
                                    var mdl = $('#m401');
                                    if (401 == data.status) {
                                        mdl.modal('show');
                                    }
                                    if (403 == data.status) {
                                        $('[alert]', mdl).html(
                                            "Action non autorisée.");
                                        $('[aclose]', mdl).hide();
                                        mdl.modal('show');
                                    }
                                }
                            }).always(function() {
                                field.attr('disabled', true);
                            });
                        });

                    },
                });
            }
            panier();

            cancall = true;
            var callback = function() {
                if (!cancall) return;
                $.ajax({
                    url: '{{ route('fpc') }}',
                    data: {
                        myref: REF,
                    },
                    success: function(res) {
                        var trans = res.transaction;
                        var status = trans?.status;
                        if (status === 'success') {
                            panier();
                            $('#btncancel').hide();
                            var form = $('#fpay');
                            var btn = $(':submit', form).attr('disabled', false);
                            btn.html('<i></i> Payer');
                            btn.removeClass().addClass('btn btn-primary btn-sm my-2');
                            rep = $('#rep', form);
                            rep.html(res.message).removeClass();
                            rep.addClass('alert alert-success');
                            rep.slideDown();
                            cancall = false;
                            $(':input', form).attr('disabled', false);

                        } else if (status === 'failed') {
                            $('#btncancel').hide();
                            var form = $('#fpay');
                            var btn = $(':submit', form).attr('disabled', false);
                            btn.html('<i></i> Payer');
                            btn.removeClass().addClass('btn btn-primary btn-sm my-2');
                            rep = $('#rep', form);
                            rep.html(
                                'La transaction a échoué, vous avez peut-être saisi un mauvais Pin. Veuillez de réessayer.'
                            ).removeClass();
                            rep.addClass('alert alert-danger');
                            rep.slideDown();
                            cancall = false;
                            $(':input', form).attr('disabled', false);

                        } else {
                            setTimeout(() => {
                                callback();
                            }, 3000);
                        }
                    },
                    error: function() {
                        setTimeout(() => {
                            callback();
                        }, 3000);
                    }
                });
            }

            $('#btncancel').click(function() {
                $(this).hide();
                var form = $('#fpay');
                var btn = $(':submit', form).attr('disabled', false);
                btn.html('<i></i> Payer');
                btn.removeClass().addClass('btn btn-primary btn-sm my-2');
                console.log(btn);
                var rep = $('#rep', form);
                rep.html("Paiement annulé.").removeClass();
                rep.addClass('alert alert-secondary');
                cancall = false;
                $(':input', form).attr('disabled', false);
            });

            $('#fpay').submit(function() {
                event.preventDefault();
                var form = $(this);
                var btn = $(':submit', form).attr('disabled', true);
                btn.find('i').removeClass()
                    .addClass('bx bx-loader bx-spin');
                var data = form.serialize();
                $(':input', form).attr('disabled', true);

                rep = $('#rep', form);
                rep.slideUp();

                cancall = true;

                $.ajax({
                    url: '{{ route('fpi') }}',
                    type: 'POST',
                    data: data,
                    timeout: 30000,
                    success: function(res) {
                        if (res.success == true) {
                            rep.html(res.message).removeClass();
                            rep.addClass('alert alert-success');
                            rep.slideDown();
                            btn.html(
                                '<i class="spinner-border spinner-border-sm"></i> En attente de validation ...'
                            );
                            btn.attr('disabled', true).removeClass('btn-primary').addClass(
                                'btn-warning');
                            REF = res.myref;
                            $('#btncancel').show().attr('disabled', false);
                            callback();

                        } else {
                            var m = res.message;
                            rep.removeClass().addClass('alert alert-danger').html(m)
                                .slideDown();
                            btn.attr('disabled', false).find('i').removeClass();
                            $(':input', form).attr('disabled', false);
                        }
                    },
                    error: function(resp) {
                        var mess = resp.responseJSON?.message ??
                            "Une erreur s'est produite, merci de réessayer";
                        rep.removeClass().addClass('alert alert-danger').html(mess)
                            .slideDown();
                        btn.find('i').removeClass();
                        $(':input', form).attr('disabled', false);

                    }
                });

            })

        })
    </script>


</body>

</html>
