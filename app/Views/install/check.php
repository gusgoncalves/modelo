<?= $this->extend('install/layout') ?>

<?= $this->section('content') ?>

<h3 class="mb-4">
    <i class="bi bi-shield-check"></i> Verificação do Servidor
</h3>

<p class="text-muted">
    Antes de instalar, vamos garantir que o servidor não vai te trair no meio do caminho.
</p>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Item</th>
            <th>Status</th>
            <th>Detalhe</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($checks as $c): ?>
            <tr>
                <td><?= esc($c['label']) ?></td>
                <td style="width:120px;">
                    <?php if ($c['ok']): ?>
                        <span class="badge bg-success">OK</span>
                    <?php else: ?>
                        <span class="badge bg-danger">FALHOU</span>
                    <?php endif; ?>
                </td>
                <td><?= esc($c['value']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($allOk && $canInstall): ?>
    <div class="alert alert-success">
        Tudo certo até então. Pode continuar.
    </div>
    <a href="<?= base_url('install') ?>" class="btn btn-success w-100">
        Continuar Instalação
    </a>
<?php else: ?>
    <div class="alert alert-warning">
        Tem item obrigatório faltando. </br>
        <strong>Atenção:</strong> Se você ativar as extensões no <code>php.ini</code>,
        não se esqueça que precisa <strong>reiniciar o servidor também</strong>:
        <pre class="mb-0">CTRL + C
        php spark serve</pre>
    </div>

    <a href="<?= base_url('install/check') ?>" class="btn btn-secondary w-100">
        Revalidar
    </a>
<?php endif; ?>

<?= $this->endSection() ?>
