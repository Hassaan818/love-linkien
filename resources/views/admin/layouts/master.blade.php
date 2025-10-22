<!doctype html>
<html lang="en" dir="ltr">
@include('admin.partials.head')

<body class="layout-light side-menu">
    <div class="mobile-search">
        <form action="/" class="search-form">
            <img src="{{ asset('img/svg/search.svg') }}" alt="search" class="svg">
            <input class="form-control me-sm-2 box-shadow-none" type="search" placeholder="Search..." aria-label="Search">
        </form>
    </div>
    <div class="mobile-author-actions"></div>
    @include('admin.partials.navbar')
    <main class="main-content">
        @include('admin.partials.sidebar')
        @yield('content')
        <!-- @include('admin.partials.footer') -->
    </main>
    @include('admin.partials.scripts')
    @yield('scripts')
</body>

</html>