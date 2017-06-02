@extends('layouts.main_master')

@section('title') Espace Magasinier @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">

                <h1 class="page-header">Espace magasinier </h1>

                @include('layouts.alerts')

                <div class="row">
                    <!-- Articles -->
                    <div class="col-lg-3">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="glyphicon glyphicon-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Article::whereDeleted(false)->orWhere('deleted',null)->count() }}</div>
                                        <div>Articles</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('magas.lister',['p_table' => 'articles' ]) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="col-lg-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks  fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Categorie::whereDeleted(false)->count() }}</div>
                                        <div>Categories des Articles</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('magas.lister',['p_table' => 'categories' ]) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fournisseurs -->
                    <div class="col-lg-3">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Fournisseur::whereDeleted(false)->count() }}</div>
                                        <div>Fournisseurs</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('magas.lister',['p_table' => 'fournisseurs' ]) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Gestion stock -->
                    <div class="col-lg-3">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Magasin::whereDeleted(false)->count() }}</div>
                                        <div>Gestion Stock</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('magas.lister',['p_table' => 'magasins' ]) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestion promotions -->
                {{--
                <div class="row">
                    <div class="col-lg-3">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="glyphicon glyphicon-gift fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ App\Models\Promotion::count() }}</div>
                                        <div>Gestion des Promotions</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ Route('magas.lister',['p_table' => 'promotions' ]) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Consulter</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                --}}
            </div>
        </div>
    </div>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection
