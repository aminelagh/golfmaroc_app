@extends('layouts.main_master')

@section('title')  {{ $article->designation.': ('.\App\Models\Stock::getNombreArticles($stock->id_stock).')' }} @endsection

@section('main_content')

    <h3 class="page-header">Stock du magasin principal:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des magasins</li>
        <li class="breadcrumb-item "><a href="{{ route('magas.magasin') }}">{{ $magasin->libelle  }}</a></li>
        <li class="breadcrumb-item ">Stock</li>
        <li class="breadcrumb-item active">{{ $article->designation  }}</li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th>Taille</th>
                        <th>Quantite</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Taille</th>
                        <th>Quantite</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach( $data as $item )
                        <tr ondblclick="window.open('{{ Route('magas.stock',[ 'p_id' => $item->id_stock ]) }}');">

                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ \App\Models\Taille_article::getTaille($item->id_taille_article) }}</td>
                            <td>{{ $item->quantite }}</td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    @if( !$data->isEmpty() )
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#myTable tfoot th').each(function () {
                    var title = $(this).text();
                    if (title == "numero" || title == "code") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Designation") {
                        $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                    else if (title == "Couleur" || title == "Sexe") {
                        $(this).html('<input type="text" size="5" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';"/>');
                    }
                    else if (title != "") {
                        $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                    }
                });

                var table = $('#myTable').DataTable({
                    //"scrollY": "50px",
                    //"scrollX": true,
                    "searching": true,
                    "paging": true,
                    //"autoWidth": true,
                    "info": true,
                    stateSave: false,
                    "columnDefs": [
                        {"width": "03%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                        //{"width": "05%", "targets": 1, "type": "string", "visible": false},
                       // {"width": "07%", "targets": 2, "type": "string", "visible": false},
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
    @endif
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection