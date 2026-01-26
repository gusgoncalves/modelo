<?= view('layout/header', ['title' => 'Acesso ao Sistema']) ?>

<style>
    body {
        background-color: #ffffff;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .login-card {
        width: 100%;
        max-width: 360px;
        text-align: center;
    }

    .login-logo {
        max-width: 220px;
        margin-bottom: 30px;
    }

    .form-control {
        height: 48px;
        font-size: 15px;
    }

    .btn-login {
        height: 48px;
        font-size: 16px;
        font-weight: 500;
        background-color: #3b6df6;
        border: none;
    }

    .btn-login:hover {
        background-color: #3059c9;
    }

    .footer-logo {
        max-width: 160px;
        margin-top: 40px;
        opacity: 0.9;
    }
</style>

<div class="login-wrapper">

    <div class="login-card">

        <!-- LOGO DO SISTEMA -->
        <img src="<?= base_url('assets/img/' .($logo ?? 'pmpg-2026.png')) ?>" alt="<?= esc($systemName ?? 'Sistema') ?>" class="login-logo" >

        <!-- MENSAGEM DE ERRO -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="<?= base_url('auth/login') ?>" method="post">
            <div class="mb-3 text-start">
                <input type="text" name="login" class="form-control" placeholder="<?= $authDriver === 'ldap' ? 'Matrícula' : 'CPF' ?>" value="<?= old('login', session()->getFlashdata('login')) ?>" autofocus required>
            </div>
            <div class="mb-3 text-start">
                <input type="password" name="senha" class="form-control" placeholder="Senha" required >
            </div>
            <button type="submit" class="btn btn-login w-100 text-white">
                Acessar
            </button>
        </form>

        <!-- LOGO PREFEITURA -->
        <img 
            src="<?= base_url('assets/img/pmpg-2021.png') ?>" 
            alt="Prefeitura"
            class="footer-logo"
        >

    </div>
</div>

<?= view('layout/footer') ?>
