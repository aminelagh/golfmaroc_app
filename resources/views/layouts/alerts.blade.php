
{{-- **************Alerts**************  }}
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">

        @if (session('alert_success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button> {!! session('alert_success') !!}
            </div>
        @endif
        @if (session('alert_info'))
        @section('scripts')
            <script>
                $.notify({
                    // options
                    icon: 'glyphicon glyphicon-warning-sign',
                    title: '{{ $title or '' }}',
                    message: '{!! session('alert_info') !!}',
                    url: '{{ session('route') ?  Route(session('route')) : ' ' }}',
                    target: '_blank'
                },{
                    // settings
                    element: 'body',
                    position: null,
                    type: "info",
                    allow_dismiss: true,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "{{ $from or 'top' }}",//from: "top",
                        align: "{{ $align or 'center' }}" //align: "center"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 5000,
                    timer: 0,
                    mouse_over: null,
                    animate: {
                        enter: 'animated zoomInDown',
                        exit: 'animated zoomOutDown'
                    },
                    onShow: null,
                    onShown: null,
                    onClose: null,
                    onClosed: null,
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
                });
            </script>
        @endsection
        @endif
        @if (session('alert_warning'))
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button> {!! session('alert_warning') !!}
            </div>
        @endif

        @if (session('alert_danger'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button> {!! session('alert_danger') !!}
            </div>
        @endif

    </div>
    <div class="col-lg-2"></div>
</div>
{{-- **************endAlerts**************  --}}