@extends('layouts.main_master')

@section('title') Espace Admin @endsection

@section('main_content')

    <h1 class="page-header">Bienvenue dans votre espace Admin</h1>

    @if( Sentinel::check())
        <h1>Hello <small>{{ Sentinel::getUser()->prenom }}, {{ Sentinel::getUser()->nom }}</small></h1>
        <h2><a href="/logout">Logout</a></h2>

    @else
        <h2><a href="/login">Login</a></h2>
    @endif



    <!-- Gestion promotions -->
    <div class="row">

        <div class="col-lg-4">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ App\Models\User::count() }}</div>
                            <div>Gestion des Utilisateurs</div>
                        </div>
                    </div>
                </div>
                <a href="{{ Route('admin.lister',['p_table' => 'users' ]) }}">
                    <div class="panel-footer">
                        <span class="pull-left">Consulter</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>

@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection