{{-- @if (Request::is('admin/dashboard') OR Request::is('petugas/dashboard')) --}}
<nav class="navbar w-100">
    <div class="flex flex-between align-center w-100">
        {{-- <input type="text" name="search" id="" class="input-text" placeholder="Search anything"> --}}
        <h2 id="btnSidebar"><i class="ri-menu-line"></i></h2>
        <a href="" class="profile"><i class="ri-user-line"></i></a>
    </div>
</nav>
{{-- @else
@endif --}}
