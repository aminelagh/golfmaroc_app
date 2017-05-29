@extends('layouts.main_master')

@section('title') Promotion de : {{ $data->designation_c }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
          <div class="row">
            <h1 class="page-header">Promotion sur {{ $data->designation_c }}</h1>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item ">Gestion des Promotions</li>
                <li class="breadcrumb-item"><a href="{{ Route('direct.lister',['p_table' => 'promotions' ]) }}">Liste des promotions</a></li>
                <li class="breadcrumb-item active">{{ $data->designation_c }}</li>
            </ol>

            {{-- Alerts --}}
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    @if (session('alert_success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button> {!! session('alert_success') !!}
                        </div>
                    @endif

                    @if (session('alert_info'))
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button> {!! session('alert_info') !!}
                        </div>
                    @endif

                    @if (session('alert_warning'))
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button> {!! session('alert_warning') !!}
                        </div>
                    @endif

                    @if (session('alert_danger'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button> {!! session('alert_danger') !!}
                        </div>
                    @endif
                </div>
                <div class="col-lg-2"></div>
            </div>
        {{-- /.Alerts --}}

        <!-- info magasin -->
            <div class="row">
                <div class="col-lg-12">
                    {{-- debut panel magasin --}}
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            <h2>Période de Promotion :
                            </h2>
                            <h3>{{ getDateHelper( $data->date_debut)  }} - {{ getDateHelper( $data->date_fin)  }}</h3>
                            <h2>Taux de Promotion:</h2> <h3> {!! $data->taux !!}%</h3>
                        </div>

                        <!-- debut panel body -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="well">
                                        <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">
                                            <th><b> Info Article en promotion</b></th>
                                            <tr>
                                                <td>Designation</td>
                                                <th>{!! $data->designation_c  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Prix d'achat</td>
                                                <th>{!! number_format( $data->prix_achat, 2) !!} Dhs HT, <br>{!! number_format( $data->prix_achat*1.2 ,2 )   !!} Dhs TTC</th>
                                            </tr>
                                            <tr>
                                                <td>Prix de vente</td>
                                                <th>{!! number_format($data->prix_vente,2) !!} Dhs HT, <br>{!! number_format($data->prix_vente*1.2 ,2)   !!} Dhs TTC</th>
                                            </tr>
                                            <tr>
                                                <td>Prix de vente avec la réduction</td>
                                                <th>{!! number_format($data->prix_vente*1.2*(1-$data->taux/100),2)  !!} Dhs TTC</th>
                                            </tr>
                                            <tr>
                                                <td>Categorie</td>
                                                <th>{!! $data->ville  or '<i>pas  défini</i>' !!} </th>
                                            </tr>
                                            <tr>
                                                <td>Fournisseur</td>
                                                <th>{!! $data->adresse  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Numero</td>
                                                <th>{!! $data->num_article  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Code a barres</td>
                                                <th>{!! $data->code_barre  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Taille</td>
                                                <th>{!! $data->taille  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Couleur</td>
                                                <th>{!! $data->couleur  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Sexe</td>
                                                <th>{!! $data->sexe  or '<i>pas  défini</i>' !!}</th>
                                            </tr>

                                        </table>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="well">
                                        <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">
                                            <th>Info Magasin </th>
                                            <tr>
                                                <td>Nom du magasin</td>
                                                <th>{!! $data->libelle  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Ville</td>
                                                <th>{!! $data->ville  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                            <tr>
                                                <td>Adresse</td>
                                                <th>{!! $data->adresse  or '<i>pas  défini</i>' !!}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" align="center">
                                <a href="{{ Route('direct.delete',['p_table' => 'promotions', 'p_id' => $data->id_promotion ]) }}"
                                   onclick="return confirm('Êtes-vous sure de vouloir effacer la promotion: {{ $data->libelle }} ?')"
                                   type="button"
                                   class="btn btn-outline btn-danger" {!! setPopOver("","Supprimer la promotion") !!}
                                >Supprimer</a>

                                <a href="{{ Route('direct.delete',['p_table' => 'promotions', 'p_id' => $data->id_promotion ]) }}"
                                   onclick="return confirm('Êtes-vous sure de vouloir effacer la promotion: {{ $data->libelle }} ?')"
                                   type="button"
                                   class="btn btn-outline btn-warning" {!! setPopOver("","Desactiver la promotion") !!}>Desactiver</a>

                                <a href="{{ Route('direct.update',['id_article' => $data->id_magasin, 'p_table' => 'magasins' ]) }}"
                                   type="button"
                                   class="btn btn-outline btn-info" {!! setPopOver("","Modifier la promotion") !!}>Modifier</a>

                            </div>
                        </div>
                    </div>
                  </div>
                    {{-- fin panel magasin --}}

                </div>
                <div class="col-lg-1"></div>
            </div>
            <!-- /.info magasin -->
        </div>
    </div>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // DataTable
            var table = $('#example').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "02%", "targets": 0},
                    {"width": "20%", "targets": 1},
                    {"width": "15%", "targets": 2},
                    //{"width": "10%", "targets": 3},
                    {"width": "05%", "targets": 4}

                ]
            });
            // Apply the search
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
