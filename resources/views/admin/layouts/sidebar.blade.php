<nav id="admin-sidebar" class="col-md-3 bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-arrow-right"></i>
                    Статус
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/clocks">
                    <i class="fas fa-arrow-right"></i>
                    Список годинників
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/clocks/create">
                    <i class="fas fa-arrow-right"></i>
                    Додати новий годинник
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('orders.index')}}">
                    <i class="fas fa-arrow-right"></i>
                    Нові замовлення
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('oldOrders')}}">
                    <i class="fas fa-arrow-right"></i>
                    Старі замовлення
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('feedbacks.index')}}">
                    <i class="fas fa-arrow-right"></i>
                    Зворотній зв'язок
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('articles.index')}}">
                    <i class="fas fa-arrow-right"></i>
                    Список статтей
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('articles.create')}}">
                    <i class="fas fa-arrow-right"></i>
                    Додати нову статтю
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-arrow-right"></i>
                    Ще щось
                </a>
            </li>
        </ul>
    </div>
    <div class="border-bottom d-md-none"></div>
</nav>
