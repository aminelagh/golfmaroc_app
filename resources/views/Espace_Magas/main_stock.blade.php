@extends('layouts.main_master')

@section('title') Stock du main magasin: {{ $magasin->libelle }}  @endsection

@section('main_content')

    <h3 class="page-header">Stock du magasin principal:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des magasins</li>
        <li class="breadcrumb-item "><a href="{{ route('magas.magasin') }}">{{ $magasin->libelle  }}</a></li>
        <li class="breadcrumb-item active">Stock du magasin: {{ $magasin->libelle  }}</li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddStockIN') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>

                    @foreach( $data as $item )
                        <input type="hidden" name="id_stock[{{ $loop->index+1 }}]" value="{{ $item->id_stock }}"/>


                        {{-- Container --}}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b></h4>
                            </div>

                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#article_{{ $loop->index+1 }}" data-toggle="tab">Article</a>
                                    </li>
                                    <li>
                                        <a href="#stock_{{ $loop->index+1 }}" data-toggle="tab">Stock</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="article_{{ $loop->index+1 }}">
                                        <table class="table table-striped table-bordered table-hover">
                                            <tr>
                                                <td align="right">Marque</td>
                                                <th>{{ \App\Models\Article::getMarque($item->id_article) }}</th>
                                                <td align="right">Categorie</td>
                                                <th>{{ \App\Models\Article::getCategorie($item->id_article) }}</th>
                                                <td align="right">Fournisseur</td>
                                                <th>{{ \App\Models\Article::getFournisseur($item->id_article) }}</th>
                                            </tr>
                                            <tr>
                                                <td align="right">Code</td>
                                                <th>{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                <td align="right">Reference</td>
                                                <th>{{ \App\Models\Article::getRef($item->id_article) }}
                                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article) : '' }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td align="right">Couleur</td>
                                                <th>{{ \App\Models\Article::getCouleur($item->id_article) }}</th>
                                                <td align="right">Sexe</td>
                                                <th>{{ \App\Models\Article::getSexe($item->id_article) }}</th>
                                                <td align="right">Prix</td>
                                                <th align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}
                                                    Dhs
                                                </th>
                                            </tr>

                                            @if( \App\Models\Stock_taille::hasTailles($item->id_stock))
                                                <tr>
                                                    <td colspan="6" align="center"><b><i>Etat du stock</i></b></td>
                                                </tr>
                                                @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                    <tr>
                                                        <td align="right">
                                                            Taille
                                                            <b>{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</b>
                                                        </td>
                                                        <td colspan="5">
                                                            <div class="progress">
                                                                <div style="width: {{ ($taille->quantite/$item->quantite_max)*100 }}%"
                                                                     @if($taille->quantite==$item->quantite_min)
                                                                     class="progress-bar progress-bar-warning progress-bar-striped active"
                                                                     @elseif($taille->quantite>$item->quantite_min)
                                                                     class="progress-bar progress-bar-success progress-bar-striped active"
                                                                     @else
                                                                     class="progress-bar progress-bar-danger progress-bar-striped active"
                                                                        @endif
                                                                >
                                                                {{ ($taille->quantite/$item->quantite_max)*100 }}%
                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" align="center"><b><i>Stock vide</i></b></td>
                                                </tr>
                                            @endif


                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="stock_{{ $loop->index+1 }}">
                                        <table id="example_{{$loop->index+1}}"
                                               class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Taille</th>
                                                <th>Quantite disponible</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if( \App\Models\Stock_taille::hasTailles($item->id_stock))
                                                @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                                    <tr>
                                                        <input type="hidden"
                                                               name="id_taille_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                               value="{{ $taille->id_taille_article }}"/>

                                                        <td align="right">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                                        <td align="right">{{ $taille->quantite }}</td>


                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" align="center">Non disponible</td>
                                                </tr>
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.Container --}}


                    @endforeach

                    <input type="submit" value="Ajouter StockIN" class="btn btn-outline btn-success"
                           formtarget="_blank">
                </form>

            </div>
        </div>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection


@section('scripts')
    <script>
    </script>
@endsection
