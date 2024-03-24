<?= $this->extend('admin') ?>
<?=$this->section("isi")?>
    <h2>Pengguna</h2>
    <button class="btn tombol" onclick="modal_show('modal_tambah', '<?=base_url('pengguna/tambah')?>')"><i class='fa fa-plus'></i> Tambah</button>&nbsp;
    <br><br>
    <table>
        <th>No.</th>
        <th>Username</th>
        <th>Foto</th>
        <th>Aksi</th>
        <?php
            $i=1;
            foreach($data as $dt){
                echo("<tr>");
                echo("<td>".$i."</td>");
                echo("<td>".$dt['username']."</td>");
                echo("<td>");
                if($dt['foto']!='')echo("<img style='height:64px;' src='".base_url("uploads/".$dt['foto'])."'>");
                echo("</td>");
                echo("<td>".
                "<div title='hapus' class='btn hapus' onclick='modal_show(\"modal_hapus\", \""
                .base_url("pengguna/hapus/".$dt['id_pengguna']).
                "\")'><i class='fa fa-trash'></i></div>".
                "<div class='btn tombol' title='upload' onclick='modal_show(\"modal_upload\", \""
                .base_url("pengguna/upload/".$dt['id_pengguna']).
                "\")'><i class='fa fa-upload'></i></div>".
                "</td>");
                echo("</tr>");
                $i++;
            }
        ?>
    </table>
    <div class="modal" id="modal_tambah">
        <div onclick="modal_hide('modal_tambah')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
        </div>
        <div>
            <div class="modal_header">
                <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_tambah')">X</button>
                <H2>Tambah</H2>
                <form action='<?=base_url("pengguna/tambah")?>' method="post">
            </div>
            
            <div class="modal_body">
                    <label for="">Nama</label><br>
                    <input type="text" name="nama"><br>
                    <label for="">Password</label><br>
                    <input type="text" name="password"><br><br>
            </div>

            <div class="modal_footer">
                    <input type="submit" class="btn tombol" value="Simpan">
                </form>
                <button class="btn tombol" onclick="modal_hide('modal_tambah')">Batal</button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal_upload">
        <div onclick="modal_hide('modal_upload')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
        </div>
        <div>
            <div class="modal_header">
                <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_upload')">X</button>
                <H2>Foto</H2>
                <form action='#' method="post" enctype='multipart/form-data'>
            </div>
            
            <div class="modal_body">
                    <input type="file" name="foto"><br><br>
            </div>

            <div class="modal_footer">
                    <input type="submit" class="btn tombol" value="Upload">
                </form>
                <button class="btn tombol" onclick="modal_hide('modal_upload')">Batal</button>
            </div>
        </div>
    </div>
<?=$this->endSection()?>