{{-- **************Alerts**************  --}}
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
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button> {!! session('alert_info') !!}
            </div>
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