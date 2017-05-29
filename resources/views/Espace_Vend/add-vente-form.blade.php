@extends('layouts.main_master')

@section('title') Ajouter une vente @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    .tab {
    text-indent: 20px;
    }
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Categorie" || title == "Fournisseur") {
                    $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Numero" || title == "Code") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Article") {
                    $(this).html('<input type="text" size="12" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Couleur" || title == "Taille" || title == "Sexe") {
                    $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                }
                else if (title == "Quantite disponible" || title == "Prix de vente" || title == "Sexe") {
                    $(this).html('<input type="text" size="09" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                }
                else if (title == "") {
                    //$(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
            });

            var table = $('#example').DataTable({
                "searching": true,
                "paging": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},
                    {"width": "05%", "targets": 1, "type": "string", "visible": false},
                    {"width": "07%", "targets": 2, "type": "string", "visible": false},
                    //{"width": "07%", "targets": 3, "type": "string", "visible": true},
                    {"width": "03%", "targets": 4, "type": "string", "visible": false},
                    {"width": "06%", "targets": 5, "type": "string", "visible": false},
                    {"width": "06%", "targets": 6, "type": "string", "visible": false},
                    {"width": "05%", "targets": 7, "type": "num-fmt", "visible": false},
                    {"width": "05%", "targets": 8, "type": "num-fmt", "visible": false},
                    {"width": "10%", "targets": 9, "type": "string", "visible": true, "searchable": false},
                    {"width": "05%", "targets": 10, "type": "string", "visible": true, "searchable": false},
                    {"width": "10%", "targets": 11, "type": "string", "visible": true, "searchable": false},
                    {"width": "03%", "targets": 12, "type": "string", "visible": true, "searchable": false}
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
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Ajouter une vente</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vend.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Vente</li>
                </ol>

                <!-- alerts -->
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        {{-- Debut Alerts --}}
                        @if (session('alert_success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                    &times;
                                </button> {!! session('alert_success') !!}
                            </div>
                        @endif

                        @if (session('alert_info'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                    &times;
                                </button> {!! session('alert_info') !!}
                            </div>
                        @endif
                        @if (session('alert_warning'))
                            <div class="alert alert-warning alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                    &times;
                                </button> {!! session('alert_warning') !!}
                            </div>
                        @endif
                        @if (session('alert_danger'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                    &times;
                                </button> {!! session('alert_danger') !!}
                            </div>
                        @endif
                        {{-- Fin Alerts --}}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <!-- /.alerts -->


                <div class="row">
                    <div class="table-responsive">
                        <div class="col-lg-12">

                            <div class="breadcrumb">
                                Afficher/Masquer:
                                <a class="toggle-vis" data-column="1">Numero</a> -
                                <a class="toggle-vis" data-column="2">Code</a> -
                                <a class="toggle-vis" data-column="3">Article</a> -
                                <a class="toggle-vis" data-column="4">Categorie</a> -
                                <a class="toggle-vis" data-column="5">Fournisseur</a> -
                                <a class="toggle-vis" data-column="6">Taille</a> -
                                <a class="toggle-vis" data-column="7">Couleur</a> -
                                <a class="toggle-vis" data-column="8">Sexe</a> -
                                <a class="toggle-vis" data-column="9">Prix de vente</a>
                            </div>

                            {{-- *************** formulaire ***************** --}}
                            <form role="form" method="post" action="{{ Route('vend.submitAddVente') }}">
                                {{ csrf_field() }}

                                <table class="table table-striped table-bordered table-hover" id="example">
                                    <thead bgcolor="#DBDAD8">
                                    <tr>
                                        <th>#</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Numero</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Code</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Article</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Categorie</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Fournisseur</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Taille</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Couleur</th>
                                        <th><i class="fa fa-fw fa-sort"></i> Sexe</th>
                                        <th>Prix de vente</th>
                                        <th>Quantite disponible</th>
                                        <th>Quantité</th>
                                        <th>Autres</th>
                                    </tr>
                                    </thead>
                                    <tfoot bgcolor="#DBDAD8">
                                    <tr>
                                        <th></th>
                                        <th>Numero</th>
                                        <th>Code</th>
                                        <th>Article</th>
                                        <th>Categorie</th>
                                        <th>Fournisseur</th>
                                        <th>Taille</th>
                                        <th>Couleur</th>
                                        <th>Sexe</th>
                                        <th>Prix de vente</th>
                                        <th>Quantite disponible</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>

                                    <tbody>

                                    @foreach( $data as $item )

                                        @if(hasPromotion($item->id_article))
                                            <tr class="success">
                                        @else
                                            <tr>
                                        @endif

                                            <input type="hidden" name="id_stock[{{ $loop->index+1 }}]"
                                                   value="{{ $item->id_stock }}">
                                            <input type="hidden" name="id_article[{{ $loop->index+1 }}]"
                                                   value="{{ $item->id_article }}">

                                            <td align="right">{{ $loop->index+1 }}</td>
                                            <td>{{ $item->num_article }}</td>
                                            <td>{{ $item->code_barre }}</td>
                                            <td>{{ $item->designation_c }}</td>
                                            <td>{{ getChamp('categories', 'id_categorie', $item->id_categorie , 'libelle') }}</td>
                                            <td>{{ getChamp('fournisseurs', 'id_fournisseur', $item->id_fournisseur , 'libelle') }}</td>
                                            <td>{{ $item->taille }}</td>
                                            <td>{{ $item->couleur }}</td>
                                            <td>{{ $item->sexe }}</td>

                                            @if(hasPromotion($item->id_article))
                                                <td align="right">{{ getPrixTaux($item->prix_vente, getTauxPromo($item->id_article) ) }}
                                                    DH
                                                </td>
                                            @else
                                                <td align="right">{{ getTTC($item->prix_vente) }} DH</td>
                                            @endif

                                            <td align="right">{{ $item->quantite }}</td>
                                            <td align="right">
                                                <input type="number" min="0"
                                                       max="{{ $item->quantite }}"
                                                       placeholder="Qts"
                                                       value="{{ old('quantite.'.($loop->index+1).'') }}"
                                                       name="quantite[{{ $loop->index+1 }}]" {{-- $item->quantite==0 ? "disabled" : '' --}} />
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-info btn-xs"
                                                        data-toggle="modal"
                                                        data-target="#myModal{{ $loop->index+1 }}">
                                                    Detail Article
                                                </button>
                                            </td>

                                            {{-- Modal (pour afficher les details de chaque article) --}}
                                            <div class="modal fade" id="myModal{{ $loop->index+1 }}"
                                                 role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal">&times;
                                                            </button>
                                                            <h4 class="modal-title">{{ $item->designation_c }} @if(hasPromotion($item->id_article))
                                                                    (en promotion) @endif </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><b>numero:</b> {{ $item->num_article }}</p>
                                                            <p><b>code a barres:</b> {{ $item->code_barre }}</p>
                                                            <p><b>Taille:</b> {{ $item->taille }}</p>
                                                            <p><b>Couleur:</b> {{ $item->couleur }}</p>
                                                            <p><b>sexe:</b> {{ $item->sexe }}</p>

                                                            @if(hasPromotion($item->id_article))
                                                                <font color="#006400"><p><b>Prix:</b> <span
                                                                                class="tab">{{ getPrixTaux($item->prix_vente, getTauxPromo($item->id_article) ) }}</span>
                                                                    </p></font>

                                                            @else
                                                                <p><b>Prix:</b> {{ getTTC($item->prix_vente) }}
                                                                    Dhs
                                                                    TTC</p>
                                                            @endif
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

                                    </tbody>


                                </table>


                                <div class="row">

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
                                        <input class="form-control" type="text" placeholder="ref" name="ref" value="{{ old('ref') }}">
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
                                               placeholder="Raison" name="raison"  value="{{ old('raison') }}">
                                    </div>
                                </div>
                                <div class="row" align="center">
                                    <button type="submit" name="submit" value="valider" class="btn btn-primary">
                                        Valider la vente
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection


@section('menu_1')
    @include('Espace_Vend._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Vend._nav_menu_2')
@endsection
