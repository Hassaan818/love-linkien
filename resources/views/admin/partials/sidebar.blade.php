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
                <li class="{{ (request()->is('admin/venues')) ? 'active' : '' }}">
                    <a href="{{ route('admin.venues.index') }}">
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Venues</span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/meetings')) ? 'active' : '' }}">
                    <a href="{{ route('admin.meetings.index') }}">
                        <span class="nav-icon uil uil-create-dashboard"></span>
                        <span class="menu-text">Meetings</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>