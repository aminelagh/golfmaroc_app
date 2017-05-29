@extends('layouts.main_master')

@section('title') Article: {{ $data->designation_c }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">

                <h1 class="page-header">Info Article</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'articles' ]) }}">Liste
                            des articles</a></li>
                    <li class="breadcrumb-item active">{{ $data->designation_c }}</li>
                </ol>

            @include('layouts.alerts')
            <!-- row info -->
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">

                        <!-- debut panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading" align="center">
                                <h2>{{ $data->designation_c }} &nbsp;&nbsp; @if( $data->image != null) <img
                                            src="{{ $data->image }}"
                                            width="150px">@endif</h2>

                            </div>
                            <!-- debut panel body -->
                            <div class="panel-body">
                                <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <td>Numero de l'article</td>
                                        <th>{{ $data->num_article }} </th>
                                    </tr>
                                    <tr>
                                        <td>Code a Barres</td>
                                        <th>{{ $data->code_barre }} </th>
                                    </tr>
                                    <tr>
                                        <td>Categorie</td>
                                        <th>{{ \App\Models\Categorie::getLibelle($data->id_categorie) }} </th>
                                    </tr>
                                    <tr>
                                        <td>Fournisseur</td>
                                        <th>{{ \App\Models\Fournisseur::getLibelle($data->id_fournisseur) }} </th>
                                    </tr>
                                    <tr>
                                        <td>Marque</td>
                                        <th>{{ \App\Models\Marque::getLibelle($data->id_marque) }} </th>
                                    </tr>
                                    <tr>
                                        <td>Designation Courte</td>
                                        <th>{{ $data->designation_c }} </th>
                                    </tr>
                                    <tr>
                                        <td>Taille</td>
                                        <th>{{ $data->taille }} </th>
                                    </tr>
                                    <tr>
                                        <td>Couleur</td>
                                        <th>{{ $data->couleur }} </th>
                                    </tr>
                                    <tr>
                                        <td>Sexe</td>
                                        <th>{{ $data->sexe }} </th>
                                    </tr>
                                    <tr>
                                        <td>Prix d'achat</td>
                                        <th>{{ $data->prix_achat }} Dhs HT, &nbsp;&nbsp; {{ \App\Models\Article::getPrix_TTC($data->prix_achat) }} Dhs TTC</th>
                                    </tr>
                                    <tr>
                                        <td>Prix de vente</td>
                                        <th>{{ $data->prix_vente }} Dhs HT, &nbsp;&nbsp; {{ \App\Models\Article::getPrix_TTC($data->prix_vente) }} Dhs TTC</th>
                                    </tr>
                                    <tr>
                                        <td>Date de creation</td>
                                        <th>{{ getDateHelper($data->created_at) }}
                                            a {{ getTimeHelper($data->created_at) }}    </th>
                                    </tr>
                                    <tr>
                                        <td>Date de derniere modification</td>
                                        <th>{{ getDateHelper($data->updated_at) }}
                                            a {{ getTimeHelper($data->updated_at) }}     </th>
                                    </tr>
                                </table>


                                @if( strlen($data->designation_l) > 0 )
                                    <div class="page-header">
                                        <h3>Designation Longue</h3>
                                    </div>
                                    <div class="well">
                                        <p>{{ $data->designation_l }}</p>
                                    </div>
                                @endif


                                <div class="row" align="center">
                                    <a href="{{ Route('magas.delete',['p_table' => 'articles', 'p_id' => $data->id_article ]) }}"
                                       onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $data->designation_c }} ?')"
                                       type="button" class="btn btn-outline btn-danger"
                                            {!! setPopOver("Supprimer l'article","Attention, cette action peut avoir des effets sur les stocks des magasins") !!}>Supprimer </a>
                                    <a href="{{ Route('magas.update',['id_article' => $data->id_article, 'p_table' => 'articles' ]) }}"
                                       type="button" class="btn btn-outline btn-info"
                                            {!! setPopOver("","Modifier l'article") !!}> Modifier </a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
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