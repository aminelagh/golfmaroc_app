@extends('layouts.main_master')

@section('title') Magasins @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Liste des Magasins</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Stocks</li>
                    <li class="breadcrumb-item active">Liste des magasins</li>
                </ol>

            @include('layouts.alerts')

            <!-- row table -->
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <table id="example" class="table table-striped table-bordered table-hover">
                            <thead bgcolor="#DBDAD8">
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-fw fa-sort"></i> Nom du Magasin</th>
                                <th><i class="fa fa-fw fa-sort"></i> Ville</th>
                                <th><i class="fa fa-fw fa-sort"></i> Telephone</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Magasin</th>
                                <th>Ville</th>
                                <th>Telephone</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if( $data->isEmpty() )
                                <tr>
                                    <td></td>
                                    <td align="center"><i>Aucun Magasin</i></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                @foreach( $data as $item )
                                    <tr class="odd gradeA">
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->libelle }}</td>
                                        <td>{{ $item->ville }}</td>
                                        <td align="right">{{ $item->telephone }}</td>
                                        <td>
                                            <div class="btn-group pull-right">
                                                <button type="button"
                                                        class="btn green btn-sm btn-outline dropdown-toggle"
                                                        data-toggle="dropdown"> <span {!! setPopOver("","Clisuez ici pour afficher les actions") !!}>Actions</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu">
                                                    <li>
                                                        <a href="{{ route('magas.stocks', [ 'p_id_magasin' => $item->id_magasin ] ) }}"
                                                                {!! setPopOver("Stock","Afficher le stock du magasin") !!}>Afficher
                                                            Stock</a></li>
                                                    <li>
                                                        <a href="{{ Route('magas.info',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}"
                                                                {!! setPopOver("Detail","Afficher plus de detail sur la magasin") !!}><i
                                                                    class="glyphicon glyphicon-eye-open"></i> Plus de
                                                            detail</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ Route('magas.update',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}"
                                                                {!! setPopOver("","Modifier les informations ") !!}><i
                                                                    class="glyphicon glyphicon-pencil"></i> Modifier</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ Route('magas.info',['p_table'=> 'dashboard-magasin', 'p_id' => $item->id_magasin ]) }}"
                                                           title="detail"><i class="glyphicon glyphicon-dashboard"></i>
                                                            Dashboard</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                        {{--
                                        <td align="center">
                                            <a href="{{ Route('magas.info',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}"
                                                    {!! setPopOver("Detail","Afficher plus de detail sur la magasin") !!}><i
                                                        class="glyphicon glyphicon-eye-open"></i></a>
                                            <a href="{{ Route('magas.info',['p_table'=> 'dashboard-magasin', 'p_id' => $item->id_magasin ]) }}"
                                               title="detail"><i class="glyphicon glyphicon-dashboard"></i></a>
                                            <a href="{{ Route('magas.update',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}"
                                                    {!! setPopOver("","Modifier les informations ") !!}><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
                                        </td>
                                        --}}
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end row table -->

                <!-- end main row -->


                <div class="row" align="center">
                    <a href="{{ Route('magas.add',[ 'p_table' => 'magasins' ]) }}" type="button"
                       class="btn btn-outline btn-default"> <i class="glyphicon glyphicon-plus "></i> Ajouter un Magasin
                    </a>
                </div>
            </div>
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
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                //$(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');

                if (title == "Ville") {
                    $(this).html('<input type="text" size="12" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Magasin") {
                    $(this).html('<input type="text" width="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title != "") {
                    $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
            });
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
                    {"width": "10%", "targets": 3},
                    {"width": "03%", "targets": 4}

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
