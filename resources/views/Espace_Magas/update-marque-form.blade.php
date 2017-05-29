@extends('layouts.main_master')

@section('title') Modifier Categorie : {{ $data->libelle }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Modification de la marque <b>{{ $data->libelle }}</b></h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'articles' ]) }}">Liste
                            des marques</a></li>
                    <li class="breadcrumb-item active "> {{ $data->libelle  }}</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post"
                      action="{{ Route('magas.submitUpdate',['p_table' => 'marques']) }}">
                    {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="id_marque" value="{{ $data->id_marque }}">

                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-lg-6">
                            {{-- Libelle --}}
                            <div class="form-group">
                                <label>Marque</label>
                                <input type="text" class="form-control" placeholder="Libelle " name="libelle"
                                       value="{{ $data->libelle }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            {{-- Description --}}
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" rows="3" placeholder="Description"
                                          name="description">{{ $data->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end row 1 -->


                    <!-- row 2 -->
                    <div class="row" align="center">
                        {{-- Submit & Reset --}}
                        <button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
                        <button type="reset" class="btn btn-default">Réinitialiser</button>
                    </div>
                    <!-- end row 2 -->

                </form>
                {{-- *************** formulaire ***************** --}}

            </div>
        </div>
    </div>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
@endsection