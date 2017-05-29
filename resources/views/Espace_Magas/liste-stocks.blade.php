@extends('layouts.main_master')

@section('title') Stock du {{ getChamp('magasins','id_magasin',$data->first()->id_magasin, 'libelle')  }}  @endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Stock du
                    <strong>{{ getChamp('magasins','id_magasin',$data->first()->id_magasin, 'libelle')  }}</strong></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ Route('magas.lister',['p_table' => 'magasins' ]) }}">Liste des magasins</a> </li>
                    <li class="breadcrumb-item">{{ getChamp('magasins','id_magasin',$data->first()->id_magasin, 'libelle')  }}</li>
                    <li class="breadcrumb-item active">Stock du magasin</li>
                </ol>

                @include('layouts.alerts')

                <div class="row">
                    <div class="table-responsive">
                        <div class="col-lg-12">
                            <table id="example" class="table table-striped table-bordered table-hover">

                                <thead bgcolor="#DBDAD8">
                                <tr>
                                    <th>#</th>
                                    <th>Article</th>
                                    <th>Quantite</th>
                                    <th>Etat</th>
                                    <th>Autres</th>
                                </tr>
                                </thead>
                                <tfoot bgcolor="#DBDAD8">
                                <tr>
                                    <th></th>
                                    <th>Article</th>
                                    <th>Quantite</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </tfoot>

                                <tbody>
                                @foreach( $data as $item )

                                    {{-- Tests pour definir la couleur de la ligne --}}
                                    @if( $item->quantite > $item->quantite_min )
                                        <tr class="success">
                                    @elseif( $item->quantite < $item->quantite_min )
                                        <tr class="danger">
                                    @elseif( $item->quantite == $item->quantite_min )
                                        <tr class="warning">
                                    @else
                                        <tr>
                                            @endif
                                            {{-- fin Tests pour definir la couleur de la ligne --}}

                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ getChamp('articles','id_article',$item->id_article, 'designation_c') }}</td>
                                            <td>{{ $item->quantite }}
                                                article(s), {{ ($item->quantite/$item->quantite_max)*100 }}%
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
                                            <td align="center">
                                                <!--a href=" Route('magas.info',['p_table'=> 'magasins' , 'p_id' => $item->id_magasin  ]) }}"
                                                   title="detail"><i class="glyphicon glyphicon-eye-open"></i></a-->
                                                <a data-toggle="modal" data-target="#myModal{{ $loop->index+1 }}"><i
                                                            class="glyphicon glyphicon-info-sign" aria-hidden="false"></i></a>
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
                                                            <p><b>Quantité : </b> {{ $item->quantite }}
                                                            </p>
                                                            <p><b>Quantité
                                                                    Min :</b> {{ $item->quantite_min }}
                                                            </p>
                                                            <p><b>Quantité
                                                                    Max :</b> {{ $item->quantite_max }}
                                                            </p>
                                                            <hr>
                                                            <p>
                                                                <b>numero :</b> {{ getChamp("articles", "id_article",  $item->id_article , "num_article")  }}
                                                            </p>
                                                            <p><b>code a
                                                                    barres :</b> {{ getChamp("articles", "id_article",  $item->id_article , "code_barre")  }}
                                                            </p>
                                                            <p>
                                                                <b>Taille :</b> {{ getChamp("articles", "id_article",  $item->id_article , "taille")  }}
                                                            </p>
                                                            <p>
                                                                <b>Couleur :</b> {{ getChamp("articles", "id_article",  $item->id_article , "couleur")  }}
                                                            </p>
                                                            <p>
                                                                <b>sexe :</b> {{ getChamp("articles", "id_article",  $item->id_article , "sexe") }}
                                                            </p>
                                                            <p><b>Prix
                                                                    d'achat :</b> {{ getChamp("articles", "id_article",  $item->id_article , "prix_achat")  }} DH
                                                            </p>
                                                            <p><b>Prix de
                                                                    vente :</b> {{ getChamp("articles", "id_article",  $item->id_article , "prix_vente")  }} DH
                                                            </p>
                                                            <p><b>Description :</b> {{ getChamp("articles", "id_article",  $item->id_article , "designation_l")  }}</p>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <br/>
                <div class="row" align="center">
                    <a href="{{ Route('magas.addStock',['p_id_magasin' => $data->first()->id_magasin ]) }}"
                       type="button"
                       class="btn btn-outline btn-info" {!! setPopOver("","Ajouter des nouveaux articles au stock de ce magasin") !!}>
                      <i class="glyphicon glyphicon-plus "></i>  Ajouter des articles</a>
                    <a href="{{ Route('magas.supplyStock',[ 'p_id_magasin' => $data->first()->id_magasin ]) }}"
                       type="button" class="btn btn-outline btn-default" {!! setPopOver("","Alimenter le stock ") !!}>
                      <i class="glyphicon glyphicon-plus "></i>   Alimenter le Stock </a>
                </div>

            </div>
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
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            //popover
            $('[data-toggle="popover"]').popover();

            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();
                if (title == "Article" || title == "code") {
                    $(this).html('<input type="text" size="14" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
                }
                else if (title != "") {
                    $(this).html('<input type="text" size="8" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" />');
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
                    {"width": "02%", "targets": 0, "type": "num", "visible": true, "searchable": false},
                    {"width": "25%", "targets": 1, "type": "string", "visible": true},
                    {"width": "15%", "targets": 2, "type": "string", "visible": true},
                    {"width": "02%", "targets": 4, "type": "string", "visible": true}
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
