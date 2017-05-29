<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">

    <li><a href="{{ Route('vend.home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ Route('vend.addVente') }}" > <i class="fa fa-fw fa-plus"></i> Ajouter une vente </a></li>

    <li><a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-shopping-cart"></i> Gestion des Ventes <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo" class="collapse">
        <li><a href="{{ Route('vend.lister',[ 'p_table' => 'transact','p_id'=>3 ]) }}">Ventes établies <span class="badge">{{ App\Models\Transaction::where(['id_type_transaction'=> 3,'id_user'=> 3 ])->count() }} </span></a></li>
        <li><a href="{{ Route('vend.lister',[ 'p_table' => 'promotions' , 'p_id' => null ] ) }}">Promotions Magasin <span class="badge">{{ App\Models\Promotion::where(['id_magasin'=> 2 ])->count() }} </span></a></li>
        <li><a href="{{ Route('vend.lister',[ 'p_table' => 'stocks','p_id'=>3] ) }}">Stock Magasin <span class="badge">{{ App\Models\Stock::where(['id_magasin'=> 2])->count() }} </span></a></li>

      </ul>
    </li>

    <!--<li><a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-cube-black"></i> Gestion Stocks <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo1" class="collapse">
        <li><a href="{{ Route('direct.lister',['p_table' => 'magasins' , 'p_id' => null ]) }}">    Magasins     <span class="badge">{{ App\Models\Magasin::count() }}     </span></a></li>
        <li><a href="{{ Route('direct.lister',['p_table' => 'stocks' , 'p_id' => null ]) }}">     Stocks      <span class="badge">{{ App\Models\Stock::count() }}      </span></a></li>

      </ul>
    </li>-->
  </ul>
</div>
<!-- /.navbar-collapse -->
