@extends('layouts.main_master')

@section('title') Ajout Fournisseur @endsection

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
                <h1 class="page-header">Ajouter un Fournisseur</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item active"><a
                                href="{{ Route('direct.lister',['p_table' => 'fournisseurs' ]) }}"> Liste des
                            fournisseurs<</a></li>
                    <li class="breadcrumb-item active">Creation d'un fournisseur</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post"
                      action="{{ Route('direct.submitAdd',['p_table' => 'fournisseurs']) }}">
                {{ csrf_field() }}


                <!-- Row 1 -->
                    <div class="row">

                        <div class="col-lg-3">
                            {{-- Code --}}
                            <div class="form-group">
                                <label>Code du fournisseur</label>
                                <input type="text" class="form-control" placeholder="Code" name="code"
                                       value="{{ old('code') }}" autofocus>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            {{-- Libelle --}}
                            <div class="form-group">
                                <label>Nom du fournisseur</label>
                                <input type="text" class="form-control" placeholder="Libelle" name="libelle"
                                       value="{{ old('libelle') }}" required>
                            </div>
                        </div>

                    </div>
                    <!-- end row 1 -->


                    <!-- row 2 -->
                    <div class="row">

                        <div class="col-lg-12">
                            {{-- Description --}}
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" rows="2" placeholder="Description"
                                          name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                    </div>
                    <!-- end row 2 -->

                    <!-- row 3 -->
                    <div class="row" align="center">
                        {{-- Submit & Reset --}}
                        <!--label title="aa">cochez pour forcer l'ajout de l'article</label>
                        <input type="checkbox" name="force" value="true"><br-->
                        <button type="submit" name="submit" value="valider" class="btn btn-default">Valider
                        </button>
                        <button type="reset" class="btn btn-default">Effacer</button>
                    </div>
                    <!-- end row 3 -->

                    {{-- verifier si data exist et non vide
                    @if( isset($data) && !$data->isEmpty())
                        <hr>
                        <!-- row 5 -->
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6" align="center">
                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                        data-target="#demo10"
                                        title="Cliquez ici pour visualiser la liste des Fournisseurs existants">
                                    Liste des Fournisseurs
                                </button>
                                <div id="demo10" class="collapse">
                                    <br>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title" align="center">Fournisseurs <span
                                                        class="badge">{{ App\Models\Fournisseur::count() }}</span>
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="list-group" align="center">
                                                @foreach($data as $item)
                                                    <li class="list-group-item"><a
                                                                href="{{ route('direct.info',[ 'p_table' => 'fournisseurs' , 'p_id' => $item->id_fournisseur ]) }}"
                                                                title="detail sur le fournisseur"> {{ $item->libelle }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3"></div>
                        </div>
                        <!-- end row 5 -->
                    @endif
                    {{-- fin if --}}

                </form>

            </div>
        </div>
    </div>
@endsection


@section('menu_1')
    @include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Direct._nav_menu_2')
@endsection
