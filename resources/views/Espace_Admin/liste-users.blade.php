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
                            <td>{{  $item->id_role }}</td>
                            <td>{{ $item->nom }} {{ $item->prenom }}</td>
                            <td>{{ $item->ville }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href=""> {!! getMagasinName( $item->id_magasin )!=null ? getMagasinName( $item->id_magasin ) : '<i>Aucun</i>'   !!}</a>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <button type="button"
                                            class="btn green btn-sm btn-outline dropdown-toggle"
                                            data-toggle="dropdown">
                                        <span {!! setPopOver("","Clisuez ici pour afficher les actions") !!}>Actions</span>
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-left" role="menu">
                                        <li>
                                            <a href="{{ Route('magas.info',['p_table' => 'articles', 'p_id'=> $item->id_article ]) }}"
                                                    {!! setPopOver("","Afficher plus de detail") !!}><i
                                                        class="glyphicon glyphicon-eye-open"></i> Plus de
                                                detail</a>
                                        </li>
                                        <li>
                                            <a href="{{ Route('magas.update',['p_table' => 'articles', 'p_id' => $item->id_article ]) }}"
                                                    {!! setPopOver("","Modifier") !!}><i
                                                        class="glyphicon glyphicon-pencil"></i> Modifier</a>
                                        </li>
                                        <li>
                                            <a onclick="return confirm('Êtes-vous sure de vouloir effacer l\'article: {{ $item->designation_c }} ?')"
                                               href="{{ Route('magas.delete',['p_table' => 'articles' , 'p_id' => $item->id_article ]) }}"
                                                    {!! setPopOver("","Effacer l'article") !!}><i
                                                        class="glyphicon glyphicon-trash"></i> Effacer</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a data-toggle="modal" data-target="#modal{{ $loop->index+1 }}"><i
                                                        class="glyphicon glyphicon-info-sign"
                                                        aria-hidden="false"></i> Info-Bull</a>
                                        </li>
                                    </ul>
                                </div>

                            </td>

                            {{-- Modal (pour afficher les details de chaque article) --}}
                            <div class="modal fade" id="modal{{ $loop->index+1 }}" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                            <h4 class="modal-title">{{ $item->designation_c }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>numero</b> {{ $item->num_article }}</p>
                                            <p><b>code a barres</b> {{ $item->code_barre }}</p>
                                            <p><b>Taille</b> {{ $item->taille }}</p>
                                            <p><b>Couleur</b> {{ $item->couleur }}</p>
                                            <p><b>sexe</b> {{ $item->sexe }}</p>
                                            <p><b>Prix d'achat</b></p>
                                            <p>{{ number_format($item->prix_achat, 2) }} DH
                                                HT, {{ number_format($item->prix_achat+$item->prix_achat*0.2, 2) }}
                                                Dhs TTC </p>
                                            <p><b>Prix de vente</b></p>
                                            <p>{{ number_format($item->prix_vente, 2) }} DH
                                                HT, {{ number_format($item->prix_vente+$item->prix_vente*0.2, 2) }}
                                                DH TTC </p>
                                            <p>{{ $item->designation_l }}</p>

                                            @if( $item->image != null) <img
                                                    src="{{ $item->image }}"
                                                    width="150px">@endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Fermer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- fin Modal (pour afficher les details de chaque article) --}}
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

        <a href="{{ Route('admin.home',[ 'p_table' => 'users' ]) }}" type="button"
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