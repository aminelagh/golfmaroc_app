<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="/magas"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li>
                <a href="{{ Route('magas.magasins') }}"><i class="fa fa-dashboard fa-fw"></i> Magasins</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des articles <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ Route('magas.articles') }}">Articles</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.fournisseurs') }}">Fournisseurs</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.categories') }}">Categories</a>
                    </li>
                    <li>
                        <a href="{{ Route('magas.marques') }}">Marques</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>