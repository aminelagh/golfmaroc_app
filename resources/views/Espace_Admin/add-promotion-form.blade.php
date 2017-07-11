@extends('layouts.main_master')

@section('title') Creation des promotions @endsection

@section('main_content')
    <h3 class="page-header">Creation des promotions</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des promotions</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.promotions') }}">Nouvelle vente simple</a></li>
        <li class="breadcrumb-item active">Creation des promotions</li>
    </ol>

    <div class="row">
        @if( !$data->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="1">Reference</a> -
                <a class="toggle-vis" data-column="2">Code</a> -
                <a class="toggle-vis" data-column="3">Designation</a> -
                <a class="toggle-vis" data-column="4">Marque</a> -
                <a class="toggle-vis" data-column="5">Categorie</a>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('admin.submitAddPromotions') }}">
                    {{ csrf_field() }}

                    <table id="myTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th rowspan="2"> #</th>
                            <th rowspan="2">Reference</th>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Designation</th>
                            <th rowspan="2">Marque</th>
                            <th rowspan="2">Categorie</th>
                            <th colspan="2">Prix de gros</th>
                            <th colspan="2">Prix</th>
                            <th rowspan="2">Taux</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th>HT</th>
                            <th>TTC</th>
                            <th>HT</th>
                            <th>TTC</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Reference</th>
                            <th>Code</th>
                            <th>Designation</th>
                            <th>Marque</th>
                            <th>Categorie</th>
                            <th>HT</th>
                            <th>TTC</th>
                            <th>HT</th>
                            <th>TTC</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach( $data as $item )

                            <tr {{--ondblclick="window.open('{{ Route('magas.stock',[ 'p_id' => $item->id_stock ]) }}');" --}}>

                                <input type="hidden" name="id_stock[{{ $loop->index+1 }}]"
                                       value="{{ $item->id_stock }}"/>

                                <td>{{ $loop->index+1 }}</td>
                                <td>
                                    {{ \App\Models\Article::getRef($item->id_article) }}
                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                </td>
                                <td>{{ \App\Models\Article::getCode($item->id_article) }}</td>
                                <td>
                                    @if( App\Models\Article::getImage($item->id_article) != null)
                                        <img src="{{ asset(App\Models\Article::getImage($item->id_article)) }}"
                                             width="40px"
                                             onmouseover="overImage('{{ asset(App\Models\Article::getImage($item->id_article)) }}');"
                                             onmouseout="outImage();">
                                    @endif
                                    {{ \App\Models\Article::getDesignation($item->id_article) }}
                                </td>
                                <td>{{ \App\Models\Article::getMarque($item->id_article) }}</td>
                                <td>{{ \App\Models\Article::getCategorie($item->id_article) }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                                <td align="right">
                                    <div id="prix_{{ $loop->iteration }}"
                                         title="{{ \App\Models\Article::getPrixTTC($item->id_article) }}">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</div>
                                </td>
                                <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                                <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                                <td align="center">
                                    <input type="number" pattern="##.##" step="1" min="0" max="100" name="taux_promotion[{{ $loop->iteration }}]"
                                           class="form-control">
                                </td>

                                <td align="center">
                                    <div data-toggle="modal" data-target="#modal{{ $loop->iteration }}">
                                        <i class="glyphicon glyphicon-info-sign"></i>
                                    </div>

                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="modal{{ $loop->iteration }}" role="dialog"
                                         tabindex="-1" aria-labelledby="gridSystemModalLabel">
                                        <div class="modal-dialog modal-me">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="gridSystemModalLabel">
                                                        <b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        {{-- detail article --}}
                                                        <div class="col-lg-12">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <tr>
                                                                    <td>Code</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reference</td>
                                                                    <th colspan="2">
                                                                        {{ \App\Models\Article::getRef($item->id_article) }}
                                                                        {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Marque</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getMarque($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Categorie</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCategorie($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Fournisseur</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getFournisseur($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Couleur</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCouleur($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sexe</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getSexe($item->id_article) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Prix de vente</td>
                                                                    <th>{{ \App\Models\Article::getPrixHT($item->id_article) }}
                                                                        Dhs HT
                                                                    </th>
                                                                    <th>
                                                                        {{ \App\Models\Article::getPrixTTC($item->id_article) }}
                                                                        Dhs TTC
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Prix de gros</td>
                                                                    <th>{{ \App\Models\Article::getPrixGrosHT($item->id_article) }}
                                                                        Dhs HT
                                                                    </th>
                                                                    <th>
                                                                        {{ \App\Models\Article::getPrixGrosTTC($item->id_article) }}
                                                                        Dhs TTC
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Code</td>
                                                                    <th colspan="2">{{ \App\Models\Article::getCode($item->id_article) }}</th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            Fermer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- fin Modal (pour afficher les details de chaque article) --}}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-4">
                                <label>Magasin</label>
                                <select class="form-control" name="id_magasin">
                                    @foreach($magasins as $magasin)
                                        <option value="{{ $magasin->id_magasin }}" {{ old('id_magasin') == $magasin->id_magasin ? 'selected' : '' }}>{{ $magasin->libelle }}
                                            <small>({{ $magasin->ville }})</small>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="submit" class="btn btn-primary center-block" value="Valider">
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('scripts')
    @if(!$data->isEmpty())

        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "HT" || title == "TTC") {
                        $(this).html('<input type="text" size="2" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix d'achat" || title == "Prix de vente") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        {"visible": true, "targets": -1},
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},  //ref
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},  //code

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},     //Marque
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},     //caegorie

                        {"width": "02%", "targets": 6, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 7, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "02%", "targets": 8, "type": "string", "visible": true},      //HT
                        {"width": "02%", "targets": 9, "type": "num-fmt", "visible": true},     //TTC

                        {"width": "05%", "targets": 10, "type": "num-fmt", "visible": true},     //etat

                        {"width": "04%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "select": {
                        items: 'column'
                    }
                });

                $('a.toggle-vis').on('click', function (e) {
                    e.preventDefault();
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                });

                table.columns().every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            });
        </script>
    @endif
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection

@section('styles')
    <style>
        #circle {
            width: 15px;
            height: 15px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
        }

        #myTable {
            width: 100%;
            border: 0px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #myTable td {
            padding: 5px;
        }


    </style>
@endsection
