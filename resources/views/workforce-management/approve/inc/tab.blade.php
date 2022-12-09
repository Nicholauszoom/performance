<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('approve.changes') ? 'active' : null  }}" href="{{ route('approve.changes') }}">Changes</a>
</li>

<li class="nav-item">
    <a href="{{ route('approve.register') }}" class="nav-link {{ request()->routeIs('approve.register') ? 'active' : null  }}">Registration</a>
</li>
