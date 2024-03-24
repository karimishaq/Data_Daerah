<html>
    <head>
        <title>Tambah</title>
    </head>
    <body>
        <h2>Ubah</h2>
        <form action='<?=base_url("kecamatan/ubah")?>' method="post">        
            <input type="hidden" name="provinsi" value="<?=$data['provinsi']?>">
            <input type="hidden" name="kabupaten" value="<?=$data['kabupaten']?>">
            <input type="hidden" name="id" value="<?=$data['id_kecamatan']?>">
            <label for="">Nama</label><br>
            <input type="text" name="nama" value="<?=$data['nama_kecamatan']?>"><br>
            <label for="">Keterangan</label><br>
            <input type="text" name="keterangan" value="<?=$data['keterangan']?>"><br><br>
            <input type="submit" value="Simpan">
        </form>
    </body>
</html>