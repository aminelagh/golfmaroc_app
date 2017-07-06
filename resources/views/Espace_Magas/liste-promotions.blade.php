@extends('layouts.main_master')

@section('title') Promotions @endsection

@section('main_content')

    <h3 class="page-header">Liste des Promotions</h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Promotions</li>
        <li class="breadcrumb-item active"><a href="{{ route('magas.promotions') }}">Liste des Promotions</a></li>
    </ol>

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-10">
            Afficher/Masquer:
            <a class="toggle-vis" data-column="1"
               title="cliquez pour afficher/masquer la colonne categorie">Categorie</a> -
            <a class="toggle-vis" data-column="2">Fournisseur</a> -
            <a class="toggle-vis" data-column="3">Article</a> -
            <a class="toggle-vis" data-column="4">Magasin</a> -
            <a class="toggle-vis" data-column="5">Taux</a>
        </div>
    </div>
    <hr>

    <!-- row table -->
    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead bgcolor="#DBDAD8">
                    <tr>
                        <th>#</th>
                        <th><i class="fa fa-fw fa-sort"></i> Categorie</th>
                        <th><i class="fa fa-fw fa-sort"></i> Fournisseur</th>
                        <th><i class="fa fa-fw fa-sort"></i> Article</th>
                        <th><i class="fa fa-fw fa-sort"></i> Magasin</th>
                        <th><i class="fa fa-fw fa-sort"></i> Taux</th>
                        <th>Date debut</th>
                        <th>Date fin</th>
                        <th>Autres</th>
                    </tr>
                    </thead>

                    <tfoot bgcolor="#DBDAD8">
                    <tr>
                        <th></th>
                        <th>Categorie</th>
                        <th>Fournisseur</th>
                        <th>Article</th>
                        <th>Magasin</th>
                        <th>Taux</th>
                        <th>Date debut</th>
                        <th>Date fin</th>
                        <th></th>
                    </tr>
                    </tfoot>

                    @if( $data->isEmpty() )
                        <tr>
                            <td colspan="7" align="center">Aucune promotion</td>
                        </tr>
                    @else
                        <tbody>
                        @foreach( $data as $item )
                            <tr class="odd gradeA">
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ getCategorieName($item->id_categorie) }}</td>
                                <td>{{ getFournisseurName($item->id_fournisseur) }}</td>
                                <td>{{ $item->designation_c }}</td>
                                <td>{{ $item->libelle }}</td>
                                <td align="right">{{ $item->taux }} %</td>
                                <td align="center">{{ getSimpleDateHelper($item->date_debut) }}</td>
                                <td align="center">{{ getSimpleDateHelper($item->date_fin) }}</td>
                                <td>
                                    <a href="{{ Route('direct.info',['p_table'=> 'promotions' , 'p_id' => $item->id_promotion  ]) }}"
                                            {!!  setPopOver("","Afficher plus de detail") !!} ><i
                                                class="glyphicon glyphicon-eye-open"></i></a>
                                    <a href="{{ Route('direct.update',['p_table'=> 'promotions' , 'p_id' => $item->id_promotion  ]) }}"
                                            {!!  setPopOver("","Modifier la promotion") !!}><i
                                                class="glyphicon glyphicon-pencil"></i></a>
                                    <a onclick="return confirm('Êtes-vous sure de vouloir effacer la promotion numero {{ $loop->index+1 }}?')"
                                       href="{{ Route('direct.delete',[ 'p_table' => 'magasins' , 'p_id' => $item->id_magasin ]) }}"
                                            {!!  setPopOver("","Supprimer la promotion") !!}><i
                                                class="glyphicon glyphicon-trash"></i></a>

                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#myModal{{ $loop->index+1 }}"
                                            title="cliquez ici pour afficher plus de detail">Detail
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal (pour afficher les details de chaque article) --}}
                            <div class="modal fade" id="myModal{{ $loop->index+1 }}" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                            <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Taux</b> {{ $item->taux }}%</p>

                                            <p><b>Date de
                                                    debut</b> {{ getSimpleDateHelper($item->date_debut) }}
                                            </p>

                                            <p><b>Date de fin</b> {{ getSimpleDateHelper($item->date_fin) }}
                                            </p>
                                            <hr>
                                            <p><b>numero</b> {{ $item->num_article }}</p>

                                            <p><b>code a barres</b> {{ $item->code_barre }}</p>

                                            <p><b>Taille</b> {{ $item->taille }}</p>

                                            <p><b>Couleur</b> {{ $item->couleur or '<i>notSet</i>' }}</p>

                                            <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>

                                            <p><b>Prix d'achat </b></p>

                                            <p> {{  number_format($item->prix_achat, 2) }} Dhs
                                                HT, {{  number_format($item->prix_achat+$item->prix_achat*0.2, 2) }}
                                                Dhs TTC</p>

                                            <p><b>Prix de vente </b></p>

                                            <p> {{  number_format($item->prix_vente, 2) }} Dhs
                                                HT, {{  number_format($item->prix_vente+$item->prix_vente*0.2, 2) }}
                                                Dhs TTC</p>

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

                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>


    <div class="row" align="center">
        <a href="{{ Route('direct.add',[ 'p_table' => 'promotions' ]) }}" type="button"
           class="btn btn-outline btn-default"
                {!!  setPopOver("","creer de nouvelles promotions") !!}><i
                    class="glyphicon glyphicon-plus "></i> Ajouter des promotions </a>
    </div>


@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Taille" || title == "Sexe" || title == "Prix d'achat" || title == "Prix de vente") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Couleur") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
                    {"width": "02%", "targets": 0},//#
                    {"width": "05%", "targets": 1},//categorie
                    {"width": "07%", "targets": 2},//fournisseur
                    {"width": "03%", "targets": 3},//numero
                    {"width": "06%", "targets": 4}//code
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

        //script pour le popover detail
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection