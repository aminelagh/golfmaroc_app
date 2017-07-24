<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="{{route('admin.home')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li>
                <a href="{{ route('admin.users' ) }}"><i class="fa fa-dashboard fa-fw"></i> Utilisateurs</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Gestion des promotions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('admin.promotions') }}">Promotions</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.addPromotions') }}">creation des promotions</a>
                    </li>
                    
                </ul>
            </li>

        </ul>
    </div>
</div>
