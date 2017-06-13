@extends('layouts.main_master')

@section('title') StockIN {{ $magasin->libelle }} @endsection

@section('main_content')
    <h3 class="page-header">creation du stock du magasin: <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Gestion des magasins</li>
        <li class="breadcrumb-item">{{ $magasin->libelle  }}</li>
        <li class="breadcrumb-item">Stock du magasin: {{ $magasin->libelle  }}</li>
        <li class="breadcrumb-item active">ajout de l'article: {{ $article->designation  }}</li>
    </ol>

    <div class="row" align="center">
        <button class="btn btn-outline btn-success"
                id="addRow" {!! setPopOver("","Cliquez ici pour ajouter une autre taille pour cet article") !!}>Ajouter
            nouvelle taille
        </button>
    </div>
    <div class="row" align="">

        <table id="example" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Taille</th>
                <th>Quantite</th>
                <th {!! setPopOver("","Quantite a ajouter au stock initial") !!}>Quantite a stocker</th>
            </tr>
            </thead>

            <tr>
                <td>taille S</td>
                <td align="right">10</td>
                <td><input type="number" value="" name="quantite"></td>
            </tr>

            @if(isset($article_tailles))
                @foreach($article_tailles as $item)
                    <tr>
                        <td>{{ $item->id_taille_article }}</td>
                        <td>{{ $item->quantite }}</td>
                        <td><input type="number" value="" name="quantite"></td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

    <!-- Row 1 -->
    @if(isset($aaa))
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">

                    {{-- *************** form ***************** --}}
                    <form role="form" name="myForm" id="myForm" method="post"
                          action="{{ Route('magas.submitAddStock') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id_stock" value="{{ $data->id_stock }}"/>
                        <input type="hidden" name="id_article" value="{{ $article->id_article }}"/>
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

                            <tbody>
                            <tr>

                                <input type="hidden" name="designation[{{  1 }}]"
                                       value="{{ $article->designation }}">

                                <td>{{ 1 }}</td>
                                <td align="right">{{ $article->ref }} {{ $article->alias!=null? ' - '.$article->alias : '' }}</td>
                                <td align="right">{{ $article->code }}</td>

                                <td>{{ \App\Models\Categorie::getLibelle($article->id_categorie) }}</td>
                                <td>{{ \App\Models\Fournisseur::getLibelle($article->id_fournisseur) }}</td>
                                <td>{!! \App\Models\Marque::getLibelle($article->id_marque) !!}</td>

                                <td>{{ $article->designation }}</td>

                                <td>{{ $article->couleur }}</td>
                                <td>{{ $article->sexe }}</td>

                                <td align="right">{{ $article->prix_v }} DH</td>
                                <td><input type="number" min="0" placeholder="Quantite Min" width="5"
                                           name="quantite_min[{{ 1 }}]"
                                           value="{{ old('quantite_min.'.(1) ) }}"></td>
                                <td><input type="number" min="0" placeholder="Quantite Max"
                                           name="quantite_max[{{ 1 }}]"
                                           value="{{ old('quantite_max.'.(1)) }}"></td>
                                <td>

                                </td>


                            </tr>
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
    @endif
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#article" data-toggle="tab">Article</a>
                        </li>
                        <li><a href="#profile" data-toggle="tab">Magasin</a>
                        </li>
                        <li><a href="#messages" data-toggle="tab">Messages</a>
                        </li>
                        <li><a href="#settings" data-toggle="tab">Settings</a>
                        </li>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="article">
                            <h4>{{ $article->designation }}</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <h4>Profile Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            <h4>Messages Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                        <div class="tab-pane fade" id="settings">
                            <h4>Settings Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var t = $('#example').DataTable();
            var counter = 1;

            $('#addRow').on('click', function () {
                t.row.add([
                    counter + " <select class='form-control'><option>s</option><option>M</option></select>",
                    counter + '.2',
                    counter + '.3',
                    counter + '.4',
                    counter + '.5'
                ]).draw(false);

                counter++;
            });

            // Automatically add a first row of data
            //$('#addRow').click();
        });
    </script>
    @if(isset($aaa))
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
                    //"pageLength": 25,
                    "searching": true,
                    "paging": true,
                    //"info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": true},//#
                        {"width": "05%", "targets": 1, "type": "string", "visible": false},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        {"width": "08%", "targets": 3, "type": "string", "visible": false},
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},

                        //{"width": "02%", "targets": 6, "type": "string", "visible": true},

                        {"width": "02%", "targets": 7, "type": "string", "visible": false},
                        {"width": "06%", "targets": 8, "type": "string", "visible": false},
                        {"width": "06%", "targets": 9, "type": "num-fmt", "visible": true},

                        {"width": "04%", "targets": 10, "visible": true, "searchable": false},
                        {"width": "04%", "targets": 11, "visible": true, "searchable": false},
                        {"width": "04%", "targets": 12, "visible": true, "searchable": false},
                    ],
                });

                var counter = 1;

                $('#addRow').on('click', function () {
                    t.row.add([
                        counter + '.1',
                        counter + '.2',
                        counter + '.3',
                        counter + '.4',
                        counter + '.5'
                    ]).draw(false);

                    counter++;
                });

                // Automatically add a first row of data
                $('#addRow').click();


                $('#myForm').on('submit', function (e) {
                    var form = this;

                    // Encode a set of form elements from all pages as an array of names and values
                    var params = table.$('input,select,textarea').serializeArray();

                    // Iterate over all form elements
                    $.each(params, function () {
                        // If element doesn't exist in DOM
                        if (!$.contains(document, form[this.name])) {
                            // Create a hidden element
                            $(form).append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );
                        }
                    });
                });


                //-------------------------------------------------
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