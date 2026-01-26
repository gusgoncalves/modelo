<?= $this->extend('install/layout') ?>

<?= $this->section('content') ?>
<h3 class="mb-4">
    <i class="bi bi-person-lock"></i> Usuário Administrador
</h3>

<?php $authDriver = session('auth_driver'); ?>

<form method="post" action="<?= base_url('install/admin') ?>">

    <input class="form-control mb-3" name="matricula" placeholder="Matrícula" required>
    <input class="form-control mb-3" name="cpf" placeholder="CPF" required>
    <input type="text" class="form-control mb-4" name="nome" placeholder="Nome" required>

    <input type="email" class="form-control mb-4" name="email" placeholder="Email" required>

    <?php if ($authDriver === 'database'): ?>
        <input type="password" name="senha" class="form-control mb-4" placeholder="Senha" required>
    <?php endif; ?>

    <input type="hidden" name="permissao" value="admin">

    <button class="btn btn-success w-100">
        Finalizar Instalação
    </button>
</form>

<?= $this->endSection() ?>
