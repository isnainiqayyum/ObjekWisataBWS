<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-4 font-lora">
    <div class="card shadow rounded p-4 mx-auto" style="max-width: 720px;">
        <h4 class="mb-4 text-center">Tambah Kriteria</h4>

        <!-- Menampilkan error jika bobot melebihi 1 -->
        <?php if (session()->getFlashdata('errors')): ?>
            <?php $errors = session()->getFlashdata('errors'); ?>
            <?php if (isset($errors['bobot'])): ?>
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <?= esc($errors['bobot']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/admin/kriteria/store" method="post">
            <?= csrf_field() ?>

            <!-- Form isiannya dari view partial -->
            <?= view('kriteria/form') ?>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
