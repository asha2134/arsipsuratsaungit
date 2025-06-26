<aside class="sidebar">
    <div class="sidebar-content">
        <div class="brand">
            <div class="brand-title">E-ARSIP</div>
            <div class="brand-sub">SAUNG IT BUMIAYU</div>
        </div>

        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>

            <div class="section-title">DATA MASTER</div>
            <a href="surat_masuk.php" class="nav-item"><i class="fas fa-envelope"></i><span>Surat Masuk</span></a>
            <a href="surat_keluar.php" class="nav-item"><i class="fas fa-paper-plane"></i><span>Surat Keluar</span></a>
            <a href="user.php" class="nav-item"><i class="fas fa-users"></i><span>User</span></a>
            <a href="disposisi.php" class="nav-item"><i class="fas fa-random"></i><span>Disposisi</span></a>

            <div class="section-title">LAINNYA</div>
            <a href="about.php" class="nav-item"><i class="fas fa-info-circle"></i><span>Tentang Instansi</span></a>
        </nav>
    </div>

    <div class="collapse-btn">
        <button title="Collapse Sidebar"><i class="fas fa-angle-left"></i></button>
    </div>
</aside>

<script>
    const collapseBtn = document.querySelector('.collapse-btn button');
    const sidebar = document.querySelector('.sidebar');

    collapseBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        collapseBtn.querySelector('i').classList.toggle('fa-angle-left');
        collapseBtn.querySelector('i').classList.toggle('fa-angle-right');
    });
</script>