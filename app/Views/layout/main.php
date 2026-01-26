<?= view('layout/header') ?>
<?= view('layout/navbar') ?>

<div class="app-wrapper pt-5">
    <?= view('layout/sidebar') ?>

    <main>
        <?= $this->renderSection('content') ?>
    </main>
</div>

<?= view('layout/footer') ?>
