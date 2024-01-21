<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-home"></i>
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
  
  <li class="nav-item">
  @if(in_array(auth()->user()->role_name,['Master Super Admin - MSA','Super Super Admin - SSA','Project Manager - PM','Project Director - PD']))
    <a class="nav-link" href="{{ route('projecttaskprogress.index',['id' => 'create']) }}">
  @else
    <a class="nav-link" href="{{ route('projecttaskprogress.index',['id' => 'update']) }}">
  @endif
    <i class="fas fa-fw fa-wrench"></i>
      <span>Task Planning</span>
    </a>
  </li>
  
  @if(Auth::user()->role_name == 'Master Super Admin - MSA' || Auth::user()->role_name == 'Super Super Admin - SSA')
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Maintenance</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Maintenance</h6>
            @if(Auth::user()->role_name == 'Master Super Admin - MSA')
              <a class="collapse-item" href="{{ route('roles') }}">CRUD Role</a>
              <a class="collapse-item" href="{{ route('company') }}">CRUD Company</a>
            @endif
              <a class="collapse-item" href="{{ route('project') }}">CRUD Project</a>
              <a class="collapse-item" href="{{ route('profile') }}">CRUD System Login User</a>
          </div>
      </div>
  </li>
  @endif
  <li class="nav-item">
    <a class="nav-link" href="{{ route('profile.editpassword', auth()->user()->id ) }}">
      <i class="fas fa-fw fa-folder"></i>
      <span>Change Password</span></a>
  </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  
  
</ul>