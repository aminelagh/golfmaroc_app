@extends('layouts.main_master')

@section('title') Ajouter Utilisateur @endsection

@section('main_content')

    <h1 class="page-header">Ajouter un Utilisateur</h1>

    @include('layouts.alerts')

    <div class="panel panel-default">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            {{-- *************** formulaire ***************** --}}
            <form role="form" method="post" action="{{ Route('admin.submitAdd',['p_table' => 'users']) }}">
            {{ csrf_field() }}

                <input type="hidden" name="deleted" value="0">

            <!-- Row 1 -->
                <div class="row">

                    <div class="col-lg-2">
                        {{-- Role --}}
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="id_role">
                                @if( !$roles->isEmpty() )
                                    @foreach( $roles as $item )
                                        <option value="{{ $item->id }}"
                                                @if( $item->id == old('id_role') ) selected @endif >{{ $item->name }} ({{ $item->slug }})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        {{-- Magasin --}}
                        <div class="form-group">
                            <label>Magasin</label>
                            <select class="form-control" name="id_magasin" id="id_magasin">
                                <option value="0" selected>Aucun</option>
                                @if( !$magasins->isEmpty() )
                                    @foreach( $magasins as $item )
                                        <option value="{{ $item->id_magasin }}"
                                                @if( $item->id_magasin == old('id_magasin') ) selected @endif >{{ $item->libelle }}
                                            a {{ $item->ville }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        {{-- Email --}}
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="E-mail" name="email"
                                   id="email" value="{{ old('email') }}" required autofocus>
                            <p class="help-block">utilisé pour l'authentification</p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        {{-- Password --}}
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" placeholder="Password" name="password"
                                   id="password" required min="9">
                        </div>
                    </div>

                </div>
                <!-- end row 1 -->

                <!-- row 2 -->
                <div class="row">

                    <div class="col-lg-3">
                        {{-- nom --}}
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom"
                                   value="{{ old('nom') }}" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        {{-- Prenom --}}
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                   id="prenom" value="{{ old('prenom') }}">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        {{-- Ville --}}
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" class="form-control" placeholder="Ville" name="ville" id="ville"
                                   value="{{ old('ville') }}">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        {{-- Telephone --}}
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="number" class="form-control" placeholder="Telephone" name="telephone"
                                   id="telephone" value="{{ old('telephone') }}">
                        </div>
                    </div>

                </div>
                <!-- end row 2 -->

                <!-- row 3 -->
                <div class="row" align="center">
                    {{-- Submit & Reset --}}
                    <button type="submit" name="submit" value="valider" class="btn btn-default" width="60">
                        Valider
                    </button>
                    <button type="reset" class="btn btn-default">Effacer</button>


                </div>

            </form>

        </div>
    </div>

@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection