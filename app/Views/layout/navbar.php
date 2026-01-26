<nav class="navbar navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">
        <button class="btn btn-outline-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
            <i class="bi bi-list"></i>
        </button>

        <a class="navbar-brand ms-2" href="<?= base_url('dashboard') ?>">
            <img src="<?= base_url('assets/img/' .($logo ?? 'pmpg-2026.png')) ?>" alt="<?= esc($systemName ?? 'Sistema') ?>" class="navbar-logo" >

        <div class="d-flex">
            <span class="text-white me-3 d-none d-md-inline">
                <?= session()->get('nome') ?>
            </span>
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</nav>