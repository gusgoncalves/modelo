<?= $this->extend('install/layout') ?>

<?= $this->section('content') ?>
<h3 class="mb-4">
    <i class="bi bi-gear"></i> Configuração do Sistema
</h3>

<form method="post" action="<?= base_url('install/system') ?>" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Nome do Sistema</label>
        <input type="text" name="system_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Logo para Layout</label>
        <input type="file" name="system_logo" class="form-control" accept="image/*" required>
    </div>

    <div class="mb-4">
        <label class="form-label">Base URL</label>
        <input type="text" name="base_url" class="form-control" value="<?= base_url() ?>" required>
    </div>
    <div class="mb-4">
        <select class="form-control" name="auth_driver" class="form-control" required>
            <option value="ldap">LDAP (Rede)</option>
            <option value="database">Usuário e senha (Banco)</option>
        </select>
    </div>

    <button class="btn btn-primary w-100">
        Próximo <i class="bi bi-arrow-right"></i>
    </button>
</form>
<?= $this->endSection() ?>
