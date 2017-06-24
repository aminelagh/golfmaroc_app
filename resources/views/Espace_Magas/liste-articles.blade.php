@extends('layouts.main_master')

@section('title') Articles @endsection

@section('main_content')

    <h1 class="page-header">Liste des Articles</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item active">Liste des articles</li>
    </ol>



    <!-- Table -->
    <div class="table-responsive">
        <div class="col-lg-12">
            @if( !$data->isEmpty() )
                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="1">Reference</a> -
                    <a class="toggle-vis" data-column="2">Code</a> -
                    <a class="toggle-vis" data-column="3">Categorie</a> -
                    <a class="toggle-vis" data-column="4">Fournisseur</a> -
                    <a class="toggle-vis" data-column="5">Marque</a> -
                    <a class="toggle-vis" data-column="6">Designation</a> -
                    <a class="toggle-vis" data-column="7">Couleur</a> -
                    <a class="toggle-vis" data-column="8">Sexe</a> -
                    <a class="toggle-vis" data-column="9">Prix d'achat</a> -
                    <a class="toggle-vis" data-column="10">Prix de vente</a>
                </div>
            @endif

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
                    <th> Prix d'achat (HT)</th>
                    <th> Prix de vente (TTC)</th>
                    <th>Actions</th>
                </tr>
                </thead>
                @if( !$data->isEmpty() )
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
                        <th title="prix HT">Prix d'achat</th>
                        <th>Prix de vente</th>
                        <th></th>
                    </tr>
                    </tfoot>
                @endif
                <tbody>
                @if( $data->isEmpty() )
                    <tr>
                        <td align="center" colspan="12">Aucun Article</td>
                    </tr>
                @else
                    @foreach( $data as $item )
                        @if($item->valide == true)
                            <tr calss="success"
                                ondblclick="window.open('{{ Route('magas.article',['p_id'=>$item->id_article]) }}');">
                        @else
                            <tr class="warning"
                                ondblclick="window.open('{{ Route('magas.article',['p_id'=>$item->id_article]) }}');" {!! setPopOver("","Article non validé par l'administrateur") !!}>
                                @endif

                                <td>{{ $loop->index+1 }}</td>
                                <td align="right">{{ $item->ref }} - {{ $item->alias }}</td>
                                <td align="right">{{ $item->code }}</td>
                                <td>{{ \App\Models\Categorie::getLibelle($item->id_categorie) }}</td>
                                <td>{{ \App\Models\Fournisseur::getLibelle($item->id_fournisseur) }}</td>
                                <td>{{ \App\Models\Marque::getLibelle($item->id_marque) }}</td>
                                <td>@if( $item->image != null) <img src="{{ $item->image }}"
                                                                    width="50px">@endif {{ $item->designation }}
                                </td>
                                <td>{{ $item->couleur }}</td>
                                <td>{{ $item->sexe }}</td>
                                <td align="right">{{ $item->prix_a }} DH</td>
                                <td align="right">{!! \App\Models\Article::getPrix_TTC($item->prix_v) !!} DH
                                </td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <button type="button"
                                                class="btn green btn-sm btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <span {!! setPopOver("","Clisuez ici pour afficher les actions") !!}>Actions</span>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" role="menu">
                                            <li>
                                                <a href="{{ Route('magas.article',['p_id'=> $item->id_article ]) }}"
                                                        {!! setPopOver("","Afficher plus de detail") !!}><i
                                                            class="glyphicon glyphicon-eye-open"></i> Plus de
                                                    detail</a>
                                            </li>
                                            <li>
                                                <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation }} ?')"
                                                   href="#"
                                                        {!! setPopOver("","Effacer l'article") !!}><i
                                                            class="glyphicon glyphicon-trash"></i> Effacer</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a data-toggle="modal" data-target="#modal{{ $loop->index+1 }}"><i
                                                            class="glyphicon glyphicon-info-sign"
                                                            aria-hidden="false"></i> Info-Bull</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                                {{-- Modal (pour afficher les details de chaque article) --}}
                                <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    &times;
                                                </button>
                                                <h4 class="modal-title">{{ $item->designation }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><b>reference</b> {{ $item->ref }} - {{ $item->alias }}</p>
                                                <p><b>code</b> {{ $item->code }}</p>
                                                <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                <p><b>sexe</b> {{ $item->sexe }}</p>
                                                <p><b>Prix d'achat</b></p>
                                                <p>{{ number_format($item->prix_a, 2) }} DH
                                                    HT, {{ number_format($item->prix_a*1.2, 2) }}
                                                    Dhs TTC </p>
                                                <p><b>Prix de vente</b></p>
                                                <p>{{ number_format($item->prix_vente, 2) }} DH
                                                    HT, {{ number_format($item->prix_vente+$item->prix_vente*0.2, 2) }}
                                                    DH TTC </p>
                                                @if( $item->image != null) <img
                                                        src="{{ asset($item->image) }}"
                                                        width="150px">@endif
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
        </div>
    </div>

    <!-- row -->
    <div class="row" align="center">
        <a href="{{ Route('magas.addArticle') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouvel article") !!}> <i
                    class="glyphicon glyphicon-plus "></i> Ajouter un Article</a>

    </div>
    <hr/>

@endsection

@section('scripts')
    @if(!$data->isEmpty())
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
                    else if (title == "Prix d'achat" || title == "Prix de vente") {
                        $(this).html('<input type="text" size="4" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                var table = $('#example').DataTable({
                    "lengthMenu": [[5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        {"width": "08%", "targets": 3, "type": "string", "visible": false},
                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},

                        {"width": "02%", "targets": 7, "type": "string", "visible": false},
                        {"width": "06%", "targets": 8, "type": "num-fmt", "visible": false},
                        {"width": "06%", "targets": 9, "type": "string", "visible": true},
                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true},
                        {"width": "04%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false},
                    ]
                    ,
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

@section('styles')
    <style>
        #examplea {
            width: 100%;
            border: 1px solid #D9D5BE;
            border-collapse: collapse;
            margin: 0px;
            background: white;
            font-size: 1em;
        }

        #examplea td {
            padding: 0.1px;
        }
    </style>
@endsection


@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection