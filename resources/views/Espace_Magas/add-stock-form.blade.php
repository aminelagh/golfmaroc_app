@extends('layouts.main_master')

@section('title') Ajouter le  Stock du magasin {{ $magasin->libelle }} @endsection

@section('main_content')
    <h1 class="page-header">creation du stock du magasin: <strong>{{ $magasin->libelle }}</strong></h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item"><a href="{{ Route('magas.magasins') }}">Liste
                des magasins</a></li>
        <li class="breadcrumb-item">{{ $magasin->libelle }}</li>
        <li class="breadcrumb-item active">Creation du stock</li>
    </ol>


    <div class="row">
        @if( !$articles->isEmpty() )
            <div class="breadcrumb">
                Afficher/Masquer: <a class="toggle-vis" data-column="1">Reference</a> -
                <a class="toggle-vis" data-column="2">Code</a> -
                <a class="toggle-vis" data-column="3">Categorie</a> -
                <a class="toggle-vis" data-column="4">Fournisseur</a> -
                <a class="toggle-vis" data-column="5">Marque</a> -
                <a class="toggle-vis" data-column="6">Designation</a> -
                <a class="toggle-vis" data-column="7">Couleur</a> -
                <a class="toggle-vis" data-column="8">Sexe</a> -
                <a class="toggle-vis" data-column="9">Prix</a>
            </div>
        @endif
    </div>
    <hr>

    <!-- Row 1 -->
    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                {{-- *************** form ***************** --}}
                <form role="form" method="post" action="{{ Route('magas.submitAddStock') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>

                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead bgcolor="#DBDAD8">
                        <tr>
                            <th> #</th>
                            <th> Reference</th>
                            <th> Code</th>
                            <th> Categorie</th>
                            <th> Fournisseur</th>
                            <th> Marque</th>

                            <th> Designation</th>

                            <th> Couleur</th>
                            <th> Sexe</th>

                            <th> Prix</th>
                            <th></th>
                            <th></th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        @if( !$articles->isEmpty() )
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Reference</th>
                                <th>Code</th>
                                <th>Categorie</th>
                                <th>Fournisseur</th>
                                <th>Marque</th>
                                <th>Designation</th>
                                <th>Couleur</th>
                                <th>Sexe</th>
                                <th>Prix</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        @endif
                        <tbody>
                        @if( !$articles->isEmpty() )
                            @foreach( $articles as $item )
                                <tr>
                                    <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                           value='{{ $item->id_article }}'>

                                    <input type="hidden" name="designation[{{ $loop->index+1 }}]"
                                           value="{{ $item->designation }}">

                                    <td>{{ $loop->index+1 }}</td>
                                    <td align="right">{{ $item->ref }} {{ $item->alias!=null? ' - '.$item->alias : '' }}</td>
                                    <td align="right">{{ $item->code }}</td>

                                    <td>{{ \App\Models\Categorie::getLibelle($item->id_categorie) }}</td>
                                    <td>{{ \App\Models\Fournisseur::getLibelle($item->id_fournisseur) }}</td>
                                    <td>{!! \App\Models\Marque::getLibelle($item->id_marque) !!}</td>

                                    <td>{{ $item->designation }}</td>

                                    <td>{{ $item->couleur }}</td>
                                    <td>{{ $item->sexe }}</td>

                                    <td align="right">{{ $item->prix_v }} DH</td>
                                    <td><input type="number" min="0" placeholder="Quantite Min"
                                               name="quantite_min[{{ $loop->index+1 }}]"
                                               value="{{ old('quantite_min.'.($loop->index+1) ) }}"></td>
                                    <td><input type="number" min="0" placeholder="Quantite Max"
                                               name="quantite_max[{{ $loop->index+1 }}]"
                                               value="{{ old('quantite_max[$loop->index+1]') }}"></td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#myModal{{ $loop->index+1 }}">Detail Article au
                                            stock
                                        </button>
                                    </td>

                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                    <div class="modal fade" id="myModal{{ $loop->index+1 }}" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                            data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">{{ $item->designation }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>Reference</b> {{ $item->ref }} {{ $item->alias!=null? ' - '.$item->alias : '' }}</p>
                                                    <p><b>code</b> {{ $item->code }}</p>
                                                    <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                    <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                    <p><b>Prix de vente</b> {{ \App\Models\Article::getPrix_TTC($item->prix_v) }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Fermer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- fin Modal (pour afficher les details de chaque article) --}}

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <div class="row" align="center">
                        <button data-toggle="popover" data-placement="top" data-trigger="hover"
                                title="Valider l'ajout"
                                data-content="Cliquez ici pour valider la création du stock avec l'ensemble des articles choisi"
                                type="submit" name="submit" value="valider" class="btn btn-default">Valider
                        </button>
                    </div>

                </form>
                {{-- *************** end form ***************** --}}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @if(!$articles->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Reference" || title == "Code") {
                        $(this).html('<input type="text" size="6" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Categorie" || title == "Fournisseur" || title == "Marque") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Couleur" || title == "Sexe") {
                        $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Prix") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                var table = $('#example').DataTable({
                    "searching": true,
                    "paging": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        {"width": "08%", "targets": 3, "type": "string", "visible": false},
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},

                        {"width": "02%", "targets": 7, "type": "string", "visible": true},

                        {"width": "06%", "targets": 8, "type": "num-fmt", "visible": false},
                        {"width": "06%", "targets": 9, "type": "string", "visible": false},

                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true, "searchable": false},
                        {"width": "04%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false},
                        {"width": "04%", "targets": 12, "type": "num-fmt", "visible": true, "searchable": false},
                    ]
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