@extends('layouts.main_master')

@section('title') Utlisateurs @endsection

@section('main_content')
    <h1 class="page-header">Liste des Employes</h1>

    @include('layouts.alerts')

    {{-- div Table --}}
    <div class="table-responsive">
        <div class="col-lg-12">
            <table id="example" class="table table-striped table-bordered table-hover" width="100%">
                <thead bgcolor="#DBDAD8">
                <tr>
                    <th>#</th>
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
                            <a href=""> {!! getMagasinName( $item->id_magasin )!=null ? getMagasinName( $item->id_magasin ) : '<i>Aucun</i>'   !!}</a>
                        </td>
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
                                        <a href="{{ Route('admin.user',['p_id' => $item->id ]) }}"
                                           title="detail"><i class="glyphicon glyphicon-eye-open"></i>
                                            Plus de detail
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ Route('magas.update',['p_table'=> 'agents', 'p_id' => $item->id_agent ]) }}"
                                           title="modifier"><i class="glyphicon glyphicon-pencil"></i>
                                            Modifier</a>
                                    </li>
                                    <li>
                                        <a onclick="return confirm('Êtes-vous sure de vouloir effacer le Fournisseur: {{ $item->nom }} {{ $item->prenom }} ?')"
                                           href="{{ Route('magas.delete',['p_table' => 'agents' , 'p_id' => $item->id_agent ]) }}"
                                           title="effacer"><i class="glyphicon glyphicon-trash"></i>
                                            Effacer</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a data-toggle="modal"
                                           data-target="#myModal{{ $loop->index+1 }}"><i
                                                    {!! setPopOver("","Afficher plus de detail") !!} class="glyphicon glyphicon-info-sign"></i>
                                            visualiser</a>
                                    </li>
                                </ul>
                            </div>


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
        <a target="_blank" href="{{ Route('export',[ 'p_table' => 'users' ]) }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Exporter la liste des utilisateur") !!}> Export Excel</a>

        <a href="{{ Route('admin.home',[ 'p_table' => 'users' ]) }}" type="button"
           class="btn btn-outline btn-default" {!! setPopOver("","Creer un nouvel utilisateur") !!}> Ajouter un utilisateur</a>
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
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},//#
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