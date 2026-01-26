<?= $this->extend('install/layout') ?>

<?= $this->section('content') ?>
<h3 class="mb-4">
    <i class="bi bi-database"></i> Banco de Dados
</h3>

<form method="post" action="<?= base_url('install/database') ?>">
    <input class="form-control mb-3" name="db_host" placeholder="Host" required>
    <input class="form-control mb-3" name="db_name" placeholder="Banco" required>
    <input class="form-control mb-3" name="db_user" placeholder="Usuário" required>
    <input class="form-control mb-3" name="db_pass" placeholder="Senha">
    <!-- <input class="form-control mb-4" name="db_driver" value="MySQLi"> -->
     <select class="form-control mb-3" name="db_driver">
        <option value="MySQLi">MySQL</option>
        <option value="Postgre">PostgreSQL</option>
    </select>

    <button class="btn btn-primary w-100">
        Próximo <i class="bi bi-arrow-right"></i>
    </button>
</form>
<?= $this->endSection() ?>
