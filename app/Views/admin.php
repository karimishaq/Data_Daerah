<html>
    <head>
        <title>Coba</title>
        <link href="<?=base_url("css/styleku.css")?>" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url('font-awesome/css/font-awesome.min.css')?>">
    </head>
    <body>
        <div class="kontainer">
            <div id="logo">
                <img src="<?=base_url('logo.jpg')?>" alt="logo" style="width:100%;height:100%">
            </div>
            <div id="menu">
                <div id="dropdown_menu">
                    <img src="<?=($foto!='')?base_url($foto):base_url('profil_kosong.jpg')?>" alt="profil" onclick="toggle_menu()">
                    <div>
                        <ul>
                            <li><a href="<?=base_url('')?>">Home</a></li>            
                            <li><a href="<?=base_url('logout')?>">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="sidebar">            
                <ul>                
                    <li><a href="<?=base_url('/admin')?>"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a></li>
                    <li><a href="<?=base_url('/pengguna')?>"><i class="fa fa-users"></i>&nbsp;Pengguna</a></li>
                    <li><a href="<?=base_url('/provinsi/0')?>"><i class="fa fa-book"></i>&nbsp;Data Daerah</a></li>
                </ul>
            </div>
            <div id="isi">
                <?=$this->renderSection("isi")?>
                <div class="modal" id="modal_batch_add">
                    <div onclick="modal_hide('modal_batch_add')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
                    </div>
                    <div>
                        <div class="modal_header">          
                            <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_batch_add')">X</button>
                            <H2>Hapus</H2>
                            <form action='<?=base_url("")?>' method="post">
                        </div>
                        
                        <div class="modal_body">
                            <label for="">Nama</label><br>
                            <textarea name="nama" id="nama" cols="100" rows="20"></textarea><br>
                        </div>

                        <div class="modal_footer">
                                <input type="submit" class="btn tombol" value="Simpan">
                                <div class="btn tombol" onclick="modal_hide('modal_batch_add')">Batal</div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal" id="modal_hapus">
                    <div onclick="modal_hide('modal_hapus')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
                    </div>
                    <div>
                        <div class="modal_header">          
                            <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_hapus')">X</button>
                            <H2>Hapus</H2>
                        </div>
                        
                        <div class="modal_body">
                            <p>Hapus</p>
                        </div>

                        <div class="modal_footer">
                            <button class="btn tombol" onclick="hapus()">Hapus</button>
                            <button class="btn tombol" onclick="modal_hide('modal_hapus')">Batal</button>
                        </div>
                    </div>
                </div>
                <div class="modal" id="modal_batch_delete">
                    <div onclick="modal_hide('modal_batch_delete')" style="background-color:RGBA(128, 128, 128, 0.25);position:absolute;z-index:-1;width:100%;height:100%">
                    </div>
                    <div>
                        <div class="modal_header">          
                            <button class="btn hapus" id="modal_tutup" onclick="modal_hide('modal_batch_delete')">X</button>
                            <H2>Hapus</H2>
                        </div>
                        
                        <div class="modal_body">
                            <p>Hapus Pilihan?</p>
                        </div>

                        <div class="modal_footer">
                            <button class="btn tombol" onclick="batch_delete()">Hapus</button>
                            <button class="btn tombol" onclick="modal_hide('modal_batch_delete')">Batal</button>
                        </div>
                    </div>
                </div>
                <script>
                    var id="";
                    const checkboxes = document.querySelectorAll( 'table input[type="checkbox"]' );
                    let lastChecked;

                    function jtampil(alamat){
                        var jtampil=document.getElementById("jtampil");
                        window.location.href=alamat+jtampil.value;
                    }

                    function batch_delete(){
                        var formku=document.getElementById('form_table');
                        if(formku)formku.submit();
                    }
                    
                    function hapus(){
                        window.location.href=id;
                    }

                    function modal_show(nmodal, data){
                        var formku=document.querySelector("#"+nmodal+" form");
                        var modal=document.getElementById(nmodal);
                        modal.style.display="flex";
                        id=data;

                        if(formku)formku.action=data;
                    }

                    function modal_hide(nmodal){
                        var modal=document.getElementById(nmodal);
                        modal.style.display="none";
                    }

                    function toggle_menu(){
                        var menuku=document.querySelector("#dropdown_menu > div");
                        if(menuku.style.display!="flex")menuku.style.display="flex";
                        else menuku.style.display="none";
                    }

                    //checkbox
                    function handleCheck( e ) {
                        let inBetween =  false;
                        if( e.shiftKey & this!=lastChecked) {
                            checkboxes.forEach( checkbox => {
                                if( checkbox === this || checkbox === lastChecked ) {
                                    inBetween = !inBetween;
                                }
                                if( inBetween ) {
                                    checkbox.checked = lastChecked.checked;
                                }
                            });
                        }
                        lastChecked = this;
                    };

                    checkboxes.forEach( checkbox => checkbox.addEventListener( 'click', handleCheck ) );
                </script>
            </div>
        </div>
    </body>
</html>
