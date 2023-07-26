<?= $this->extend('layout/tamplate'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row mt-2">
        <div class="col">
            <h2 mt-2>Detail Komik</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="img-fluid rounded-start" alt="<?= $komik['slug']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, asperiores itaque! Expedita unde itaque libero dicta ut facilis, deleniti eligendi minima at sit numquam fugiat, tenetur, eos laboriosam? Repellat, enim!</p>
                            <p class="card-text"><small class="text-body-secondary"><?= $komik['penulis']; ?> | <?= $komik['penerbit']; ?></small></p>
                            <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning ms-auto">Ubah</a>
                            <form action="/komik/<?= $komik['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/komik" class="btn btn-info ms-auto">Back</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>