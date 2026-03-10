<div class="sidebar">
    <div class="sidebar-header">
        <h2>Admin Panel</h2>
        <p class="subtitle">Store Management</p>
    </div>

    <ul class="nav-menu">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
               <i class="bi bi-speedometer2"></i>
               Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('product.index') }}"
               class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}">
               <i class="bi bi-box-seam"></i>
               Product Management
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}"
               class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
               <i class="bi bi-cart-check"></i>
               Manage Orders
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.report.sales') }}"
               class="nav-link {{ request()->routeIs('admin.report.sales') ? 'active' : '' }}">
               <i class="bi bi-graph-up"></i>
               Sales Reports
            </a>
        </li>
    </ul>
</div>

