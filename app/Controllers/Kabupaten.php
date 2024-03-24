<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Kabupaten extends BaseController
{
    public function index($provinsi=0, $hlm=0, $jtampil=100)
    {
        //
        $sesi=session();
        if(!$sesi->has("login"))return redirect()->to("/admin");
        else $var["foto"]='uploads/'.$sesi->login["foto"];
        
        $db=db_connect();
        $mprovinsi=model('mprovinsi');
        $modelku=model('mkabupaten');
        $data=$db->query("Select kabupaten.*, 
        (select count(kecamatan.provinsi) from kecamatan where kabupaten.id_kabupaten=kecamatan.kabupaten)
        AS kecamatan,
        (select count(desa.provinsi) from desa where kabupaten.id_kabupaten=desa.kabupaten)
        AS desa FROM kabupaten where provinsi=".$provinsi." limit ".($hlm*10).", ".$jtampil);
        $var["data"]=$data->getResultArray();

        $data=$db->query("select (SELECT count(*) from kabupaten where provinsi=".$provinsi.") AS tkabupaten, (SELECT count(*) from kecamatan where provinsi=".$provinsi.") AS tkecamatan, (SELECT count(*) from desa where provinsi=".$provinsi.") AS tdesa");
        $var["total"]=$data->getRowArray();
        $var["jtampil"]=$jtampil;
        $var["halaman"]=$hlm;

        $var["provinsi"]=$mprovinsi->find($provinsi);
        return view("kabupaten/index", $var);
    }

    public function hapus($id)
    {
        //
        db_connect();
        $modelku=model('mkabupaten');
        $data=$modelku->find($id);
        $modelku->delete($id);
        return redirect()->to(base_url("kabupaten/".$data["provinsi"]."/0"));
    }

    public function tambah()
    {
        //
        db_connect();
        $modelku=model('mkabupaten');
        $provinsi=$this->request->getVar("provinsi");
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[    
            "nama_kabupaten" => $nama,
            "keterangan" => $keterangan,
            "provinsi" => $provinsi
        ];
        $modelku->insert($a);
        return redirect()->to("kabupaten/".$provinsi."/0");
    }

    public function form_ubah($provinsi, $id)
    {
        $modelku=model('mkabupaten');
        $var["data"]=$modelku->find($id);
        return view("kabupaten/form_ubah", $var);
    }

    public function ubah()
    {
        //
        db_connect();
        $modelku=model('mkabupaten');
        $provinsi=$this->request->getVar("provinsi");
        $id=$this->request->getVar("id");
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[    
            "nama_kabupaten" => $nama,
            "keterangan" => $keterangan
        ];
        $modelku->update($id, $a);
        return redirect()->to("kabupaten/".$provinsi."/0");
    }

    public function batch_add($provinsi=0)
    {
        //
        db_connect();
        $modelku=model('mkabupaten');
        $temp=preg_split('/\r\n|[\r\n]/', $this->request->getVar("nama"));

        $a=[];
        foreach($temp as $dt){
            if($dt!=""){
                array_push($a, [
                    "nama_kabupaten" => ucwords(strtolower($dt)),
                    "keterangan" => "",
                    "provinsi" => $provinsi
                ]);
            }
        }
        $modelku->insertBatch($a);
        return redirect()->to("kabupaten/".$provinsi."/0");
    }
}
