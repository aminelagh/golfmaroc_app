<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">

    <li><a href="{{ Route('direct.home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>

    <li><a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-newspaper-o"></i> Gestion Articles <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo" class="collapse">
        <li><a href="{{ Route('direct.lister',['p_table' => 'fournisseurs' ]) }}"><i class="glyphicon glyphicon-user "></i> Fournisseurs <span class="badge">{{ App\Models\Fournisseur::count() }}</span></a></li>
        <li><a href="{{ Route('direct.lister',['p_table' => 'categories' ]) }}">  <i class="glyphicon glyphicon-tasks "></i> Categories   <span class="badge">{{ App\Models\Categorie::count() }}</span></a></li>
        <li><a href="{{ Route('direct.lister',['p_table' => 'articles' ]) }}">    <i class="glyphicon glyphicon-shopping-cart"></i> Articles     <span class="badge">{{ App\Models\Article::count() }}</span></a></li>
      </ul>
    </li>

    <li><a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-home "></i>  Gestion Stocks <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo1" class="collapse">
        <li><a href="{{ Route('direct.lister',['p_table' => 'magasins' ]) }}"><i class="glyphicon glyphicon-home "></i>  Magasins    <span class="badge">{{ App\Models\Magasin::count() }}</span></a></li>
    </ul>
    </li>

    <li><a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="glyphicon glyphicon-gift "></i>  Gestion Promotions <i class="fa fa-fw fa-caret-down"></i></a>
      <ul id="demo2" class="collapse">
        {{--<li><a href="{{ Route('direct.lister',['p_table' => 'promotions' ]) }}"><i class="glyphicon glyphicon-gift "></i>     Promotions     <span class="badge">{{ App\Models\Promotion::count() }}</span></a></li>--}}
      </ul>
    </li>
  </ul>
</div>
<!-- /.navbar-collapse -->
