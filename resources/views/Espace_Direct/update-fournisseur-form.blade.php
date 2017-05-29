@extends('layouts.main_master')

@section('title') Modifier Fournisseur : {{ $data->libelle }} @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
    <script>
        //script pour le popover detail
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection

@section('main_content')
    <!-- container-fluid -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Modifier un Fournisseur</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('direct.lister',[ 'p_table' => 'fournisseurs' ]) }}">Liste
                            des fournisseurs</a></li>
                    <li class="breadcrumb-item active">Modifier fournisseur : {{ $data->libelle }}</li>
                </ol>

                <div id="page-wrapper">

                    @include('layouts.alerts')

                    <div class="row">
                        {{-- *************** formulaire ***************** --}}
                        <form role="form" method="post"
                              action="{{ Route('direct.submitUpdate',['p_table' => 'fournisseurs' ]) }}">
                            {{ csrf_field() }}

                            <input type="hidden" class="form-control" name="id_fournisseur"
                                   value="{{ $data->id_fournisseur }}">

                            <!-- Row 1 -->
                            <div class="row">

                                <div class="col-lg-2">
                                    {{-- Code --}}
                                    <div class="form-group">
                                        <label>Code du fournisseur</label>
                                        <input type="text" class="form-control" placeholder="Code" name="code"
                                               value="{{ $data->code}}" autofocus>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    {{-- Libelle --}}
                                    <div class="form-group">
                                        <label>Libelle</label>
                                        <input type="text" class="form-control" placeholder="Libelle" name="libelle"
                                               value="{{ $data->libelle }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    {{-- Agent --}}
                                    <div class="form-group">
                                        <label>Nom du representant</label>
                                        <input type="text" class="form-control" placeholder="Agent" name="agent"
                                               value="{{ $data->agent }}">
                                    </div>
                                </div>

                            </div>
                            <!-- end row 1 -->

                            <!-- Row 2 -->
                            <div class="row">

                                <div class="col-lg-6">
                                    {{-- Email --}}
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                               value="{{$data->email }}">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    {{-- Telephone --}}
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" class="form-control" placeholder="Telephone" name="telephone"
                                               value="{{ $data->telephone }}">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    {{-- Fax --}}
                                    <div class="form-group">
                                        <label>Fax</label>
                                        <input type="text" class="form-control" placeholder="Fax" name="fax"
                                               value="{{ $data->fax }}">
                                    </div>
                                </div>

                            </div>
                            <!-- end row 2 -->

                            <!-- row 3 -->
                            <div class="row">

                                <div class="col-lg-12">
                                    {{-- Description --}}
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea type="text" class="form-control" rows="2" placeholder="Description"
                                                  name="description">{{ $data->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- end row 3 -->

                            <!-- row 4 -->
                            <div class="row" align="center">
                                <button type="submit" name="submit" value="valider"
                                        class="btn btn-default" {!! setPopOver("","Valider la modificartion du fournisseur") !!}>
                                    Valider
                                </button>
                                <button type="reset"
                                        class="btn btn-default" {!! setPopOver("","Réinitialiser les valeurs initiales") !!}>
                                    Réinitialiser
                                </button>

                            </div>
                            <!-- end row 4 -->

                        </form>
                        {{-- ************** /.formulaire **************** --}}
                    </div>

                </div>
                <!-- /.page-wrapper -->

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection


@section('menu_1')
    @include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Direct._nav_menu_2')
@endsection
