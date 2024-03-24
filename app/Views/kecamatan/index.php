<?=$this->extend("admin")?>
<?=$this->section("isi")?>
    <h2>Kecamatan <?=$kabupaten["nama_kabupaten"]?></h2>
    <p>
        <a href="<?=base_url('/provinsi/0')?>">Indonesia</a> &gt;&gt;
        <a href="<?=base_url('kabupaten/'.$provinsi["id_provinsi"]."/0")?>"><?=$provinsi["nama"]?></a> &gt;&gt;
        <?=$kabupaten["nama_kabupaten"]?>
    </p>
    <button class='btn tombol' onclick="modal_show('modal_tambah', '<?=base_url('kecamatan/tambah')?>')"><i class="fa fa-plus"></i>Tambah</button>
    <a href="<?=base_url("pdf/kecamatan/".$kabupaten["id_kabupaten"])?>"><button class="btn tombol"><i class="fa fa-book"></i> PDF</button></a>
    <a href="<?=base_url("excel/kecamatan/".$kabupaten["id_kabupaten"])?>"><button class="btn tombol"><i class="fa fa-list"></i> Excel</button></a>
    <button class='btn tombol' onclick="modal_show('modal_batch_add', '<?=base_url('kecamatan/batch_add/'.$provinsi['id_provinsi'].'/'.$kabupaten['id_kabupaten'])?>')">Batch</button>
    <br><br>
    <select name="" id="jtampil" onchange="jtampil('<?=base_url('kecamatan/'.$provinsi['id_provinsi'].'/'.$kabupaten['id_kabupaten'].'/0/')?>')">
        <?php
            $a=[10, 25, 50, 100];
            foreach($a as $s){
                echo("<option value='".$s."'");
                if($s==$jtampil)echo(" selected");
                echo(">".$s."</option>");
            }
        ?>
    </select>
    <table>
        <th>No.</th>
        <th>Nama</th>
        <th>Desa atau Kelurahan</th>
        <th>Aksi</th>
        <?php
            $i=1;
            foreach($data as $dt){
                echo("<tr>");
                echo("<td>".$i."</td>");
                echo("<td><a href='".base_url("/desa/".$dt['provinsi']."/".$dt['kabupaten']."/".$dt['id_kecamatan'])."/0'>".$dt['nama_kecamatan']."</a></td>");
                echo("<td>".$dt['desa']."</td>");
                echo("<td>".
                "<a href='".base_url("kecamatan/form_ubah/".$dt['provinsi']."/".$dt['kabupaten']."/".$dt['id_kecamatan'])."'>
                <button class='btn tombol'><i class='fa fa-edit'></i></button></a> ".
                "<button  class='btn hapus' onclick='modal_show(\"modal_hapus\", \""
                .base_url("kecamatan/hapus/".$dt['id_kecamatan']).
                "\")'><i class='fa fa-trash'></i></button>".
                "</td>");
                echo("</tr>");
                $i++;
            }

            if(isset($total)){
                echo("<tr>");
                echo("<td></td><td><b>Total</b></td>");
                echo("<td>".$total["tdesa"]."</td>");
                echo("</tr>");
            }
        ?>
    </table>
    <br>

    <div class="paginasi">
    <a href='<?=base_url("kecamatan/0")?>'><button class='btn info'>Awal</button></a>
    <?php
        $jhalaman=intval(ceil($total["tkecamatan"]/$jtampil));
        
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
            echo("<a href='".base_url("kecamatan/".$provinsi["id_provinsi"]."/".$kabupaten["id_kabupaten"]."/".$i)."'><button ");
            if($i!=$halaman)echo("class='btn tombol'>");
            else echo("class='btn hapus'>");
            echo(($i+1)."</button></a>");
        }
    ?>
    <a href='<?=base_url("kecamatan/".($jhalaman-1))?>'><button class='btn info'>Akhir</button></a>
    </div>
    
    <div class="modal" id="modal_tambah">
        <div onclick="modal_hide('modal_tambah')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
        </div>
        <div>
            <div class="modal_header">          
                <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_tambah')">X</button>
                <H2>Tambah</H2>
                <form action='<?=base_url("kecamatan/tambah")?>' method="post">
            </div>
            
            <div class="modal_body">
                <input type="hidden" name="provinsi" value="<?=$provinsi['id_provinsi']?>">
                <input type="hidden" name="kabupaten" value="<?=$kabupaten['id_kabupaten']?>">
                <label for="">Nama</label><br>
                <input type="text" name="nama"><br>
                <label for="">Keterangan</label><br>
                <input type="text" name="keterangan">
            </div>

            <div class="modal_footer">
                    <input type="submit" class="btn tombol" value="Simpan">
                </form>
                <button class="btn tombol" onclick="modal_hide('modal_tambah')">Batal</button>
            </div>
        </div>
    </div>
<?=$this->endSection()?>