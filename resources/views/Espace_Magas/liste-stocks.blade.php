@extends('layouts.main_master')

@section('title') Stock du main magasin: {{ $magasin->libelle }}  @endsection

@section('main_content')

    <h3 class="page-header">Stock du main magasin:
        <strong>{{ $magasin->libelle }}</strong></h3>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item ">Gestion des magasins</li>
        <li class="breadcrumb-item ">{{ $magasin->libelle  }}</li>
        <li class="breadcrumb-item active">Stock du magasin: {{ $magasin->libelle  }}</li>
    </ol>

    <div class="row">
        <div class="table-responsive">
            <div class="col-lg-12">

                {{-- *************** form ***************** --}}
                <form role="form" name="myForm" id="myForm" method="post"
                      action="{{ Route('magas.submitAddStockIN') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_magasin" value="{{ $magasin->id_magasin }}"/>

                    @foreach( $data as $item )

                        <div class="col-md-7">
                            <p>{{ \App\Models\Article::getDesignation($item->id_article) }}</p>
                        </div>

                        <input type="hidden" name="id_stock[{{ $loop->index+1 }}]" value="{{ $item->id_stock }}"/>

                        <table id="example_{{$loop->index+1}}" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th>Article</th>
                                <th>quantite_min</th>
                                <th>quantite_max</th>
                                <th>
                                    <button id="addRow_{{ $loop->index+1 }}" form="NotFormSubmiForm"
                                            class="btn btn-outline btn-primary btn-sm" {!! setPopOver("","Cliqy") !!}>Ajouter une taille
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>{{ $loop->index+1 }}/ id_st: {{ $item->id_stock }}</td>
                                <td>{{ \App\Models\Article::getDesignation($item->id_article) }}</td>
                                <td>{{ $item->quantite_min }}</td>
                                <td>{{ $item->quantite_max }}</td>
                                <td></td>
                            </tr>
                            @if( \App\Models\Stock_taille::hasTailles($item->id_stock))
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Taille</th>
                                    <th>Quantite</th>
                                    <th>Quantite in</th>
                                </tr>

                                @foreach( \App\Models\Stock_taille::getTailles($item->id_stock) as $taille )


                                    <tr>
                                        <input type="hidden"
                                               name="id_taille_article[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                               value="{{ $taille->id_taille_article }}"/>
                                        {{-- <input type="hidden"
                                               name="quantite[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                               value="{{ $item->quantite }}"/>--}}

                                        <td></td>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ \App\Models\Taille_article::getTaille($taille->id_taille_article) }}</td>
                                        <td>{{ $taille->quantite }}</td>
                                        <td><input type="number" min="0" placeholder="Quantite IN" width="5"
                                                   class="form-control"
                                                   name="quantiteIN[{{ $item->id_stock }}][{{ $loop->index+1 }}]"
                                                   value=""></td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>

                        <script type="text/javascript" charset="utf-8">
                            $(document).ready(function () {

                                var t_{{$loop->index+1}} = $('#example_{{$loop->index+1}}').DataTable({
                                    "ordering": false,
                                    "paging": false,
                                    "searching": false,
                                    "info": false,
                                });
                                var counter = 1;

                                $('#addRow_{{ $loop->index+1 }}').on('click', function () {

                                    @if( \App\Models\Stock_taille::hasTailles($item->id_stock))

                                    if (counter == 1) {
                                        counter = {{ count(\App\Models\Stock_taille::getTailles($item->id_stock))+1 }};
                                    }

                                    t_{{$loop->index+1}}.row.add([
                                        '', '',
                                        '<select name="id_taille_article[{{ $item->id_stock }}][' + counter + ']" class="form-control" form="myForm">' +
                                        @foreach($tailles as $taille)
                                            '<option value="{{ $taille->id_taille_article }}">{{ $taille->taille }}</option>' +
                                        @endforeach
                                            '</select>',
                                        '0',
                                        '<input type="number" min="0" placeholder="Quantite IN" width="5" ' +
                                        'class="form-control" name="quantiteIN[{{ $item->id_stock }}][' + counter + ']" ' +
                                        'value="">',
                                        '--'
                                    ]).draw(false);

                                    @else

                                    if (counter == 1) {
                                        t_{{$loop->index+1}}.row.add([
                                            '',
                                            '',
                                            '<b>Taille</b>',
                                            '<b>Quantite</b>',
                                            '<b>Quantite in</b>'
                                        ]).draw(false);
                                    }

                                    t_{{$loop->index+1}}.row.add([
                                        '', '',
                                        '<select name="id_taille_article[{{ $item->id_stock }}][' + counter + ']" class="form-control">' +
                                        @foreach($tailles as $taille)
                                            '<option value="{{ $taille->id_taille_article }}">{{ $taille->taille }}</option>' +
                                        @endforeach
                                            '</select>',
                                        '0',
                                        '<input type="number" min="0" placeholder="Quantite IN" width="5" ' +
                                        'class="form-control" name="quantiteIN[{{ $item->id_stock }}][' + counter + ']" ' +
                                        'value="">',
                                        '--'
                                    ]).draw(false);


                                    @endif
                                        counter++;
                                });

                                //$('#addRow_{{$loop->index+1}}').click();

                                //popover
                                $('[data-toggle="popover"]').popover();
                            });
                        </script>

                        <hr/>
                    @endforeach

                    <input type="submit" value="Ajouter StockIN" class="btn btn-outline btn-success"
                           formtarget="_blank">
                </form>

            </div>
        </div>
    </div>

    <br/>

    <hr/>
    <br/>
@endsection

@section('menu_1')@include('Espace_Magas._nav_menu_1')@endsection
@section('menu_2')@include('Espace_Magas._nav_menu_2')@endsection


@section('scripts')
    <script>
    </script>
@endsection
