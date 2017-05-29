@extends('layouts.main_master')

@section('title') Liste des promotions du magasin  @endsection

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
                if (title == "Prix en Promotion") {
                    $(this).html('<input type="text" size="12" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
                    {"width": "09%", "targets": 1, "type": "string", "visible": true},
                    //{"width": "07%", "targets": 2, "type": "string", "visible": true},
                    //{"width": "03%", "targets": 4, "type": "string", "visible": true},
                    //{"width": "06%", "targets": 5, "type": "string", "visible": true}
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
                <h2 class="page-header">Liste des Promotions disponibles</h2>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vend.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Liste des promotions</li>
                </ol>

                {{-- **************Alerts**************  --}}
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        {{-- Debut Alerts --}}
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
                        {{-- Fin Alerts --}}
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                {{-- **************endAlerts**************  --}}


                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb">
                            Afficher/Masquer:
                            <a class="toggle-vis" data-column="1">Designation</a> -
                            <a class="toggle-vis" data-column="2">Prix</a> -
                            <a class="toggle-vis" data-column="3">Taux</a> -
                            <a class="toggle-vis" data-column="4">Prix en promotion</a> -
                            <a class="toggle-vis" data-column="5">Date debut</a> -
                            <a class="toggle-vis" data-column="6">Date fin</a>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="example">
                            <thead bgcolor="#DBDAD8">
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-fw fa-sort"></i> Article</th>
                                <th><i class="fa fa-fw fa-sort"></i> Prix</th>
                                <th><i class="fa fa-fw fa-sort"></i> Taux</th>
                                <th><i class="fa fa-fw fa-sort"></i> Prix en Promotion</th>
                                <th><i class="fa fa-fw fa-sort"></i> Date debut</th>
                                <th><i class="fa fa-fw fa-sort"></i> Date fin</th>
                                <th>Autre</th>
                            </tr>
                            </thead>
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Article</th>
                                <th>Prix</th>
                                <th>Taux</th>
                                <th>Prix en Promotion</th>
                                <th>Date debut</th>
                                <th>Date fin</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if( $data->isEmpty() )
                                <tr>
                                    <td colspan="8" align="center"><i>Aucune promotion</i></td>
                                </tr>
                            @else
                                @foreach( $data as $item )
                                    <tr>
                                        <td align="right">{{ $loop->index+1 }}</td>
                                        <td>{{ $item->designation_c }}</td>
                                        <td align="right">{{ number_format(getTTC($item->prix_vente),2) }} DH TTC</td>
                                        <td align="right">{{ $item->taux }} %</td>
                                        <td align="right">{{ number_format(getPrixTaux(getTTC($item->prix_vente), $item->taux),2) }} Dhs</td>
                                        <td>{{ getDateHelper($item->date_debut) }} </td>
                                        <td>{{ getDateHelper($item->date_fin) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#modal{{ $loop->index+1 }}" title="Detail article">
                                                Detail
                                            </button>
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
                                                    <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><b>numero</b> {{ $item->num_article }}</p>
                                                    <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                                    <p><b>Taille</b> {{ $item->taille }}</p>
                                                    <p><b>Couleur</b> {{ $item->couleur }}</p>
                                                    <p><b>sexe</b> {{ getSexeName($item->sexe) }}</p>
                                                    <p><b>Prix</b>
                                                        {{ number_format($item->prix_vente, 2) }} Dhs
                                                        HT, {{ number_format(getTTC($item->prix_vente), 2) }}
                                                        Dhs TTC </p>
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
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" align="center">
                    <a onclick="return alert('Impression en cours ....')" type="button"
                       class="btn btn-outline btn-default"><i class="fa fa-file-pdf-o" aria-hidden="true">
                            Imprimer </i></a>
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
