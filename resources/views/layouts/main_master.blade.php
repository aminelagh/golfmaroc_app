<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('anime/anime.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body>

<div id="wrapper">

    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">GolfMaroc</a>
        </div>

        @yield('menu_1')

        @yield('menu_2')

    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @yield('main_content')

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.js') }}"></script>
<script src="{{ asset('anime/bootstrap-notify.js') }}"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });


</script>

{{-- Alerts --}}
<script>
    @if (isset($alert_success))
$.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: '{!! $title_success or '' !!}',
        message: '{!! $alert_success !!}',
        url: '{{ isset($route_success)? Route($route_s) : '' }}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "success",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{{ $from_success or 'top' }}",//from: "top",
            align: "{{ $align_success or 'center' }}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {{ $timer_success or 5000 }},
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },

        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
    @endif

    @if (isset($alert_info))
$.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: '{!! $title_info or '' !!}',
        message: '{!! $alert_info !!}',
        url: '{{ isset($route_info)? Route($route_info) : '' }}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "info",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{{ $from_info or 'top' }}",//from: "top",
            align: "{{ $align_info or 'center' }}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {{ $timer_info or 5000 }},
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },

        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
    @endif

@if(isset($alert_warning))
$.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: '{!! $title_warning or '' !!}',
        message: '{!! $alert_warning !!}',
        url: '{{ isset($route_warning)? Route($route_warning) : '' }}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "warning",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{{ $from_warning or 'top' }}",//from: "top",
            align: "{{ $align_warning or 'center' }}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {{ $timer_warning or 5000 }},
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },

        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
    @endif

    @if(isset($alert_danger))
$.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: '{!! $title_danger or '' !!}',
        message: '{!! $alert_danger !!}',
        url: '{{ isset($route_danger)? Route($route_danger) : '' }}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "danger",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{{ $from_danger or 'top' }}",//from: "top",
            align: "{{ $align_danger or 'center' }}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {{ $timer_danger or 5000 }},
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },

        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
    @endif
</script>

@yield('scripts')
</body>

</html>
