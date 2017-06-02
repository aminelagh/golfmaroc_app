@extends('layouts.main_master')

@section('title') {{ $data->nom }} {{ $data->prenom }} @endsection

@section('main_content')
    <br>

    @include('layouts.alerts')

    <div class="col-lg-2"></div>
    <form method="POST" action="{{ route('admin.submitUpdateUser') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id_user" value="{{ $data->id }}">

        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Modification du Profile
                </div>
                <div class="panel-body">

                    {{-- row 1 --}}
                    <div class="row">

                        {{-- role --}}
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" class="form-control" disabled placeholder="Company"
                                       value="{{ \App\Models\User::getRole($data->id) }}">
                            </div>
                        </div>
                        {{-- magasin --}}
                        @if($data->id_magasin!=null || $data->id_magasin!=0)
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Magasin</label>
                                    <select class="form-control" name="id_magasin">
                                        @if( !$magasins->isEmpty() )
                                            @foreach( $magasins as $item )
                                                <option value="{{ $item->id_magasin }}"
                                                        @if( $item->id_magasin == $data->id_magasin ) selected @endif > {{ $item->libelle }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- row 2 --}}
                    <div class="row">
                        {{-- Email --}}
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                       value="{{ $data->email }}">
                            </div>
                        </div>
                    </div>

                    {{-- row 3 --}}
                    <div class="row">

                        {{-- nom --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" placeholder="Nom" name="nom"
                                       value="{{ $data->nom }}">
                            </div>
                        </div>
                        {{-- prenom --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prenom</label>
                                <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                       value="{{ $data->prenom }}">
                            </div>
                        </div>

                    </div>

                    {{-- row 4 --}}
                    <div class="row">

                        {{-- ville --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" class="form-control" placeholder="Ville" name="ville"
                                       value="{{ $data->ville }}">
                            </div>
                        </div>
                        {{-- telephone --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" class="form-control" placeholder="Telephone" name="telephone"
                                       value="{{ $data->telephone }}">
                            </div>
                        </div>
                        {{-- last login --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dernière connexion</label>
                                <input type="text" class="form-control" placeholder="Prenom" name="prenom"
                                       disabled=""
                                       value="{{ $data->last_login }}">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="panel-footer" align="center">
                    <input type="submit" value="Valider" class="btn btn-outline btn-primary">
                    <a href="{{ route('admin.updateUserPassword',[ 'p_id' => $data->id ]) }}"
                       onclick="return confirm('Êtes-vous sure de vouloir modifier le mot de passe de l\'utilisateur: {{ $data->nom }} {{ $data->prenom }} ?')"
                       type="button" class="btn btn-outline btn-default">Modifier le mot de passe</a>
                </div>
            </div>
        </div>
    </form>
    <div class="col-lg-2"></div>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection