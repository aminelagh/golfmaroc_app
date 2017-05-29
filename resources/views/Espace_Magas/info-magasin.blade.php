@extends('layouts.main_master')

@section('title') Magasin: {{ $data->libelle }} @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <h1 class="page-header"> Info Magasin</h1>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item ">Gestion des Magasins</li>
                <li class="breadcrumb-item"><a href="{{ route('magas.lister',['p_table' => 'magasins' ]) }}">Liste des
                        magasins</a></li>
                <li class="breadcrumb-item active">{{ $data->libelle  }}</li>
            </ol>

            @include('layouts.alerts')

            {{-- info magasin --}}
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    {{-- debut panel magasin --}}
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            <h2>{{ $data->libelle }}</h2>
                        </div>

                        <!-- debut panel body -->
                        <div class="panel-body">
                            <table class="table table-hover" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td>Libelle</td>
                                    <td><strong>{{ $data->libelle }} </strong></td>
                                </tr>
                                <tr>
                                    <td>Ville</td>
                                    <td><strong>{{ $data->ville }} </strong></td>
                                </tr>
                                <tr>
                                    <td>Adresse</td>
                                    <td><strong>{{ $data->adresse }} </strong></td>
                                </tr>
                                <tr>
                                    <td>Nom du representant</td>
                                    <td><strong>{!! $data->agent or '<i></i>' !!} </strong></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><strong>{{ $data->email }} </strong></td>
                                </tr>
                                <tr>
                                    <td>Telephone</td>
                                    <td><strong>{{ $data->telephone }} </strong></td>
                                </tr>
                                <tr>
                                    <td>Date de creation</td>
                                    <td><strong>{{ getDateHelper($data->created_at) }}
                                            a {{ getTimeHelper($data->created_at) }}    </strong></td>
                                </tr>
                                <tr>
                                    <td>Date de derniere modification</td>
                                    <td><strong>{{ getDateHelper($data->updated_at) }}
                                            a {{ getTimeHelper($data->updated_at) }}     </strong></td>
                                </tr>
                            </table>


                            @if( strlen($data->description) > 0 )
                                <div class="page-header">
                                    <h3>Description</h3>
                                </div>
                                <div class="well">
                                    <p>{{ $data->description }}</p>
                                </div>
                            @endif

                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <a href="{{ Route('magas.delete',['p_table' => 'magasins', 'p_id' => $data->id_magasin ]) }}"
                                   onclick="return confirm('Êtes-vous sure de vouloir effacer le magasin: {{ $data->libelle }} ?')"
                                   type="button" class="btn btn-outline btn-danger"
                                   title="" data-toggle="popover" data-placement="top" data-trigger="hover"
                                   data-content="Supprimer le magasin et vider son stock">Supprimer </a>
                                <a href="{{ Route('magas.update',['id_article' => $data->id_magasin, 'p_table' => 'magasins' ]) }}"
                                   type="button" class="btn btn-outline btn-info"
                                   title="" data-toggle="popover" data-placement="top" data-trigger="hover"
                                   data-content="Modifier les informations du magasin"> Modifier </a>

                            </div>
                        </div>
                    </div>
                    {{-- fin panel magasin --}}

                </div>
                <div class="col-lg-1"></div>
            </div>
            <!-- /.info magasin -->

            <!-- stock magasin -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading" align="center"><h3>Stock du Magasin</h3></div>
                        <br>

                        {{-- Table de: Stock --}}
                        <div class="table-responsive">
                            {{-- Table --}}
                            <div class="col-lg-12">
                                <table id="example" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article</th>
                                        <th>Quantite</th>
                                        <th>Etat</th>
                                        <th>autre</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if( $stocks->isEmpty() )
                                        <tr>
                                            <td colspan="4" align="center">le stock de ce magasin est vide, appuyez sur
                                                le bouton en bas de la page pour lui ajouter des articles
                                            </td>
                                        </tr>
                                    @else
                                        {{-- boucle sur les elements du stock --}}
                                        @foreach( $stocks as $item )
                                            {{-- Tests pour definir la couleur de la ligne --}}
                                            @if( $item->quantite > $item->quantite_min )
                                                <tr class="success">
                                            @endif
                                            @if( $item->quantite < $item->quantite_min )
                                                <tr class="danger">
                                            @endif
                                            @if( $item->quantite == $item->quantite_min )
                                                <tr class="warning">
                                                    @endif
                                                    {{-- fin Tests pour definir la couleur de la ligne --}}


                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ getChamp("articles", "id_article",  $item->id_article , "designation_c") }}</td>
                                                <!--td>{{ $item->quantite_min }} | {{ $item->quantite }} | {{ $item->quantite_max }}</td-->

                                                    <td> {{ $item->quantite }} unités
                                                        ({{ ($item->quantite / $item->quantite_max)*100 }}%)
                                                    </td>

                                                    <td>
                                                        <div class="progress">
                                                            @if( $item->quantite<$item->quantite_min )
                                                                <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                                     style="width: {{ 100*($item->quantite/$item->quantite_max) }}%"></div>
                                                            @elseif( $item->quantite==$item->quantite_min )
                                                                <div class="progress-bar progress-bar-warning progress-bar-striped"
                                                                     style="width: {{ 100*($item->quantite/$item->quantite_max) }}%"></div>
                                                            @else
                                                                <div class="progress-bar progress-bar-success progress-bar-striped"
                                                                     style="width: {{ 100*($item->quantite/$item->quantite_max) }}%"></div>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info"
                                                                data-toggle="modal"
                                                                data-target="#myModal{{ $loop->index+1 }}">
                                                            Detail
                                                        </button>
                                                    </td>


                                                    {{-- Modal (pour afficher les details de chaque article) --}}
                                                    <div class="modal fade" id="myModal{{ $loop->index+1 }}"
                                                         role="dialog">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">{{ getChamp("articles", "id_article",  $item->id_article , "designation_c")  }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><b>Quantité </b> {{ $item->quantite }}</p>
                                                                    <p><b>Quantité Min</b> {{ $item->quantite_min }}
                                                                    </p>
                                                                    <p><b>Quantité Max</b> {{ $item->quantite_max }}
                                                                    </p>
                                                                    <hr>
                                                                    <p>
                                                                        <b>numero</b> {{ getChamp("articles", "id_article",  $item->id_article , "num_article")  }}
                                                                    </p>
                                                                    <p><b>code a
                                                                            barres</b> {{ getChamp("articles", "id_article",  $item->id_article , "code_barre")  }}
                                                                    </p>
                                                                    <p>
                                                                        <b>Taille</b> {{ getChamp("articles", "id_article",  $item->id_article , "taille")  }}
                                                                    </p>
                                                                    <p>
                                                                        <b>Couleur</b> {{ getChamp("articles", "id_article",  $item->id_article , "couleur")  }}
                                                                    </p>
                                                                    <p>
                                                                        <b>sexe</b> {{ getChamp("articles", "id_article",  $item->id_article , "sexe") }}
                                                                    </p>
                                                                    <p><b>Prix
                                                                            d'achat</b> {{ getChamp("articles", "id_article",  $item->id_article , "prix_achat")  }}
                                                                    </p>
                                                                    <p><b>Prix de
                                                                            vente</b> {{ getChamp("articles", "id_article",  $item->id_article , "prix_vente")  }}
                                                                    </p>
                                                                    <p>{{ getChamp("articles", "id_article",  $item->id_article , "designation_l")  }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-default"
                                                                            data-dismiss="modal">Fermer
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- fin Modal (pour afficher les details de chaque article) --}}

                                                </tr>
                                                @endforeach
                                                {{-- fin boucle sur les elements du stock --}}
                                            @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Fin Table de: Stock --}}

                        <div calss="row" align="center">
                            <a href="{{ Route('magas.addStock',['p_id_magasin' => $data->id_magasin ]) }}"
                               type="button" class="btn btn-outline btn-info"
                               title="" data-toggle="popover" data-placement="top" data-trigger="hover"
                               data-content="Ajouter des nouveaux articles au stock de ce magasin">Ajouter des
                                articles</a>
                            <a href="{{ Route('magas.supplyStock',['p_id_magasin' => $data->id_magasin ]) }}"
                               type="button" class="btn btn-outline btn-info"
                               title="" data-toggle="popover" data-placement="top" data-trigger="hover"
                               data-content="Alimenter le stock de ce magasin."> Alimenter </a>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <!-- /.stock magasin -->

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
    <script src="{{  asset('js/jquery.js') }}"></script>
    <script src="{{  asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
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
                    {"width": "02%", "targets": 0},
                    {"width": "20%", "targets": 1},
                    {"width": "15%", "targets": 2},
                    //{"width": "10%", "targets": 3},
                    {"width": "05%", "targets": 4}
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
