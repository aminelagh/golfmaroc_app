@extends('layouts.main_master')

@section('title') Fournisseur: {{ $data->libelle }} @endsection

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
    <!-- container-fluid -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="col-lg-12">
            <div class="row">

                <h1 class="page-header">Fournisseur</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',[ 'p_table' => 'fournisseurs' ]) }}">Liste
                            des fournisseurs</a></li>
                    <li class="breadcrumb-item active">{{ $data->libelle }}</li>
                </ol>

                <div id="page-wrapper">

                    @include('layouts.alerts')

                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">

                            <!-- debut panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading" align="center">
                                    <h2>{{ $data->libelle }} ({{ App\Models\Article::whereIdFournisseur($data->id_fournisseur)->Where('deleted',false)->orWhere('deleted',null)->count() }} articles)</h2>
                                    <h3>{{ $data->code }}</h3>

                                </div>

                                <!-- debut panel body -->
                                <div class="panel-body">
                                    <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">
                                        @if( !$agents->isEmpty())
                                            @foreach($agents  as $item)
                                                <tr><td colspan="2" align="center"><h4><b>{{ $item->nom }} {{ $item->prenom }}</b>: {{ $item->role }}</h4></td></tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <th>{{ $item->email }}</th>
                                                </tr>
                                                <tr>
                                                    <td>Telephone</td>
                                                    <th>{{ $item->telephone }}</th>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>

                                    @if( strlen($data->description) > 0 )
                                        <div class="well">
                                            <p>{{ $data->description }}</p>
                                        </div>
                                    @endif


                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4" align="center">
                                        <a href="{{ Route('magas.delete',['p_table' => 'magasins', 'p_id' => $data->id_magasin ]) }}"
                                           onclick="return confirm('Êtes-vous sure de vouloir effacer le fournisseur: {{ $data->libelle }} ?')"
                                           type="button" class="btn btn-outline btn-danger">Supprimer </a>
                                        <a href="{{ Route('magas.update',['id_article' => $data->id_fournisseur, 'p_table' => 'fournisseurs' ]) }}"
                                           type="button" class="btn btn-outline btn-info"> Modifier </a>

                                    </div>

                                </div>
                                <!-- fin panel body -->

                            </div>
                            <!-- fin panel -->

                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- /#page-wrapper -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

