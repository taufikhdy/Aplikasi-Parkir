<div class="sidebar w-15 bg-primary-500 flex flex-between flex-column pb-20" id="sidebar">
    <div class="">
        <div class="title">
            <h1>Parkeasy</h1>
            <h2 id="btnClose"><i class="ri-close-line"></i></h2>
        </div>
        <div class="link">
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}"><i
                        class="ri-dashboard-line"></i> Dashboard</a>
                <a href="{{ route('admin.users') }}" class="{{ Request::is('admin/users') ? 'active' : '' }}"><i
                        class="ri-group-line"></i> Users</a>
                <a href="" class="{{ Request::is('admin/log*') ? 'active' : '' }}"><i class="ri-flag-2-line"></i>
                    Aktivitas</a>
            @elseif (Auth::user()->role === 'petugas')
                <a href="{{ route('petugas.dashboard') }}"
                    class="{{ Request::is('petugas/dashboard*') ? 'active' : '' }}"><i class="ri-dashboard-line"></i>
                    Dashboard</a>
            @elseif (Auth::user()->role === 'owner')
            @endif
        </div>
    </div>
    <div class="link">
        {{-- <a href="" class="logout"><i class="ri-logout-box-line"></i> Logout</a> --}}
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="logout"><i class="ri-logout-box-line"></i> Logout</button>
        </form>
    </div>
</div>
