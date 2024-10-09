<script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/js/sticky.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.js') }}"></script>
<script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/ecommerce-dashboard.js') }}"></script>
<script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script src="{{ asset('assets/js/jq.min.js') }}"></script>
<script src="{{ asset('assets/js/show-password.js') }}"></script>

<script>
    document.querySelectorAll(".modal-effect").forEach(e => {
        e.addEventListener('click', function(e) {
            e.preventDefault();
            let effect = this.getAttribute('data-bs-effect');
            let id = this.getAttribute('href');
            let el = document.querySelector(id)
            el.classList.add(effect);
            el.removeEventListener('hidden.bs.modal', function() {});
            el.addEventListener('hidden.bs.modal', function(e) {
                try {
                    let removeClass = this.classList.value.match(/(^|\s)effect-\S+/g);
                    removeClass = removeClass[0].trim();
                    this.classList.remove(removeClass);
                } catch (error) {

                }
            });
        });
    });


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
    })
</script>
