<div class="sidebar-wrapper" style="margin-top: 5px;">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/categories')) ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Categories</span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/inspirations')) ? 'active' : '' }}">
                    <a href="{{ route('admin.inspirations.index') }}">
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Inspirations</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>