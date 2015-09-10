@if(session()->has('flash_message'))
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut" };

            toastr.{{session('flash_message.level')}}( "{{ session('flash_message.message') }}", "{{ session('flash_message.title') }}" );
    </script>
@endif