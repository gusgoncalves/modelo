<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Instalação do Sistema' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1988c3, #0d6efd);
            min-height: 100vh;
        }
        .install-card {
            border-radius: 16px;
            overflow: hidden;
        }
        .install-left {
            background: #f8f9fa;
            padding: 40px;
        }
        .install-right {
            background: #1988c3;
            color: #fff;
            padding: 40px;
            text-align: center;
        }
        .install-right img {
            max-width: 220px;
            margin-bottom: 20px;
        }
        .step-indicator span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 4px;
            border-radius: 50%;
            background: rgba(255,255,255,.4);
        }
        .step-indicator .active {
            background: #fff;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card install-card shadow-lg w-100" style="max-width: 900px;">
        <div class="row g-0">

            <!-- COLUNA ESQUERDA -->
            <div class="col-md-7 install-left">
                <?= $this->renderSection('content') ?>
            </div>

            <!-- COLUNA DIREITA -->
            <div class="col-md-5 install-right d-none d-md-flex flex-column justify-content-center">
                <img src="<?= base_url('assets/img/' . ($logo ?? 'logo-pmpg-branco.svg')) ?>" alt="Logo">
                <h4><?= $systemName ?? 'Sistema Municipal' ?></h4>
                <p class="opacity-75 mt-2">
                    Assistente de instalação e configuração inicial
                </p>

                <div class="step-indicator mt-4">
                    <span class="<?= ($step ?? 1) == 1 ? 'active' : '' ?>"></span>
                    <span class="<?= ($step ?? 1) == 2 ? 'active' : '' ?>"></span>
                    <span class="<?= ($step ?? 1) == 3 ? 'active' : '' ?>"></span>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
