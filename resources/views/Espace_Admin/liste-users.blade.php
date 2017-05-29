@extends('layouts.main_master')

@section('title') Utlisateurs @endsection

@section('main_content')
    <h1 class="page-header">Liste des Employes</h1>

    @include('layouts.alerts')

    {{-- div Table --}}
    <div class="table-responsive">
        {{-- Table --}}

            <table id="example" class="table table-striped table-bordered table-hover" width="100%">
                <thead bgcolor="#DBDAD8">
                <tr>
                    <th width="2%">#</th>
                    <th>Role</th>
                    <th>Nom et Prenom</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Magasin</th>
                    <th width="5%">Autres</th>
                </tr>
                </thead>
                <tfoot bgcolor="#DBDAD8">
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th>Nom et Prenom</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Magasin</th>
                    <th>Autres</th>
                </tr>
                </tfoot>
                <tbody>
                @if ( isset( $data ) ) @if( $data->isEmpty() )
                    <tr>
                        <td colspan="7" align="center">Aucun employe</td>
                    </tr>
                @else @foreach( $data as $item )
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ getRoleName( $item->id_role ) }}</td>
                            <td>{{ $item->nom }} {{ $item->prenom }}</td>
                            <td>{{ $item->ville }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href=""> {!! getMagasinName( $item->id_magasin )!=null ? getMagasinName( $item->id_magasin ) : '<i>Aucun</i>'   !!}</a>
                            </td>
                            <td>
                                <a href="{{ Route('admin.info',['p_id' => $item->id_user, 'p_table' => 'users' ] ) }}"
                                   title="Detail"><i class="glyphicon glyphicon-user"></i></a>
                                <a href="{{ Route('admin.update',['p_id' => $item->id_user, 'p_table' => 'users' ]) }}"
                                   title="Modifier"><i class="glyphicon glyphicon-pencil"></i></a>
                                <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'utilisateur: {{ $item->nom }} {{ $item->prenom }} ?')"
                                   href="{{ Route('admin.delete',['p_id' => $item->id_user , 'p_table' => 'users' ]) }}"
                                   title="Supprimer"><i class="glyphicon glyphicon-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach @endif @endif
                </tbody>

                <script type="text/javascript">
                    // For demo to fit into DataTables site builder...
                    $('#example').removeClass('display').addClass('table table-striped table-bordered');
                </script>

            </table>
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
           class="btn btn-outline btn-default" title="Exporter la liste des utilisateur"> Export Excel</a>

        <a href="{{ Route('admin.add',[ 'p_table' => 'users' ]) }}" type="button"
           class="btn btn-outline btn-default" title="Exporter la liste des utilisateur"> Ajouter un utilisateur</a>
    </div>
@endsection

@section('menu_1')@include('Espace_Admin._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Admin._nav_menu_2')@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" size="10" class="form-control" placeholder="' + title + '" />');
            });
            // DataTable
            var table = $('#example').DataTable();
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