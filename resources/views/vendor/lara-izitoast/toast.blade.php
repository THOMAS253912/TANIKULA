<script>
            @foreach( session('toasts', collect())->toArray() as $toast)
    var options = {
            title: '{{ $toast['title'] }}',
            message: '{{ $toast['message'] }}',
            messageColor: '{{ $toast['messageColor'] }}',
            messageSize: '15px',
            titleLineHeight: '15px',
            messageLineHeight: '15px',
            position: '{{ $toast['position'] }}',
            titleSize: '15px',
            titleColor: '{{ $toast['titleColor'] }}',
            closeOnClick: '{{ $toast['closeOnClick'] }}',

        };

//         DB_DATABASE=u5687430_gapoktan_db
// DB_USERNAME=u5687430
// DB_PASSWORD=@Polindra2022

    var type = '{{  $toast["type"] }}';

    show(type, options);

    @endforeach
    function show(type, options) {
        if (type === 'info'){
            iziToast.info(options);
        }
        else if (type === 'success'){
            iziToast.success(options);
        }
        else if  (type === 'warning'){
            iziToast.warning(options);
        }
        else if (type === 'error'){
            iziToast.error(options);
        } else {
            iziToast.show(options);
        }

    }
</script>

{{ session()->forget('toasts') }}
