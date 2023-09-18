<ul class="navbar-nav bg-lawrence sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img img-fluid" width="50">
        </div>
        <div class="sidebar-brand-text mx-2">MDA System </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('andon.full') }}" target="_blank">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Dashboard OEE</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="{{ route('andon.site') }}" target="_blank">
            <i class="fas fa-fw fa-network-wired"></i>
            <span>Andon</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Operator
    </div>

    <li class="nav-item {{ Request::is('start_console*') || Request::is('/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('form.start.console') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Start Console</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ Request::is('list_console*') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('list.console') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>List Console</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Setting
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('user*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User Management</span>
        </a>
        <div id="collapseTwo" class="collapse {{ Request::is('user*') ? 'show' : '' }}" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                <a class="collapse-item {{ Request::is('user*') ? 'active' : '' }}"
                    href="{{ route('user.index') }}">User
                    Access</a>
                <a class="collapse-item" href="javascript:void(0)">Level Access</a>
                <a class="collapse-item" href="javascript:void(0)">Divisi</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Form
    </div>
    <li
        class="nav-item {{ Request::is('master/mesin*') || Request::is('master/line*') || Request::is('master/do*') || Request::is('master/sm*') || Request::is('master/plan*') || Request::is('master/unplan*') || Request::is('master/speed_loss*') || Request::is('master/quality_loss*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('master/mesin*') || Request::is('master/line*') || Request::is('master/do*') || Request::is('master/sm*') || Request::is('master/plan*') || Request::is('master/unplan*') || Request::is('master/speed_loss*') || Request::is('master/quality_loss*') ? '' : 'collapsed' }}"
            href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true"
            aria-controls="collapse3">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Master</span>
        </a>
        <div id="collapse3"
            class="collapse {{ Request::is('master/mesin*') || Request::is('master/line*') || Request::is('master/do*') || Request::is('master/sm*') || Request::is('master/plan*') || Request::is('master/unplan*') || Request::is('master/speed_loss*') || Request::is('master/quality_loss*') ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">List Master:</h6>
                <a class="collapse-item {{ Request::is('master/mesin*') ? 'active' : '' }}"
                    href="{{ route('mesin.index') }}">Machine</a>
                <a class="collapse-item {{ Request::is('master/line*') ? 'active' : '' }}"
                    href="{{ route('line.index') }}">Line</a>
                <a class="collapse-item {{ Request::is('master/do*') ? 'active' : '' }}"
                    href="{{ route('do.index') }}">DO</a>
                <a class="collapse-item {{ Request::is('master/sm*') ? 'active' : '' }}"
                    href="{{ route('sm.index') }}">Maintenance Schedule</a>
                <a class="collapse-item {{ Request::is('master/plan*') ? 'active' : '' }}"
                    href="{{ route('plan.index') }}">Plan Downtimes</a>
                <a class="collapse-item {{ Request::is('master/unplan*') ? 'active' : '' }}"
                    href="{{ route('unplan.index') }}">Unplan Downtimes</a>
                <a class="collapse-item {{ Request::is('master/speed_loss*') ? 'active' : '' }}"
                    href="{{ route('speed_loss.index') }}">Speed Losses</a>
                <a class="collapse-item {{ Request::is('master/quality_loss*') ? 'active' : '' }}"
                    href="{{ route('quality_loss.index') }}">Quality Losses</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
