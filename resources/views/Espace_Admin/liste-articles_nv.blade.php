@extends('layouts.main_master')

@section('title') Nouveaux articles @endsection

@section('main_content')

    <h1 class="page-header">Nouveaux articles</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Nouveaux articles</li>
    </ol>

    @include('layouts.alerts')


    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                <div class="breadcrumb">
                    Afficher/Masquer:
                    <a class="toggle-vis" data-column="1">reference</a> -
                    <a class="toggle-vis" data-column="2">Code</a> -
                    <a class="toggle-vis" data-column="3">Article</a> -
                    <a class="toggle-vis" data-column="4">Categorie</a> -
                    <a class="toggle-vis" data-column="5">Fournisseur</a> -
                    <a class="toggle-vis" data-column="6">Marque</a> -
                    <a class="toggle-vis" data-column="7">Couleur</a> -
                    <a class="toggle-vis" data-column="8">Sexe</a> -
                    <a class="toggle-vis" data-column="9">Prix de vente</a>
                </div>

                {{-- *************** formulaire ***************** --}}
                <form role="form" method="post" action="{{ Route('admin.submitArticlesValide') }}">
                    {{ csrf_field() }}

                    <table class="table table-striped table-bordered table-hover" id="example">
                        <thead bgcolor="#DBDAD8">
                        <tr>
                            <th> #</th>
                            <th> Reference</th>
                            <th> Code</th>

                            <th> Designation</th>

                            <th> Categorie</th>
                            <th> Fournisseur</th>
                            <th> Marque</th>

                            <th> Couleur</th>
                            <th> Sexe</th>

                            <th> Prix d'achat (HT)</th>
                            <th> Prix de vente (TTC)</th>

                            <th> Valide</th>
                            <th> Autres</th>
                        </tr>
                        </thead>
                        <tfoot bgcolor="#DBDAD8">
                        <tr>
                            <th></th>
                            <th> Reference</th>
                            <th> Code</th>
                            <th> Designation</th>
                            <th> Categorie</th>
                            <th> Fournisseur</th>
                            <th> Marque</th>
                            <th> Couleur</th>
                            <th> Sexe</th>
                            <th> Prix d'achat</th>
                            <th> Prix de vente</th>
                            <th></th>
                            <th></th>
                        </tfoot>

                        <tbody>
                        @foreach( $data as $item )
                            <tr>
                                <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                       value="{{ $item->id_article }}">

                                <td align="right">{{ $loop->index+1 }}</td>
                                <td>{{ $item->ref }} {{ $item->alias!=null ? ' - '.$item->alias : '' }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>{{ $item->id_categorie  }}</td>
                                <td>{{ $item->id_fournisseur }}</td>
                                <td>{{ $item->id_marque }}</td>
                                <td>{{ $item->couleur }}</td>
                                <td>{{ $item->sexe }}</td>
                                <td align="right">{{ $item->prix_a }}</td>
                                <td align="right">{{ \App\Models\Article::getPrix_TTC($item->prix_v) }}</td>
                                <td align="right"><input type="checkbox" id="valide[{{ $loop->index+1 }}]"
                                                         name="valide[{{ $loop->index+1 }}]"
                                                         value="{{ $loop->index+1 }}"/></td>
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
                                                <a href="{{ Route('admin.article',['p_id'=> $item->id_article ]) }}"
                                                        {!! setPopOver("","Afficher plus de detail") !!}><i
                                                            class="glyphicon glyphicon-eye-open"></i> Plus de
                                                    detail</a>
                                            </li>
                                            <li>
                                                <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation }} ?')"
                                                   href="{{ Route('magas.delete',['p_table' => 'articles' , 'p_id' => $item->id_article ]) }}"
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
                            </tr>
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
                                            <p><b>{{ $item->prix_a }} DH
                                                    HT</b>, {{ \App\Models\Article::getPrix_TTC($item->prix_a) }}
                                                Dhs TTC </p>
                                            <p><b>Prix de vente</b></p>
                                            <p>{{ $item->prix_v }} DH
                                                HT, <b>{{ \App\Models\Article::getPrix_TTC($item->prix_v) }}
                                                    Dhs TTC </b></p>
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
                        @endforeach

                        </tbody>


                    </table>

                    <div class="row" align="center">

                        <input type="submit" formtarget="_blanc" name="submit" value="valider"
                               class="btn btn-primary" {!! setPopOver("","Cliquez ici pour marquer les articles cochés comme étant valide") !!}>

                    </div>

                </form>

            </div>
        </div>
    </div>


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
                    //"scrollY": "50px",
                    //"scrollX": true,
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "04%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                        {"width": "05%", "targets": 1, "type": "string", "visible": true},
                        {"width": "05%", "targets": 2, "type": "string", "visible": true},

                        //{"width": "08%", "targets": 3, "type": "string", "visible": false},

                        {"width": "08%", "targets": 4, "type": "string", "visible": false},
                        {"width": "08%", "targets": 5, "type": "string", "visible": false},
                        {"width": "08%", "targets": 6, "type": "string", "visible": false},

                        {"width": "02%", "targets": 7, "type": "string", "visible": false},
                        {"width": "06%", "targets": 8, "type": "num-fmt", "visible": false},

                        {"width": "06%", "targets": 9, "type": "string", "visible": true},
                        {"width": "04%", "targets": 10, "type": "num-fmt", "visible": true},

                        {"width": "07%", "targets": 11, "type": "num-fmt", "visible": true, "searchable": false},
                        {"width": "05%", "targets": 12, "type": "num-fmt", "visible": true, "searchable": false},
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