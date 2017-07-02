@extends('layouts.main_master')

@section('title') Clients @endsection

@section('main_content')
    <h1 class="page-header">Clients </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des ventes</li>
        <li class="breadcrumb-item active">Liste des clients</li>
    </ol>



    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead bgcolor="#DBDAD8">
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Autres</th>
                    </tr>
                    </thead>
                    @if( !$data->isEmpty() )
                        <tfoot bgcolor="#DBDAD8">
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Ville</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    @endif

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td align="center" colspan="4"><i>Aucun Client</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr ondblclick="window.open('{{ Route('magas.client',['p_id'=>$item->id_client]) }}');">
                                <td></td>
                                <td>{{ $item->nom.' '.$item->prenom }}</td>
                                <td>{{ $item->ville }}</td>
                                <td align="center">

                                    <a href="{{ Route('magas.client',['p_id' => $item->id_client ]) }}"
                                            {!! setPopOver("","Afficher plus de detail") !!} ><i
                                                class="glyphicon glyphicon-eye-open"></i></a>

                                    <a onclick="return confirm('Êtes-vous sure de vouloir effacer la categorie: {{ $item->libelle }} ?')"
                                       href="#"
                                       title="effacer"><i class="glyphicon glyphicon-trash"></i></a>

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
        <a href="{{ Route('magas.addClient') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouveau client") !!}>
            <i class="glyphicon glyphicon-plus "></i> Ajouter un client</a>
    </div>


@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Nom" || title == "Prenom") {
                        $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Ville" || title == "Age") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                var table = $('#myTable').DataTable({
                    "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "Tout"]],
                    "searching": true,
                    "paging": true,
                    "info": false,
                    stateSave: false,
                    "columnDefs": [
                        {"visible": true, "targets": -1},
                        {"width": "05%", "targets": 0, "type": "num", "visible": true, "searchable": false}, //#
                        //{"width": "05%", "targets": 1, "type": "string", "visible": true},  //nom
                        {"width": "20%", "targets": 2, "type": "string", "visible": true},  //ville
                        {"width": "10%", "targets": 3, "type": "num-fmt", "visible": true, "searchable": false}
                    ],
                    "select": {
                        items: 'column'
                    }
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
    @endif
@endsection

@section('menu_1') @include('Espace_Magas._nav_menu_1') @endsection
@section('menu_2') @include('Espace_Magas._nav_menu_2') @endsection