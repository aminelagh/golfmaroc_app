<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="/magas"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des Articles <span class="fa arrow"></span></a>
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
                    <li>
                        <a href="#">Third Level <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>