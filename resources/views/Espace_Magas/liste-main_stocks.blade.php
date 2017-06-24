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

    <div class="row" align="center">
        <a type="button" class="btn btn-outline btn-primary" href="{{ Route('magas.addStockIN') }}">
            <i class="glyphicon glyphicon-arrow-down"></i> Entrée de stock</a>
        <a type="button" class="btn btn-outline btn-primary" href="{{ Route('magas.addStockOUT') }}">
            Sortie de stock <i class="glyphicon glyphicon-arrow-up"></i> </a>
    </div>

    <div class="row">
        @if( !$data->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer:
                <a class="toggle-vis" data-column="1">Reference</a> -
                <a class="toggle-vis" data-column="2">Code</a> -
                <a class="toggle-vis" data-column="3">Designation</a> -
                <a class="toggle-vis" data-column="4">Marque</a> -
                <a class="toggle-vis" data-column="5">Categorie</a> -
            </div>
        @endif
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
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
                        <th rowspan="2">Etat</th>
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
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>
                                {{ \App\Models\Article::getRef($item->id_article) }}
                                {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                            </td>
                            <td>{{ \App\Models\Article::getCode($item->id_article) }}</td>
                            <td>
                                @if( App\Models\Article::getImage($item->id_article) != null) <img
                                        src="{{ asset(App\Models\Article::getImage($item->id_article)) }}"
                                        width="40px">@endif
                                {{ \App\Models\Article::getDesignation($item->id_article) }}
                            </td>
                            <td>{{ \App\Models\Article::getMarque($item->id_article) }}</td>
                            <td>{{ \App\Models\Article::getCategorie($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixHT($item->id_article) }}</td>
                            <td align="right">{{ \App\Models\Article::getPrixTTC($item->id_article) }}</td>
                            <td>
                                @if(\App\Models\Stock::getState($item->id_stock) == 0)
                                    <div id="circle" style="background: darkred;"></div>
                                    Aucun
                                @elseif(\App\Models\Stock::getState($item->id_stock) == 1)
                                    <div id="circle" style="background: red;"></div>

                                @elseif(\App\Models\Stock::getState($item->id_stock) == 2)
                                    <div id="circle" style="background: orange;"></div>
                                @elseif(\App\Models\Stock::getState($item->id_stock) == 3)
                                    <div id="circle" style="background: lawngreen;"></div>
                                    Disponible
                                @endif
                            </td>
                            <td>
                                <a href=""><i class="glyphicon glyphicon-plus"></i></a>
                                <a href=""><i class="glyphicon glyphicon-minus"></i></a>
                                <a data-toggle="modal" data-target="#modal{{ $loop->index+1 }}"><i
                                            class="glyphicon glyphicon-info-sign"
                                            aria-hidden="false"></i></a>
                            </td>
                        </tr>

                        {{-- Modal (pour afficher les details de chaque article) --}}
                        <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog"
                             tabindex="-1" aria-labelledby="gridSystemModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h3 class="modal-title" id="gridSystemModalLabel">
                                            <b>{{ \App\Models\Article::getDesignation($item->id_article) }}</b></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-4">Code</div>
                                            <div class="col-md-6">
                                                <b>{{ \App\Models\Article::getCode($item->id_article) }}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Reference</div>
                                            <div class="col-md-6"><b>
                                                    {{ \App\Models\Article::getRef($item->id_article) }}
                                                    {{ \App\Models\Article::getAlias($item->id_article)!=null ? ' - '.\App\Models\Article::getAlias($item->id_article):' ' }}
                                                </b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Marque</div>
                                            <div class="col-md-6">
                                                <b>{{ \App\Models\Article::getMarque($item->id_article) }}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Categorie</div>
                                            <div class="col-lg-6">
                                                <b>{{ \App\Models\Article::getCategorie($item->id_article) }}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Fournisseur</div>
                                            <div class="col-md-6">
                                                <b>{{ \App\Models\Article::getFournisseur($item->id_article) }}</b>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <hr/>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">Couleur</div>
                                            <div class="col-md-6">
                                                <b>{{ \App\Models\Article::getCouleur($item->id_article) }}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Sexe</div>
                                            <div class="col-md-6">
                                                <b>{{ \App\Models\Article::getSexe($item->id_article) }}</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Prix de gros</div>
                                            <div class="col-md-2">HT</div>
                                            <div class="col-md-2">
                                                <b>{{ \App\Models\Article::getPrixGrosHT($item->id_article) }}</b>
                                            </div>
                                            <div class="col-md-2">TTC</div>
                                            <div class="col-md-2">
                                                <b>{{ \App\Models\Article::getPrixGrosTTC($item->id_article) }}</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">Prix</div>
                                            <div class="col-md-2">HT</div>
                                            <div class="col-md-2">
                                                <b>{{ \App\Models\Article::getPrixHT($item->id_article) }}</b>
                                            </div>
                                            <div class="col-md-2">TTC</div>
                                            <div class="col-md-2">
                                                <b>{{ \App\Models\Article::getPrixTTC($item->id_article) }}</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <hr/>
                                        </div>
                                        @if(\App\Models\Stock_taille::hasTailles($item->id_stock))
                                            <div class="row">
                                                <div class="col-md-2">Tailles:</div>
                                            </div>
                                            @foreach(\App\Models\Stock_taille::getTailles($item->id_stock) as $taille)
                                                <div class="row">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-2">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</div>
                                                    <div class="col-md-2"><b>{{ $taille->quantite }}</b></div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-md-4">a</div>
                                                <div class="col-md-4">b</div>
                                                <div class="col-md-4">c</div>
                                            </div>

                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin Modal (pour afficher les details de chaque article) --}}
                    @endforeach

                    </tbody>
                </table>
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
                        $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix d'achat" || title == "Prix de vente") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                var table = $('#myTable').DataTable({
                    "lengthMenu": [[5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
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

                        {"width": "03%", "targets": 6, "type": "string", "visible": true},      //HT
                        {"width": "03%", "targets": 7, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "03%", "targets": 8, "type": "string", "visible": true},      //HT
                        {"width": "03%", "targets": 9, "type": "num-fmt", "visible": true},     //TTC

                        {"width": "08%", "targets": 10, "type": "num-fmt", "visible": true},     //etat

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

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

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

