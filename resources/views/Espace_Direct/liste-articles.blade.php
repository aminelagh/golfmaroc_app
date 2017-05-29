@extends('layouts.main_master')

@section('title') Articles @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Taille") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Couleur") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                }
                if (title != "") {
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
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                    {"width": "05%", "targets": 1, "type": "string", "visible": false},//numero
                    {"width": "07%", "targets": 2, "type": "string", "visible": true},//code
                    {"width": "03%", "targets": 4, "type": "string", "visible": false},//taille
                    {"width": "06%", "targets": 5, "type": "string", "visible": false},//couleur
                    {"width": "06%", "targets": 6, "type": "string", "visible": true},//sexe
                    {"width": "05%", "targets": 7, "type": "num-fmt", "visible": true},//pr
                    {"width": "05%", "targets": 8, "type": "num-fmt", "visible": true},//pr
                    {"width": "10%", "targets": 9, "type": "string", "visible": true, "searchable": false}//autre
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
@endsection

@section('main_content')
    <div class="container-fluid">
        <!-- main row -->
        <div class="col-lg-12">
            <div class="row">

                <h1 class="page-header">Liste des Articles</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item active">Liste des articles</li>
                </ol>


            @include('layouts.alerts')

            <!-- Table -->
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <div class="breadcrumb">
                            Afficher/Masquer: <a class="toggle-vis" data-column="1">Numero</a> -
                            <a class="toggle-vis" data-column="2">Code</a> -
                            <a class="toggle-vis" data-column="3">Designation</a> -
                            <a class="toggle-vis" data-column="4">Taille</a> -
                            <a class="toggle-vis" data-column="5">Couleur</a> -
                            <a class="toggle-vis" data-column="6">Sexe</a> -
                            <a class="toggle-vis" data-column="7">Prix d'achat</a> -
                            <a class="toggle-vis" data-column="8">Prix de vente</a>
                        </div>

                        <table id="example" class="table table-striped table-bordered table-hover">
                            <thead bgcolor="#DBDAD8">
                            <tr>
                                <th> #</th>
                                <th><i class="fa fa-fw fa-sort"></i> numero</th>
                                <th><i class="fa fa-fw fa-sort"></i> Code</th>
                                <th><i class="fa fa-fw fa-sort"></i> Designation</th>
                                <th><i class="fa fa-fw fa-sort"></i> Taille</th>
                                <th><i class="fa fa-fw fa-sort"></i> Couleur</th>
                                <th><i class="fa fa-fw fa-sort"></i> Sexe</th>
                                <th title="prix HT"><i class="fa fa-fw fa-sort"></i> Prix d'achat</th>
                                <th><i class="fa fa-fw fa-sort"></i> Prix de vente</th>
                                <th>Autres</th>
                            </tr>
                            </thead>
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>numero</th>
                                <th>Code</th>
                                <th>Designation</th>
                                <th>Taille</th>
                                <th>Couleur</th>
                                <th>Sexe</th>
                                <th title="prix HT">Prix d'achat</th>
                                <th>Prix de vente</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if( $data->isEmpty() )
                                <tr>
                                    <td colspan="10" align="center">Aucun Article</td>
                                </tr>
                            @else
                                @foreach( $data as $item )
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->num_article }}</td>
                                        <td>{{ $item->code_barre }}</td>
                                        <td>{{ $item->designation_c }}</td>
                                        <td>{{ $item->taille }}</td>
                                        <td>{{ $item->couleur }}</td>
                                        <td>{{ getSexeName($item->sexe) }}</td>
                                        <td align="right">{{ $item->prix_achat }} DH</td>
                                        <td align="right">{{ $item->prix_vente }} DH</td>
                                        <td align="center">
                                            <a href="{{ Route('direct.info',['p_table' => 'articles', 'p_id'=> $item->id_article ]) }}"
                                                    {!! setPopOver("","Afficher plus de detail") !!}><i
                                                        class="glyphicon glyphicon-eye-open"></i></a>
                                            <a href="{{ Route('direct.update',['p_table' => 'articles', 'p_id' => $item->id_article ]) }}"
                                                    {!! setPopOver("","Modifier") !!}><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
                                            <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation_c }} ?')"
                                               href="{{ Route('direct.delete',['p_table' => 'articles' , 'p_id' => $item->id_article ]) }}"
                                                    {!! setPopOver("","Effacer l'article") !!}><i
                                                        class="glyphicon glyphicon-trash"></i></a>
                                            <a data-toggle="modal" data-target="#modal{{ $loop->index+1 }}"><i
                                                        class="glyphicon glyphicon-info-sign"
                                                        aria-hidden="false"></i></a>
                                        </td>

                                        {{-- Modal (pour afficher les details de chaque article) --}}
                                        <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                        <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><b>numero</b> {{ $item->num_article }}</p>
                                                        <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                                        <p><b>Taille</b> {{ $item->taille }}</p>
                                                        <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                        <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                        <p><b>Prix d'achat</b></p>
                                                        <p>{{ number_format($item->prix_achat, 2) }} DH
                                                            HT, {{ number_format($item->prix_achat+$item->prix_achat*0.2, 2) }}
                                                            Dhs TTC </p>
                                                        <p><b>Prix de vente</b></p>
                                                        <p>{{ number_format($item->prix_vente, 2) }} DH
                                                            HT, {{ number_format($item->prix_vente+$item->prix_vente*0.2, 2) }}
                                                            DH TTC </p>
                                                        <p>{{ $item->designation_l }}</p>
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
                    <a type="button" class="btn btn-outline btn-default" disabled=""><i class="fa fa-file-pdf-o"
                                                                                        aria-hidden="true">Imprimer </i></a>
                    <a href="{{ Route('direct.add',[ 'p_table' => 'articles' ]) }}" type="button"
                       class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouvel article") !!}> <i
                                class="glyphicon glyphicon-plus "></i>Ajouter
                        un Article</a>

                </div>
                <!-- row -->
            </div>

        </div>
        <!-- end main row -->

    </div>
@endsection


@section('menu_1')
    @include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Direct._nav_menu_2')
@endsection
