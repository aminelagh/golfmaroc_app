<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">

      <li>
        <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
      </li>

      <li>
        <a href="{{ route('admin.lister', ['p_table' => 'users'] ) }}"><i class="fa fa-dashboard fa-fw"></i> Utilisateurs</a>
      </li>

      <li>
        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li>
            <a href="#">Second Level Item</a>
          </li>
          <li>
            <a href="#">Second Level Item</a>
          </li>
          <li>
            <a href="#">Third Level <span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
              <li>
                <a href="#">Third Level Item</a>
              </li>
              <li>
                <a href="#">Third Level Item</a>
              </li>
              <li>
                <a href="#">Third Level Item</a>
              </li>
              <li>
                <a href="#">Third Level Item</a>
              </li>
            </ul>
            <!-- /.nav-third-level -->
          </li>
        </ul>
        <!-- /.nav-second-level -->
      </li>

    </ul>
  </div>
</div>