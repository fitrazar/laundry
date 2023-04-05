<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-text mx-3">Laundry </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item {{ Request::is('customer*') ? 'active' : '' }}">
        <a class="nav-link" href="/customer">
            <i class="fa-solid fa-users"></i>
            <span>Pelanggan</span></a>
    </li>

    <li class="nav-item {{ Request::is('stock*') ? 'active' : '' }}">
        <a class="nav-link" href="/stock">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Stok</span></a>
    </li>

    <li class="nav-item {{ Request::is('service*') ? 'active' : '' }}">
        <a class="nav-link" href="/service">
            <i class="fa-solid fa-shirt"></i>
            <span>Layanan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Tambahan
    </div>

    <li class="nav-item {{ Request::is('report*') ? 'active' : '' }}">
        <a class="nav-link" href="/report">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span></a>
    </li>

    <li class="nav-item {{ Request::is('order*') ? 'active' : '' }}">
        <a class="nav-link" href="/order">
            <i class="fas fa-fw fa-table"></i>
            <span>Order</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->