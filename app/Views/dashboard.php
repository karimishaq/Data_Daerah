<?= $this->extend('admin') ?>
<?=$this->section("isi")?>
    <div class="daftar_kartu">
        <div>
            <div class="icon_kartu"><i class="fa fa-map"></i></div>
            <div>
                <h3>Provinsi</h3>
                <p><?=$total['tprovinsi']?></p>
            </div>
        </div>
        <div>
            <div class="icon_kartu"><i class="fa fa-map"></i></div>
            <div>
                <h3>Kabupaten</h3>
                <p><?=$total['tkabupaten']?></p>
            </div>
        </div>
        <div>
            <div class="icon_kartu"><i class="fa fa-map"></i></div>
            <div>
                <h3>Kecamatan</h3>
                <p><?=$total['tkecamatan']?></p>
            </div>
        </div>
        <div>
            <div class="icon_kartu"><i class="fa fa-map"></i></div>
            <div>
                <h3>Desa</h3>
                <p><?=$total['tdesa']?></p>
            </div>
        </div>
    </div>
<?=$this->endSection()?>