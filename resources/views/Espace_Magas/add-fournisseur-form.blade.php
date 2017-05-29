@extends('layouts.main_master')

@section('title') Ajout Fournisseur @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Creation d'un fournisseur</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item active"><a
                                href="{{ Route('magas.lister',['p_table' => 'fournisseurs' ]) }}"> Liste des
                            fournisseurs</a></li>
                    <li class="breadcrumb-item active">Creation d'un fournisseur</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post"
                      action="{{ Route('magas.submitAdd',['p_table' => 'fournisseurs']) }}">
                {{ csrf_field() }}


                <!-- Row 1 -->
                    <div class="row">
                        <div class="col-lg-2">
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
                                <label>Libelle</label>
                                <input type="text" class="form-control" placeholder="Libelle" name="libelle"
                                       value="{{ old('libelle') }}" required>
                            </div>
                        </div>
                        {{--
                        <div class="col-lg-5">
                            {{-- Agents
                            <div class="form-group">
                                <label>Categorie</label>
                                <select class="form-control" name="id_categorie" autofocus>
                                    @if( !$agents->isEmpty() )
                                        @foreach( $agents as $item )
                                            <option value="{{ $item->id_categorie }}"
                                                    @if( $item->id_agent == old('id_agent') ) selected
                                                    @endif multiple> {{ $item->nom }} {{ $item->prenom }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="null">Aucun agent</option>
                                    @endif
                                </select>
                            </div>
                        </div>--}}
                    </div>
                    <!-- end row 1 -->

                    <!-- row 3 -->
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
                    <!-- end row 3 -->

                    <!-- row 4 -->
                    <div class="row" align="center">
                        <button type="submit" name="submit" value="valider" class="btn btn-default">Valider
                        </button>
                        <button type="reset" class="btn btn-default">Effacer</button>
                    </div>
                    <!-- end row 4 -->

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
                                                                href="{{ route('magas.info',[ 'p_table' => 'fournisseurs' , 'p_id' => $item->id_fournisseur ]) }}"
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
