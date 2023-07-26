<?= $this->extend('layout/tamplate'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <form action="<?= base_url('komik/save'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <h1>Form Tambah Data Komik</h1>
                <!-- debug errors -->
                <?php
                //echo strlen(strip_tags(validation_show_error('judul')))
                if (session()->getFlashdata('cekList')) {
                    $set = 'is-valid';
                } else {
                    $set = '';
                }
                ?>
                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (strlen(strip_tags(validation_show_error('judul')))) ? 'is-invalid' : $set; ?>" id="judul" name="judul" autofocus value="<?= old('judul'); ?>">
                        <div id="judulFeedback" class="invalid-feedback">
                            <?= validation_show_error('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control  <?= (strlen(strip_tags(validation_show_error('penulis')))) ? 'is-invalid' : $set; ?>" id="penulis" name="penulis" value="<?= old('penulis'); ?>">
                        <div id="penulisFeedback" class="invalid-feedback">
                            <?= validation_show_error('penulis'); ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (strlen(strip_tags(validation_show_error('penerbit')))) ? 'is-invalid' : $set; ?>" id="penerbit" name="penerbit" value="<?= old('penerbit'); ?>">
                        <div id="penerbitFeedback" class="invalid-feedback">
                            <?= validation_show_error('penerbit'); ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-2">
                        <img src="/img/default.jpg" class="img-thumbnail img-preview">

                        <label class="custom-file-label"></label>
                    </div>
                    <div class="col-sm-8">
                        <input type="file" name="sampul" id="sampul" class="form-control <?= (strlen(strip_tags(validation_show_error('sampul')))) ? 'is-invalid' : $set; ?>" aria-label="file example" onchange="previewImg()">
                        <div id="sampulFeedback" class="invalid-feedback">
                            <?= validation_show_error('sampul'); ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" value="Tambah Data">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>