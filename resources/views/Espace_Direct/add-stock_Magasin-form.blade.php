@extends('layouts.main_master')

@section('title') Ajouter le  Stock du magasin {{ $magasin->libelle }} @endsection

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
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '"  onfocus="this.placeholder= \'\';" onblur="this.placeholder="' + title + '"" />');
                }
                if (title == "numero" || title == "code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Designation") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Taille") {
                    $(this).html('<input type="text" size="3" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                if (title == "Couleur") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
            });

            var table = $('#example').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: true,
                "columnDefs": [
                    {"width": "2%", "targets": 0},//#
                    {"width": "5%", "targets": 1},//numero
                    {"width": "7%", "targets": 2},//code
                    {"width": "3%", "targets": 4},//taille
                    {"width": "6%", "targets": 5},//couleur
                    {"width": "6%", "targets": 6},//sexe
                    {"width": "5%", "targets": 7},//pr
                    {"width": "5%", "targets": 8},//pr
                    {"width": "10%", "targets": 9}//autre
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

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Ajouter au Stock du magasin {{ $magasin->libelle }}</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des magasins</li>
                    <li class="breadcrumb-item"><a href="{{ Route('direct.lister',['p_table' => 'magasins' ]) }}">Liste
                            des magasins</a></li>
                    <li class="breadcrumb-item">{{ $magasin->libelle }}</li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('direct.stocks', [ 'p_id_magasin' => $magasin->id_magasin ] ) }}">Stock
                            du magasin</a></li>
                    <li class="breadcrumb-item active">Ajout des Articles au stock</li>
                </ol>

                @include('layouts.alerts')

                <div class="row">

                    <div class="col-lg-12">
                        Afficher/Masquer:
                        <a class="toggle-vis" data-column="1">Categorie</a> -
                        <a class="toggle-vis" data-column="2">Fournisseur</a> -
                        <a class="toggle-vis" data-column="3">Designation</a> -
                        <a class="toggle-vis" data-column="4">Numero</a> -
                        <a class="toggle-vis" data-column="5">Code</a> -
                        <a class="toggle-vis" data-column="6">Taille</a> -
                        <a class="toggle-vis" data-column="7">Couleur</a> -
                        <a class="toggle-vis" data-column="8">Sexe</a> -
                        <a class="toggle-vis" data-column="9">Prix d'achat</a> -
                        <a class="toggle-vis" data-column="10">Prix de vente</a>
                    </div>
                </div>
                <hr>

                <!-- Row 1 -->
                <div class="row">

                    <div class="table-responsive">
                        <div class="col-lg-12">
                            {{-- *************** form ***************** --}}
                            <form role="form" method="post" action="{{ Route('direct.submitAddStock') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>
                                <table id="example" class="table table-striped table-bordered table-hover">
                                    <thead bgcolor="#DBDAD8">
                                    <tr>
                                        <th>#</th>
                                        <th>Categorie</th>
                                        <th>Fournisseur</th>
                                        <th>Designation</th>
                                        <th>numero</th>
                                        <th>Code</th>
                                        <th>Taille</th>
                                        <th>Couleur</th>
                                        <th>Sexe</th>
                                        <th title="prix HT">Prix d'achat</th>
                                        <th>Prix de vente</th>
                                        <th>Quantite min</th>
                                        <th>Quantite max</th>
                                        <th>Autres</th>
                                    </tr>
                                    </thead>
                                    <tfoot bgcolor="#DBDAD8">
                                    <tr>
                                        <th></th>
                                        <th>Categorie</th>
                                        <th>Fournisseur</th>
                                        <th>Designation</th>
                                        <th>numero</th>
                                        <th>Code</th>
                                        <th>Taille</th>
                                        <th>Couleur</th>
                                        <th>Sexe</th>
                                        <th title="prix HT">Prix d'achat</th>
                                        <th>Prix de vente</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if ( isset( $articles ) )
                                        @foreach( $articles as $item )
                                            <tr>
                                                <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                                       value="{{ $item->id_article }}">
                                                <input type="hidden" name="designation_c[{{ $loop->index+1 }}]"
                                                       value="{{ $item->designation_c }}">
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ getChamp('categories', 'id_categorie', $item->id_categorie, 'libelle') }}</td>
                                                <td>{{ getChamp('fournisseurs', 'id_fournisseur', $item->id_fournisseur, 'libelle') }}</td>
                                                <td>{{ $item->designation_c }}</td>
                                                <td>{{ $item->num_article }}</td>
                                                <td>{{ $item->code_barre }}</td>
                                                <td>{{ $item->taille }}</td>
                                                <td>{{ $item->couleur }}</td>
                                                <td>{{ getSexeName($item->couleur) }}</td>
                                                <td align="right">{{ $item->prix_achat }} DH</td>
                                                <td align="right">{{ $item->prix_vente }} DH</td>
                                                <td><input type="number" min="0" placeholder="Quantite Min"
                                                           name="quantite_min[{{ $loop->index+1 }}]"
                                                           value="{{ old('quantite_min[$loop->index+1]') }}"></td>
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
                                                                <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><b>numero</b> {{ $item->num_article }}</p>
                                                                <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                                                <p><b>Taille</b> {{ $item->taille }}</p>
                                                                <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                                <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                                <p><b>Prix d'achat</b> {{ $item->prix_achat }}</p>
                                                                <p><b>Prix de vente</b> {{ $item->prix_vente }}</p>
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
                <!-- end row 1 -->

            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
@section('menu_1')
    @include('Espace_Direct._nav_menu_1')
@endsection
@section('menu_2')
    @include('Espace_Direct._nav_menu_2')
@endsection
