<div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow" style="width: 280px; height:100vh">
    <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto pt-5 text-dark text-decoration-none">
        <span class="fs-4">Central Bank System</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link active" aria-current="page">
                    Dashboard
                </a>
            </li>
        @foreach ($sideNavItem as $item)
                @if ($item->action_id == 'view-member')
                    <li>
                        <a href="/member" class="nav-link text-dark">
                            Member
                        </a>
                    </li>
                @endif
                @if ($item->action_id == 'view-role')
                    <li>
                        <a href="/role" class="nav-link text-dark">
                            Role
                        </a>
                    </li>
                @endif
                @if ($item->action_id == 'view-user')
                    <li>
                        <a href="/user" class="nav-link text-dark">
                            User
                        </a>
                    </li>
                @endif
                @if ($item->action_id == 'view-transaction')
                    <li>
                        <a href="/transaction" class="nav-link text-dark">
                            Transaction
                        </a>
                    </li>
                @endif
                @if ($item->action_id == 'view-audit-trail')
                    <li>
                        <a href="/audit-trail" class="nav-link text-dark">
                            Audit Trail
                        </a>
                    </li>
                @endif
        @endforeach
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                class="rounded-circle me-2">
            <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-white text-small shadow">
            <li><a class="dropdown-item" href="#">Profile</li>
            <li><a class="dropdown-item" href="#">Setting</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form action="/sign-out" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">Sign Out</button>
                </form>
            </li>
        </ul>
    </div>
</div>
