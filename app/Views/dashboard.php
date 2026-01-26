<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h4 class="mb-4">Bem-vindo, <b><?= session()->get('nome') ?></b></h4>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-muted">Status</h6>
                <h4 class="fw-bold text-success">Ativo</h4>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
