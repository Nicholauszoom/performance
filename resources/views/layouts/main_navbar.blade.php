
<div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static" style="background:#001949;">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>

        <button data-target="#navbar-search" type="button" class="navbar-toggler" data-toggle="collapse">
            <i class="icon-search4"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">

    </div>

    <div class="navbar-collapse collapse flex-lg-1 mx-lg-3 order-2 order-lg-1" id="navbar-search">
        <div class="navbar-search d-flex align-items-center py-2 py-lg-0">
            <div class="form-group-feedback form-group-feedback-left flex-grow-1">
                <input type="text" class="form-control" placeholder="Search">
                <div class="form-control-feedback">
                    <i class="icon-search4 text-white opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center flex-1 flex-lg-0 order-1 order-lg-2">
        <ul class="navbar-nav flex-row">
            <li class="nav-item">
            <a href="{{ route('logout') }}"   class="navbar-nav-link navbar-nav-link-toggler"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="icon-switch2"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </li>
        </ul>
    </div>
</div>
