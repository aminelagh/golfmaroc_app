@extends('layouts.main_master')

@section('title') Espace Vendeur @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Bienvenue dans votre Espace Vendeur </h1>

                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i> <a href="{{ Route('vend.home')  }}">Dashboard</a></li>
                    <li class="action"><i class="fa fa-file"></i> Blank Page</li>
                    <li class=""><i class="fa fa-file"></i> Blank Page</li>
                    <li class="active"><i class="fa fa-folder"></i> Blank Page</li>
                    <li class="active"><i class="fa fa-backward"></i> Blank Page</li>
                    <li class="active"><i class="fa fa-vk"></i> Blank Page</li>
                </ol>

                {{-- **************Alerts**************  --}}
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        {{-- Debut Alerts --}}
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
                        {{-- Fin Alerts --}}
                    </div>

                    <div class="col-lg-2"></div>
                </div>
                {{-- **************endAlerts**************  --}}

                <div class="row">

                    <!-- ventes -->
                    <div class="col-lg-4">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">XX{{-- App\Models\Transaction::where(['id_type_transaction'=> 3,'id_user'=> 3 ])->count() --}}</div>
                                        <div>Ventes établies</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{Route('vend.lister',['p_table' => 'transactions','p_id'=>3]) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- promotions -->
                    <div class="col-lg-4">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="glyphicon glyphicon-gift fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Promotion::where(['id_magasin'=> 2,'active'=>1])->count() }}</div>
                                        <div>Promotions disponibles</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{Route('vend.lister',['p_table' => 'promotions','p_id'=>3] )}}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- stock -->
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks  fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Stock::where(['id_magasin'=> 2])->count() }}</div>
                                        <div>Stock magasin</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{Route('vend.lister',['p_table' => 'stocks','p_id'=>3] )}}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection


@section('menu_1')
    @include('Espace_Vend._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Vend._nav_menu_2')
@endsection
