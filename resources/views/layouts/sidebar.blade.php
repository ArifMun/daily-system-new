<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('dashboard') }}" class="sidebar-link">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->is('daily-expenses*') ? 'active' : '' }}">
            <a href="{{ url('daily-expenses') }}" class="sidebar-link">
                <i class="bi bi-basket-fill"></i>
                <span>Pengeluaran</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->is('salaries*') ? 'active' : '' }}">
            <a href="{{ url('salaries') }}" class="sidebar-link">
                <i class="bi bi-cash-coin"></i>
                <span>Pemasukan</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->is('salary-saving*') ? 'active' : '' }}">
            <a href="{{ url('salary-saving') }}" class="sidebar-link">
                <i class="bi bi-bank"></i>
                <span>Tabungan</span>
            </a>
        </li>


        {{-- <li class="sidebar-item">
            <a href="https://zuramai.github.io/mazer/docs" class="sidebar-link">
                <i class="bi bi-life-preserver"></i>
                <span>Documentation</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="https://github.com/zuramai/mazer/blob/main/CONTRIBUTING.md" class="sidebar-link">
                <i class="bi bi-puzzle"></i>
                <span>Contribute</span>
            </a>
        </li> --}}

        <li class="sidebar-item">
            <a href="#" class="sidebar-link" id="sidebar-logout">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>

        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('sidebar-logout').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Sesi Anda akan diakhiri.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('sidebar-logout-form').submit();
            }
        });
    });
</script>
