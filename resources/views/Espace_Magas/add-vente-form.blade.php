@extends('layouts.main_master')

@section('title') vente @endsection

@section('main_content')

    <h3 class="page-header">Nouvelle vente</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des ventes</li>
        <li class="breadcrumb-item "><a href="{{ route('magas.ventes') }}">Liste des ventes</a></li>
        <li class="breadcrumb-item active">Nouvelle vente</li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div align="center">


                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddVentePhase1') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>


                    @foreach( $data as $item )

                        <script>
                            function callQ_{{ $loop->iteration }}(cpt) {
                                var total = 0;
                                var prix = document.getElementById("prix_"+{{ $loop->iteration }}).value;
                                for (i = 1; i <= cpt; i++) {
                                    var qi = document.getElementById("quantite_{{ $loop->iteration }}_" + i).value;
                                    //alert("QI = "+qi);
                                    if(qi == "")
                                    {
                                        qi = 0;
                                    }else if(qi<0)
                                    {
                                        alert("Erreur, q<0");
                                        break;
                                    }
                                    total += parseInt(qi);
                                }
                                document.getElementById("sommeQ_"+{{ $loop->iteration }}).value = total;
                                document.getElementById("total_"+{{ $loop->iteration }}).value = total*parseFloat(prix);
                            }
                        </script>

                        <input type="hidden" id="prix_{{ $loop->iteration }}"
                               value="{{ \App\Models\Article::getPrixTTC($item->id_article) }}">

                        <h3 onclick="calcQ({{ $loop->iteration }});">{{ \App\Models\Article::getDesignation($item->id_article) }}
                            : {{ \App\Models\Article::getPrixTTC($item->id_article) }}</h3>

                        @if(\App\Models\Stock_taille::hasTailles($item->id_stock))
                            <table border="1">
                                @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )
                                    <tr>


                                        <input type="hidden"
                                               name="quantite[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                               value="{{ $taille->quantite }}"/>

                                        <td align="center">{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                        <td align="center">{{ $taille->quantite }}</td>
                                        <td>
                                            <input type="number" min="0" class="form-control"
                                                   max="{{ $taille->quantite }}"
                                                   placeholder="Quantite"
                                                   name="quantiteOUT[{{ $item->id_stock }}][{{ $loop->iteration }}]"
                                                   value="{{ old('quantiteOUT.'.($item->id_stock).'.'.($loop->iteration).'') }}"
                                                   id="quantite_{{ $loop->parent->iteration }}_{{ $loop->iteration }}"
                                                   onkeyup="callQ_{{ $loop->parent->iteration }}({{ \App\Models\Stock_taille::getTailles($item->id_stock)->count() }});"
                                                   >

                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2">Qts</th>
                                    <td><input type="number" disabled class="form-control"
                                               id="sommeQ_{{ $loop->iteration }}"
                                               value="0"></td>
                                </tr>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <td><input type="number" name="result" pattern=".##"
                                               disabled onchange="doResult()"
                                               id="total_{{ $loop->iteration }}"
                                               class="form-control"/></td>
                                </tr>

                            </table>
                        @else
                            <div class="row">
                                <b><i>Aucun article disponible</i></b>
                            </div>
                        @endif

                    @endforeach


                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-2">
                                    <input data-toggle="toggle" data-on="Vente de gros" data-onstyle="warning"
                                           data-off="Vente simple" data-offstyle="info" type="checkbox"
                                           name="type_prix">
                                </div>
                                <div class="col-lg-2">
                                    <div data-toggle="modal" data-target="#squarespaceModal"
                                         class="btn btn-primary center-block">Payement
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <input type="submit" value="Valider la sortie de stock" formtarget="_blank"
                                           class="btn btn-outline btn-success">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog"
                         aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">My Modal</h3>
                                </div>
                                <div class="modal-body">

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label {!! setPopOver("Obligatoire","Sélectionnez le mode de paiement") !!}>Mode
                                                de Paiement *</label>
                                            <select class="form-control" name="id_mode_paiement">
                                                @foreach( $modes_paiement as $mode )
                                                    <option value="{{$mode->id_mode_paiement }}" {{$mode->id_mode=="2" ? 'selected' : '' }}>{{$mode->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Reference chequier</label>
                                        <input class="form-control" type="text" placeholder="ref" name="ref"
                                               value="{{ old('ref') }}">
                                    </div>

                                    <div class="col-lg-2"></div>

                                    <div class="col-lg-2">
                                        <label>Taux de Remise</label>
                                        <input class="form-control" type="number" min="0"
                                               placeholder="Taux" value="{{ old('taux_remise') }}"
                                               name="taux_remise" {!! setPopOver("","Taux de la remise, si vous voullez (exemple: 15%)") !!}>
                                    </div>


                                    <div class="col-lg-3">
                                        <label>Raison de la remise</label>
                                        <input class="form-control" type="text"
                                               placeholder="Raison" name="raison" value="{{ old('raison') }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                               placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                               placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <input type="file" id="exampleInputFile">

                                        <p class="help-block">Example block-level help text here.</p>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Check me out
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                    <

                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                                    role="button">Close
                                            </button>
                                        </div>
                                        <div class="btn-group btn-delete hidden" role="group">
                                            <button type="button" id="delImage" class="btn btn-default btn-hover-red"
                                                    data-dismiss="modal" role="button">Delete
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" id="saveImage" class="btn btn-default btn-hover-green"
                                                    data-action="save" role="button">Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
                var table = $('#myTable').DataTable({
                    "lengthMenu": [[50, 20, 30, 50, -1], [50, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        //{"visible": true, "targets": -1},

                        //{"searchable": false, "orderable": false, "targets": 0},
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},  //ref
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},  //code

                        //{"width": "08%", "targets": 3, "type": "string", "visible": true},    //desi
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},     //Marque
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},     //caegorie

                        {"width": "02%", "targets": 6, "type": "num-fmt", "visible": true},      //HT
                        {"width": "02%", "targets": 7, "type": "num-fmt", "visible": true},     //TTC
                        {"width": "02%", "targets": 8, "type": "num-fmt", "visible": true},      //HT
                        {"width": "02%", "targets": 9, "type": "num-fmt", "visible": true},     //TTC

                        {"width": "05%", "targets": 10, "type": "num-fmt", "orderable": false, "visible": true}, //etat

                        {"width": "04%", "targets": 11, "orderable": false, "type": "num-fmt", "searchable": false}
                    ],
                    //"select": {items: 'column'}
                });


                /*table.on('order.dt search.dt', function () {
                 table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                 cell.innerHTML = i + 1;
                 });
                 }).draw();*/


                $('#myTable tbody tr').each(function () {

                });

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
                    else if (title == "Prix de gros" || title == "Prix de vente") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                //footer input: hide text
                $('a.toggle-vis').on('click', function (e) {
                    e.preventDefault();
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                });

                //footer search
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
