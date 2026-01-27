<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h4><?= esc($title ?? 'Cadastro') ?></h4>
    <button class="btn btn-primary" onclick="openCreate()">
        <i class="bi bi-plus-circle"></i> Novo
    </button>
</div>

<table id="datatable" class="table table-striped table-bordered w-100"></table>

<?= view('crud/modal',['title' => $title,'fieldsView' => 'usuarios/fields']) ?>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    const endpoint = "<?= base_url($endpoint) ?>";

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: endpoint + '/datatable',
        columns: <?= json_encode($columns) ?>.concat([
            {
                data: null,
                title: 'Ações',
                orderable: false,
                render: row => `
                    <button class="btn btn-sm btn-warning" onclick="openEdit(${row.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="remover(${row.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                `
            }
        ]),
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json"
        }
    });
</script>
<?= $this->endSection() ?>
