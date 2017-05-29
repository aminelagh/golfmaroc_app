@extends('layouts.main_master')

@section('title'){{ $data->nom }} {{ $data->prenom }}@endsection

@section('main_content')

    <h1 class="page-header">Modifier le mot de passe</h1>


    @include('layouts.alerts')

    {{-- *************** formulaire ***************** --}}
    <form role="form" method="post"
          action="{{ Route('admin.submitUpdate',['p_table' => 'user_password' ]) }}">
        {{ csrf_field() }}

        <input type="hidden" class="form-control" name="id_user" value="{{ $data->id_user }}">


        <!-- Row 1 -->
        <div class="row">

            <div class="col-lg-3">
                {{-- Role --}}
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="id_role" disabled>
                        @if( !$roles->isEmpty() )
                            @foreach( $roles as $item )
                                <option value="{{ $item->id_role }}"
                                        @if( $item->id_role == $data->id_role ) selected @endif >{{ $item->libelle }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                {{-- Magasin --}}
                <div class="form-group">
                    <label>Magasin</label>
                    <select class="form-control" name="id_magasin" disabled>
                        <option value="0" selected>Aucun</option>
                        @if( !$magasins->isEmpty() )
                            @foreach( $magasins as $item )
                                <option value="{{ $item->id_magasin }}"
                                        @if( $item->id_magasin == $data->id_magasin ) selected @endif >{{ $item->libelle }}
                                    a {{ $item->ville }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                {{-- Email --}}
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="E-mail" name="email"
                           value="{{ $data->email }}" disabled>
                    <p class="help-block">utilisé pour l'authentification</p>
                </div>
            </div>

            <div class="col-lg-3">
                {{-- Password --}}
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" placeholder="Password" name="password"
                           required min="9">
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
                    <input type="text" class="form-control" placeholder="Nom" name="nom"
                           value="{{ $data->nom }}" disabled>
                </div>
            </div>

            <div class="col-lg-3">
                {{-- Prenom --}}
                <div class="form-group">
                    <label>Prenom</label>
                    <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                           value="{{ $data->prenom }}" disabled>
                </div>
            </div>

            <div class="col-lg-3">
                {{-- Ville --}}
                <div class="form-group">
                    <label for="disabledSelect">Ville</label>
                    <input type="text" class="form-control" placeholder="Ville" name="ville"
                           value="{{ $data->ville }}" disabled>
                </div>
            </div>

            <div class="col-lg-3">
                {{-- Telephone --}}
                <div class="form-group">
                    <label for="disabledSelect">Telephone</label>
                    <input type="number" class="form-control" placeholder="Telephone" name="telephone"
                           value="{{ $data->telephone }}" disabled>
                </div>
            </div>

        </div>
        <!-- end row 2 -->

        <!-- row 3 -->
        <div class="row">

            <div class="col-lg-6">
                {{-- Description --}}
                <div class="form-group">
                    <label>Description</label>
                    <textarea type="text" class="form-control" rows="5" placeholder="Description"
                              name="description" disabled>{{ $data->description }}</textarea>
                </div>
            </div>

            <div class="col-lg-6">
                <br/><br/>
                {{-- Submit & Reset --}}
                <button type="submit" name="submit" value="valider" class="btn btn-default" width="60">
                    Valider
                </button>
                <button type="reset" value="" class="btn btn-default">Réinitialiser</button>
            </div>

        </div>

    </form>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection