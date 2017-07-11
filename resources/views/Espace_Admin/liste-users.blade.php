@extends('layouts.main_master')

@section('title') Utlisateurs @endsection

@section('main_content')
    <h3 class="page-header">Liste des Employes</h3>

    {{-- div Table --}}
    <div class="table-responsive">
        <div class="col-lg-12">
            <table id="example" class="table table-striped table-bordered table-hover">
                <thead bgcolor="#DBDAD8">
                <tr>
                    <th> #</th>
                    <th>Role</th>
                    <th>Nom et Prenom</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Magasin</th>
                    <th>Autres</th>
                </tr>
                </thead>
                <tfoot bgcolor="#DBDAD8">
                <tr>
                    <th></th>
                    <th>Role</th>
                    <th>Nom et Prenom</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Magasin</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @if( $data->isEmpty() )
                    <tr>
                        <td colspan="7" align="center">Aucun employe</td>
                    </tr>
                @else @foreach( $data as $item )
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ \App\Models\User::getRole($item->id) }}</td>
                        <td>{{ $item->nom }} {{ $item->prenom }}</td>
                        <td>{{ $item->ville }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <a href=""> {!! App\Models\User::getMagasin( $item->id_magasin )!=null ? App\Models\User::getMagasin( $item->id_magasin ) : '<i>Aucun</i>'   !!}</a>
                        </td>
                        <td align="center">
                            <a href="{{ route('admin.user',[ 'id'=>$item->id ]) }}" {!! setPopOver("","Profil de l'utilisateur") !!}><i
                                        class="glyphicon glyphicon-info-sign"></i></a>
                        </td>
                    </tr>
                @endforeach @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- end Table --}}


    {{-- end div Table --}}


    <div class="row" align="center">
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Exporter<span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a target="_blank" href="{{ Route('export',[ 'p_table' => 'users' ]) }}"
                       title="Exporter la liste des utilisateur">Excel</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
            </ul>
        </div>

        <a href="{{ Route('admin.addUser') }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Creer un nouvel utilisateur") !!}> Ajouter un
            utilisateur</a>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Role" || title == "Ville") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Nom et Prenom" || title == "Fournisseur" || title == "Marque") {
                    $(this).html('<input type="text" size="11" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title != "") {
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
                    {"width": "06%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
                    {"width": "05%", "targets": 1, "type": "string", "visible": true},
                    {"width": "05%", "targets": 2, "type": "string", "visible": true},
                    {"width": "08%", "targets": 3, "type": "string", "visible": true},
                    //{"width": "08%", "targets": 4, "type": "string", "visible": true},
                    {"width": "08%", "targets": 5, "type": "string", "visible": true},
                    {"width": "05%", "targets": 6, "type": "string", "visible": true, "searchable": false}
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

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection