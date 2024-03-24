<?=$this->extend("admin")?>
<?=$this->section("isi")?>
        <h2>Tambah Kecamatan</h2>
        <form action='<?=base_url("kecamatan/batch")?>' method="post">
            <input type="hidden" name="provinsi" value="<?=$provinsi?>">
            <input type="hidden" name="kabupaten" value="<?=$kabupaten?>">
            <label for="">Nama</label><br>
            <textArea name="nama" id="nama" cols="128" rows="25"></textArea><br>
            <input class="btn tombol" type="submit" value="Simpan">
        </form>
<?=$this->endSection()?>