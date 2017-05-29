@extends('layouts.main_master')

@section('title') Categories @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Liste des Categories </h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item active">Liste des categories</li>
                </ol>

                @include('layouts.alerts')

                <div class="row">
                    <div class="table-responsive">
                        <div class="col-lg-12">
                            <table id="example" class="table table-striped table-bordered table-hover">
                                <thead bgcolor="#DBDAD8">
                                <tr>
                                    <th> #</th>
                                    <th><i class="fa fa-fw fa-sort"></i> Categorie</th>
                                    <th><i class="fa fa-fw fa-sort"></i> Description</th>
                                    <th>Autres</th>
                                </tr>
                                </thead>
                                <tfoot bgcolor="#DBDAD8">
                                <tr>
                                    <th></th>
                                    <th>Categorie</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                                </tfoot>

                                <tbody>

                                @if( $data->isEmpty() )
                                    <tr>
                                        <td></td>
                                        <td align="center"><i>Aucune Categorie</i></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @else
                                    @foreach( $data as $item )
                                        <tr class="odd gradeA">
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $item->libelle }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td align="center">
                                                <a href="{{ Route('magas.info',['p-table'=> 'categories', 'p_id'=> $item->id_categorie ]) }}"
                                                        {!! setPopOver("","Afficher plus de detail") !!} ><i
                                                            class="glyphicon glyphicon-eye-open"></i></a>
                                                <a href="{{ Route('magas.update',['p-table'=> 'categories', 'p_id'=> $item->id_categorie ]) }}"
                                                        {!! setPopOver("","Modifier la categorie") !!}><i
                                                            class="glyphicon glyphicon-pencil"></i></a>
                                                <a onclick="return confirm('Êtes-vous sure de vouloir effacer la Categorie: {{ $item->libelle }} ?')"
                                                   href="{{ Route('magas.delete',['p_table' => 'categories' , 'p_id' => $item->id_categorie ]) }}"
                                                        {!! setPopOver("","Effacer la categorie") !!} ><i
                                                            class="glyphicon glyphicon-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <!-- row -->
                <div class="row" align="center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Exporter<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a target="_blank"
                                   href="{{ Route('export',[ 'p_table' => 'categories' ]) }}" {!! setPopOver("","Exporter la liste des categories") !!}>Excel</a>
                            </li>
                            <li><a href="#"> -- </a></li>
                            <li><a href="#"> -- </a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"> -- </a></li>
                        </ul>
                    </div>
                    <a href="{{ Route('magas.add',[ 'p_table' => 'categories' ]) }}" type="button"
                       class="btn btn-outline btn-default" {!! setPopOver("","Ajouter une nouvelle categorie") !!}>
                        <i class="glyphicon glyphicon-plus "></i>Ajouter une Categorie</a>
                </div>

            </div>

        </div>


    </div>


    <script type="text/javascript">
        // For demo to fit into DataTables site builder...
        $('#example').removeClass('display').addClass('table table-striped table-bordered');
    </script>


@endsection
@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection


@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Categorie") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title == "Description") {
                    $(this).html('<input type="text" size="2" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
            });
            // DataTable
            var table = $('#example').DataTable({
                "searching": true, "paging": true, "info": true, stateSave: false,
                "columnDefs": [
                    {"width": "05%", "targets": 0},
                    {"width": "30%", "targets": 1},
                    {"width": "10%", "targets": 3}
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