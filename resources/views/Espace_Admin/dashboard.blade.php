@extends('layouts.main_master')

@section('title') Espace Admin @endsection

@section('main_content')

    <h1 class="page-header">Espace administrateur</h1>


    <div class="row">
        @if(\App\Models\Article::hasNonValideArticles())
            <div class="col-lg-4">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ count(App\Models\Article::nonValideArticles()) }}</div>
                                <div>Articles non valide</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ Route('admin.articles_nv') }}">
                        <div class="panel-footer">
                            <span class="pull-left">Consulter</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        @endif

    </div>

@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection