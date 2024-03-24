<?=$this->extend("admin")?>
<?=$this->section("isi")?>
    <h2>Desa</h2>
    <p>
        <a href="<?=base_url('provinsi/0')?>">Indonesia</a> &gt;&gt;
        <a href="<?=base_url('kabupaten/'.$provinsi["id_provinsi"]."/0")?>"><?=$provinsi["nama"]?></a> &gt;&gt;
        <a href="<?=base_url('kecamatan/'.$provinsi["id_provinsi"].'/'.$kabupaten["id_kabupaten"]."/0")?>"><?=$kabupaten["nama_kabupaten"]?></a> &gt;&gt;
        <?=$kecamatan["nama_kecamatan"]?>
    </p>
    <button class='btn tombol' onclick="modal_show('modal_tambah', '<?=base_url('desa/tambah')?>')"><i class="fa fa-plus"></i> Tambah</button>
    <a href="<?=base_url("pdf/desa/".$kecamatan["id_kecamatan"])?>"><button class="btn tombol"><i class="fa fa-book"></i> PDF</button></a>
    <a href="<?=base_url("excel/desa/".$kecamatan["id_kecamatan"])?>"><button class="btn tombol"><i class="fa fa-list"></i> Excel</button></a>
    <br><br>
    <select name="" id="jtampil" onchange="jtampil('<?=base_url('desa/'.$provinsi['id_provinsi'].'/'.$kabupaten['id_kabupaten'].'/'.$kecamatan['id_kecamatan'].'/0/')?>')">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    
    <form id="form_table" action="<?=base_url('desa/batch_delete')?>" method="post">
        <table>
            <th>No</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th>Aksi</th>
            <?php
                $i=1;
                foreach($data as $dt){
                    echo("<tr>");
                    echo("<td><input type='checkbox' name='pilihan[]' value='".$dt['id_desa']."'>".$i."</td>");
                    echo("<td>".$dt['nama_desa']."</td>");
                    echo("<td>".$dt['keterangan']."</td>");
                    echo("<td>".
                    "<a href='".base_url("desa/form_ubah/".$dt['provinsi']."/".$dt['kabupaten']."/".$dt['kecamatan']."/".$dt['id_desa'])."'>
                    <div class='btn tombol' title='edit'><i class='fa fa-edit'></i></div></a> ".
                    "<div class='btn hapus' onclick='modal_show(\"modal_hapus\", \""
                    .base_url("desa/hapus/".$dt['id_desa']).
                    "\")'><i class='fa fa-trash'></i></div>".
                    "</td>");
                    echo("</tr>");
                    $i++;
                }
            ?>
        </table>
        <br>

        <input type="hidden" name="provinsi" value="<?=$provinsi['id_provinsi']?>">
        <input type="hidden" name="kabupaten" value="<?=$kabupaten['id_kabupaten']?>">
        <input type="hidden" name="kecamatan" value="<?=$kecamatan['id_kecamatan']?>">
        <input class="btn tombol" type="submit" Value="Batch Delete" style="display:none">
        <div class="btn tombol" onclick="modal_show('modal_batch_delete')">Batch Delete</div>
    </form>

    <div class="paginasi">
    <a href='<?=base_url("desa/0")?>'><button class='btn info'>Awal</button></a>
    <?php
        $jhalaman=intval(ceil($total["tdesa"]/$jtampil));
        
        $awal=0;
        $akhir=$jhalaman;
        if($halaman>2 && ($halaman+2)<$jhalaman){
            $awal=$halaman-2;
        }else if(($halaman+2)>=$jhalaman && $jhalaman>4){
            $awal=$jhalaman-5;
        }

        if($jhalaman>4){
            $akhir=$awal+5;
        }
        
        for($i=$awal;$i<$akhir;$i++){
            echo("<a href='".base_url("desa/".$provinsi["id_provinsi"]."/".$kabupaten["id_kabupaten"]."/".$kecamatan["id_kecamatan"]."/".$i."/".$jtampil)."'><button ");
            if($i!=$halaman)echo("class='btn tombol'>");
            else echo("class='btn hapus'>");
            echo(($i+1)."</button></a>");
        }
    ?>
    <a href='<?=base_url("desa/".($jhalaman-1))?>'><button class='btn info'>Akhir</button></a>
    </div>

    <br><br>

    <div class="modal" id="modal_tambah">
        <div onclick="modal_hide('modal_tambah')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
        </div>
        <div>
            <div class="modal_header">          
                <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_tambah')">X</button>
                <H2>Tambah</H2>
                <form action='<?=base_url("desa/tambah")?>' method="post">
            </div>
            
            <div class="modal_body">
                <input type="hidden" name="provinsi" value="<?=$provinsi['id_provinsi']?>">
                <input type="hidden" name="kabupaten" value="<?=$kabupaten['id_kabupaten']?>">
                <input type="hidden" name="kecamatan" value="<?=$kecamatan['id_kecamatan']?>">
                <label for="">Nama</label><br>
                <input type="text" name="nama"><br>
                <label for="">Keterangan</label><br>
                <input type="text" name="keterangan"><br><br>
            </div>

            <div class="modal_footer">
                    <input type="submit" class="btn tombol" value="Simpan">
                </form>
                <button class="btn tombol" onclick="modal_hide('modal_tambah')">Batal</button>
            </div>
        </div>
    </div>
<?=$this->endSection()?>