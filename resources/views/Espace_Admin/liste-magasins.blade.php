@extends('layouts.main_master')

@section('title') Magasins @endsection

@section('main_content')
    <h1 class="page-header">Magasins </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des magasins</li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.magasins') }}">Liste des magasins</a></li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Magasin</th>
                        <th>Ville</th>
                        <th>Autres</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Magasin</th>
                        <th>Ville</th>
                        <th></th>
                    </tr>
                    </tfoot>

                    <tbody>

                    @if( $data->isEmpty() )
                        <tr>
                            <td align="center" colspan="4"><i>Aucun magasin</i></td>
                        </tr>
                    @else
                        @foreach( $data as $item )
                            <tr ondblclick="window.open('{{ Route('admin.magasin',['p_id'=>$item->id_magasin]) }}');">
                                <td></td>
                                <td>{{ $item->libelle }}</td>
                                <td>{{ $item->ville }}</td>
                                <td align="center">
                                    <a href="{{ Route('admin.magasin',['p_id' => $item->id_magasin ]) }}"
                                            {!! setPopOver("","Details") !!} >
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                    <a onclick="return confirm('Êtes-vous sure de vouloir effacer la categorie: {{ $item->libelle }} ?')"
                                       href="{{ '' }}" {!! setPopOver("","Effacer le magasin") !!}><i class="glyphicon glyphicon-trash"></i></a>

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
        <a href="{{ Route('magas.addMagasin') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Ajouter un nouveau magasin") !!}>
            <i class="glyphicon glyphicon-plus "></i> Ajouter un magasin</a>
    </div>


@endsection

@section('scripts')
    @if(!$data->isEmpty())
        <script>
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
                        {"width": "7%", "targets": 0, "searchable": false},
                        //{"width": "30%", "targets": 1},
                        {"width": "05%", "targets": 2},
                        {"width": "05%", "targets": 3, "searchable": false},
                    ]
                });

                table.on('order.dt search.dt', function () {
                    table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "Magasin") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });


                //footer input: hide text
                $('a.toggle-vis').on('click', function (e) {
                    e.preventDefault();
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                });

                //footer search
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