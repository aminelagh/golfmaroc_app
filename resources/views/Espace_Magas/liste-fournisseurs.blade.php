@extends('layouts.main_master')

@section('title') Fournisseurs @endsection

@section('main_content')
    <h1 class="page-header">Fournisseurs </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des Articles</li>
        <li class="breadcrumb-item active">Liste des fournisseurs</li>
    </ol>

    @include('layouts.alerts')

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead bgcolor="#DBDAD8">
                    <tr>
                        <th> #</th>
                        <th>Code</th>
                        <th>Fournisseur</th>
                        <th>Autres</th>
                    </tr>
                    </thead>
                    <tfoot bgcolor="#DBDAD8">
                    <tr>
                        <th></th>
                        <th>Code</th>
                        <th>Fournisseur</th>
                        <th></th>
                    </tr>
                    </tfoot>

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td></td>
                            <td>Aucun fournisseur</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr class="odd gradeA">
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->libelle }}</td>
                                <td align="center">
                                    <div class="btn-group pull-right">
                                        <button type="button"
                                                class="btn green btn-sm btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <span {!! setPopOver("","Clisuez ici pour afficher les actions") !!}>Actions</span>
                                            <i class="fa fa-angle-down"></i>
                                        </button>

                                        <ul class="dropdown-menu pull-left" role="menu">
                                            <li>
                                                <a href="{{ Route('magas.fournisseur',['p_id' => $item->id_fournisseur ]) }}"
                                                        {!! setPopOver("","Afficher plus de detail") !!} ><i
                                                            class="glyphicon glyphicon-eye-open"></i>
                                                    Plus de detail
                                                </a>
                                            </li>
                                            <li>
                                                <a onclick="return confirm('Êtes-vous sure de vouloir effacer le fournisseur: {{ $item->code }} - {{ $item->libelle }} ?')"
                                                   href="#"
                                                   title="effacer"><i class="glyphicon glyphicon-trash"></i>
                                                    Effacer</a>
                                            </li>
                                        </ul>

                                    </div>
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
        <a href="{{ Route('magas.addFournisseur') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouveau fournisseur") !!}>
            <i class="glyphicon glyphicon-plus "></i> Ajouter un fournisseur</a>
    </div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Code") {
                    $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title != "") {
                    $(this).html('<input type="text" size="20" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
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
                    {"width": "10%", "targets": 0},
                    {"width": "10%", "targets": 1},
                    {"width": "10%", "targets": 3},
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

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection