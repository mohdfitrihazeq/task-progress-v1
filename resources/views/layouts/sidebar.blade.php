<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Task Progress</div>
  </a>
  
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  
  <!-- <li class="nav-item">
    <a class="nav-link" href="{{ route('roles') }}">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Role</span></a>
  </li> -->
  
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Maintenance</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Maintenance</h6>
            @if(Auth::user()->role_name == 'MSA')
              <a class="collapse-item" href="{{ route('roles') }}">CRUD Role</a>
              <a class="collapse-item" href="{{ route('company') }}">CRUD Company</a>
            @endif
              <a class="collapse-item" href="{{ route('project') }}">CRUD Project</a>
          </div>
      </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('profile')}}">
      <i class="fas fa-fw fa-folder"></i>
      <span>Profile</span></a>
  </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  
  
</ul>