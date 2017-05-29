@extends('layouts.main_master')

@section('title') Ajout agent @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">

                <h1 class="page-header">Ajouter un agent</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item active"><a
                                href="{{ Route('magas.lister',['p_table' => 'agents' ]) }}"> Liste des
                            agents</a></li>
                    <li class="breadcrumb-item active">Création d'un agent</li>
                </ol>

                @include('layouts.alerts')

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post"
                      action="{{ Route('magas.submitAdd',['p_table' => 'agents']) }}">
                {{ csrf_field() }}


                <!-- Row 1 -->
                    <div class="row">

                        <div class="col-lg-3">
                            {{-- Categorie --}}
                            <div class="form-group">
                                <label>fournisseur</label>
                                <select class="form-control" name="id_fournisseur" autofocus>
                                    @if( !$fournisseurs->isEmpty() )
                                        @foreach( $fournisseurs as $item )
                                            <option value="{{ $item->id_fournisseur }}"
                                                    @if( $item->id_fournisseur == old('id_fournisseur') ) selected @endif > {{ $item->libelle }}
                                                {{-- DB::table('articles')->whereIdCategorie($item->id_categorie)->count() --}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Nom --}}
                            <div class="form-group">
                                <label>Nom *</label>
                                <input type="text" class="form-control" placeholder="Nom " name="nom"
                                       value="{{ old('nom') }}" required>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Prenom --}}
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control" placeholder="Prenom " name="prenom"
                                       value="{{ old('prenom') }}" required>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            {{-- Role --}}
                            <div class="form-group">
                                <label>Role *</label>
                                <input type="text" class="form-control" placeholder="Role " name="role"
                                       value="{{ old('role') }}">
                            </div>
                        </div>

                    </div>
                    <!-- end row 1 -->

                    <div class="row">
                        <div class="col-lg-3">
                            {{-- Telephone --}}
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone " name="telephone"
                                       value="{{ old('telephone') }}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            {{-- Email --}}
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Email " name="email"
                                       value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>


                    <!-- row 4 -->
                    <div class="row" align="center">
                        <button type="submit" name="submit" value="valider" class="btn btn-default">Valider</button>
                        <button type="reset" class="btn btn-default">Effacer</button>
                    </div>
                    <!-- end row 4 -->

                    {{-- verifier si data exist et non vide --}}
                    @if( isset($data) && !$data->isEmpty())
                        <hr>
                        <!-- row 5 -->
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6" align="center">
                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                        data-target="#demo10"
                                        title="Cliquez ici pour visualiser la liste des articles existants">Liste
                                    des Categories
                                </button>
                                <div id="demo10" class="collapse"
                                     style="margin:25px 0;height:200px;border:none;width:100%;">
                                    <br>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title" align="center">Categories <span
                                                        class="badge">{{ App\Models\Categorie::count() }}</span>
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="list-group" align="center">
                                                @foreach($data as $item)
                                                    <li class="list-group-item">
                                                        <a title="detail sur la categorie"
                                                           href="{{ route('magas.info',[ 'p_table' => 'categories' , 'p_id' => $item->id_categorie ]) }}"> {{ $item->libelle }}</a>
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