<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/publications*') ? 'active' : '' }}" href="{{ url('admin/publications') }}">
          <i class="bi-house-fill"></i>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/publications*') ? 'active' : '' }}" href="{{ url('admin/publications') }}">
          <i class="bi-journal-text"></i>
          Publications
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/datasets*') ? 'active' : '' }}" href="{{ url('admin/datasets') }}">
          <i class="bi-file-earmark-bar-graph"></i>
          Datasets
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/tags*') ? 'active' : '' }}" href="{{ url('admin/tags') }}">
          <i class="bi-bookmarks-fill"></i>
          Tags
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ url('admin/users') }}">
          <i class="bi-people-fill"></i>
          Users
        </a>
      </li>
    </ul>
  </div>
</nav>