<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Kecamatan extends BaseController
{
    public function index($provinsi=0, $kabupaten=0, $hlm=0, $jtampil=100)
    {
        //
        $sesi=session();
        if(!$sesi->has("login"))return redirect()->to("/admin");
        else $var["foto"]="uploads/".$sesi->login["foto"];
        
        $db=db_connect();
        $mprovinsi=model('mprovinsi');
        $mkabupaten=model('mkabupaten');
        $modelku=model('mkecamatan');
        $data=$db->query("Select kecamatan.*,
        (select count(desa.provinsi) from desa where kecamatan.id_kecamatan=desa.kecamatan)
        AS desa FROM kecamatan where kabupaten=".$kabupaten." limit ".($hlm*10).", ".$jtampil);
        $var["data"]=$data->getResultArray();

        $var["total"]=$db->query("Select (SELECT count(*) from kecamatan where kabupaten=".$kabupaten.") AS tkecamatan, (SELECT count(*) from desa where kabupaten=".$kabupaten.") AS tdesa")->getRowArray();
        $var["jtampil"]=$jtampil;
        $var["halaman"]=$hlm;

        $var["provinsi"]=$mprovinsi->find($provinsi);
        $var["kabupaten"]=$mkabupaten->find($kabupaten);
        
        return view("kecamatan/index", $var);
    }

    public function hapus($id)
    {
        //
        db_connect();
        $modelku=model('mkecamatan');
        $data=$modelku->find($id);
        $modelku->delete($id);
        return redirect()->to(base_url("kecamatan/".$data["provinsi"]."/".$data["kabupaten"]."/0"));
    }

    public function tambah()
    {
        //
        db_connect();
        $modelku=model('mkecamatan');
        $provinsi=$this->request->getVar("provinsi");
        $kabupaten=$this->request->getVar("kabupaten");
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[
            "nama_kecamatan" => $nama,
            "keterangan" => $keterangan,
            "provinsi" => $provinsi,
            "kabupaten" => $kabupaten
        ];
        $modelku->insert($a);
        return redirect()->to("kecamatan/".$provinsi."/".$kabupaten."/0");
    }

    public function form_ubah($provinsi, $kabupaten, $id)
    {
        $modelku=model('mkecamatan');
        $var["data"]=$modelku->find($id);
        return view("kecamatan/form_ubah", $var);
    }

    public function ubah()
    {
        //
        db_connect();
        $modelku=model('mkecamatan');
        $provinsi=$this->request->getVar("provinsi");
        $kabupaten=$this->request->getVar("kabupaten");
        $id=$this->request->getVar("id");
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[    
            "nama_kecamatan" => $nama,
            "keterangan" => $keterangan
        ];
        $modelku->update($id, $a);
        return redirect()->to("kecamatan/".$provinsi."/".$kabupaten."/0");
    }

    public function batch_add($provinsi=0, $kabupaten=0)
    {
        //
        db_connect();
        $modelku=model('mkecamatan');
        $temp=preg_split('/\r\n|[\r\n]/', $this->request->getVar("nama"));

        $a=[];
        foreach($temp as $dt){
            if($dt!=""){
                array_push($a, [
                    "nama_kecamatan" => ucwords(strtolower($dt)),
                    "keterangan" => "",
                    "provinsi" => $provinsi,
                    "kabupaten" => $kabupaten
                ]);
            }
        }
        $modelku->insertBatch($a);
        return redirect()->to("kecamatan/".$provinsi."/".$kabupaten."/0");
    }
}
