<html>
    <head>
        <title>Tambah</title>
    </head>
    <body>
        <h2>Tambah</h2>
        <form action='<?=base_url("provinsi/ubah")?>' method="post">
            <input type="hidden" name="id" value="<?=$data['id_provinsi']?>">
            <label for="">Nama</label><br>
            <input type="text" name="nama" value="<?=$data['nama']?>"><br>
            <label for="">Ibukota</label><br>
            <input type="text" name="ibukota" value="<?=$data['ibukota']?>"><br>
            <label for="">Keterangan</label><br>
            <input type="text" name="keterangan" value="<?=$data['keterangan']?>"><br><br>
            <input type="submit" value="Simpan">
        </form>
    </body>
</html>