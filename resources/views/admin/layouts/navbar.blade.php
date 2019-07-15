<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="d-none d-md-block navbar-brand border-right col-md-3 admin-company-name" href="{{route('main')}}">Clock Shop</a>
    <div class="col">
        <p class="admin-title text-light">{{isset($title) ? $title : "Aдмін-панель" }}</p>
    </div>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="{{route('logout')}}">Sign out</a>
        </li>
    </ul>
</nav>