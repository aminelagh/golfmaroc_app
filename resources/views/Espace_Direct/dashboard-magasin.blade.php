@extends('layouts.main_master')

@section('title') Magasin: {{ $data->libelle }} @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
@endsection

@section('main_content')
    <!-- container-fluid -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $data->libelle }}
                    <small>Magasin</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('direct.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Gestion des Articles</li>
                    <li class="breadcrumb-item"><a href="{{ route('direct.lister',[ 'p_table' => 'fournisseurs' ]) }}">Liste
                            des fournisseurs</a></li>
                    <li class="breadcrumb-item active">{{ $data->libelle }}</li>
                </ol>

                <div id="page-wrapper">

                    <!-- row alerts -->
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
                    <!-- /.row alerts -->

                    <script src="{{  asset('charts/highcharts.js') }}"></script>
                    <script src="{{  asset('charts/exporting.js') }}"></script>
                    <script src="{{  asset('charts/drilldown.js') }}"></script>

                    {{-- Chart1 --}}
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">Chart1</div>
                        <div class="panel-body">
                            <div id="chart_Container_1" style="min-width: 310px; width: 100%;height: 400px; margin: 0 auto"></div>

                            <script type="text/javascript">
                                Highcharts.chart('chart_Container_1', {
                                    chart: {type: 'column'},
                                    title: {text: 'Title'},
                                    subtitle: {text: 'SourceText'},
                                    xAxis: {
                                        categories: [
                                            @foreach( $articles as $item )
                                                '{{ $item->designation_c }}',
                                            @endforeach
                                        ],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {text: 'Ventes'}
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: false,
                                        useHTML: true
                                    },
                                    plotOptions: {column: {pointPadding: 0.2, borderWidth: 0}},
                                    series: [
                                        {
                                            name: 'prix_vente',
                                            dataLabels: {align: "center", enabled: true},
                                            data: [
                                                @foreach( $articles as $item )
                                                {{ $item->prix_vente }},
                                                @endforeach
                                            ],

                                        }
                                    ]
                                });
                            </script>

                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Chart2</div>
                        <div class="panel-body">
                            <div id="chart_Container_2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                            <script type="text/javascript">
                                // Create the chart
                                Highcharts.chart('chart_Container_2',
                                    {
                                        chart: {type: 'column'},
                                        title: {text: 'Browser market shares. January, 2015 to May, 2015'},
                                        subtitle: {text: 'Subtitle Text'},
                                        xAxis: {type: 'category'},
                                        yAxis: {title: {text: 'Total percent market share'}},
                                        legend: {enabled: false},
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {enabled: true, format: '{point.y:.1f}%'}
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                        },

                                        series: [
                                            {
                                                name: 'Brands',
                                                colorByPoint: true,
                                                data: [
                                                    {name: 'Element A', y: 50.85, drilldown: 'id_A'},
                                                    {name: 'Element B', y: 40.94, drilldown: 'id_B'},
                                                    {name: 'Element C', y: 20.15, drilldown: 'id_C'},
                                                    {name: 'Element D', y: 10.19, drilldown: null}
                                                ]
                                            }],
                                        drilldown: {
                                            series: [
                                                {
                                                    name: 'name_A',
                                                    id: 'id_A',
                                                    data: [['v1', 24.13], ['v2', 17.2], ['v3', 8.11], ['v4', 5.33], ['v5', 1.06], ['v6', 0.5]]
                                                },
                                                {
                                                    name: 'name_B',
                                                    id: 'id_B',
                                                    data: [['v8', 2.56], ['v9', 0.77], ['v10', 0.42], ['v11', 0.3], ['v12', 0.29], ['v13', 0.26], ['v14', 0.17]]
                                                },
                                                {
                                                    name: 'name_C',
                                                    id: 'id_C',
                                                    data: [['v15', 10.6], ['v16', 4.24], ['v17', 9.17], ['v18', 2.16]]
                                                }]
                                        }
                                    });
                            </script>

                        </div>
                    </div>


                </div>
                <!-- /#page-wrapper -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@section('menu_1')
    @include('Espace_Direct._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Direct._nav_menu_2')
@endsection
