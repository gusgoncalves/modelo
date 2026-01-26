<?= $this->extend('install/layout') ?>

<?= $this->section('content') ?>
<div class="text-center">
    <h2 class="text-success mb-3">
        <i class="bi bi-check-circle"></i>
    </h2>
    <h4>Instalação concluída!</h4>
    <p class="mt-3">O sistema está pronto para uso.</p>

    <a href="<?= base_url('auth/login') ?>" class="btn btn-primary mt-4">
        Ir para Login
    </a>
</div>
<?= $this->endSection() ?>
