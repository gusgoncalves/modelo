<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Sistema Prefeitura de Ponta Grossa') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .app-wrapper {
            flex: 1;
            display: flex;
            overflow: hidden;
        }
        .sidebar {
            width: 260px;
            min-height: 100%;
        }
        @media (max-width: 991px) {
            .sidebar {
                display: none;
            }
        }
        main {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }
        footer {
            height: 50px;
        }
        :root {
        --navbar-bg: #1988c3;
        }

        .navbar-custom {
            background-color: var(--navbar-bg) !important;
        }
        .navbar-logo {
            height: 36px;       /* tamanho ideal para navbar */
            width: auto;        /* mantém proporção */
            max-height: 40px;   /* segurança */
        }
    </style>
</head>
<body>
