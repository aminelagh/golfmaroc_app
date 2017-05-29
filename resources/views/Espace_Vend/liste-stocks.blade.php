@extends('layouts.main_master')

@section('title') Stock du magasin  @endsection

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
                if (title == "Article") {
                    $(this).html('<input type="text" size="30" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
                    {"width": "05%", "targets": 1, "type": "string", "visible": true},
                    {"width": "10%", "targets": 2, "type": "string", "visible": true},
                    {"width": "03%", "targets": 4, "type": "string", "visible": true},
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
                <h1 class="page-header">Stock du magasin
                    <strong>{{ getChamp('magasins','id_magasin',$data->first()->id_magasin, 'libelle')  }}</strong></h1>

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

                <div class="table-responsive">
                    <div class="col-lg-12">
                        <table id="example" class="table table-striped table-bordered table-hover">
                            <thead bgcolor="#DBDAD8" align="center">
                            <tr>
                                <th>#</th>
                                <th>Article</th>
                                <th>Quantite</th>
                                <th>Etat</th>
                                <th align="center">Autres</th>
                            </tr>
                            </thead>
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Article</th>
                                <th>Quantite</th>
                                <th>Etat</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if( $data->isEmpty() )
                                <tr>
                                    <td colspan="4">Aucun Stock</td>
                                </tr>
                            @else
                                @foreach( $data as $item )
                                    <tr>
                                        <td align="right">{{ $loop->index+1 }}</td>
                                        <td align="left">{{ getChamp('articles','id_article',$item->id_article, 'designation_c') }}</td>
                                        <td align="right">{{ $item->quantite }}
                                            article(s), {{ ($item->quantite/$item->quantite_max)*100 }}%</td>
                                        <td>
                                            <div class="progress">
                                                @if( $item->quantite<$item->quantite_min )
                                                    <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                         style="width: {{ 100*($item->quantite/$item->quantite_max) }}%"></div>
                                                @elseif( $item->quantite==$item->quantite_min )
                                                    <div class="progress-bar progress-bar-warning progress-bar-striped"
                                                         style="width: {{ 100*($item->quantite/$item->quantite_max) }}%"></div>
                                                @else
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                         style="width: {{ 100*($item->quantite/$item->quantite_max) }}%"></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td align="center">
                                            <a href="#" title="detail"><i class="glyphicon glyphicon-eye-open"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" align="center">
                    <a onclick="return alert('Printing ....')" type="button" class="btn btn-outline btn-primary"><i
                                class="fa fa-file-pdf-o" aria-hidden="true"> Imprimer </i></a>
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
