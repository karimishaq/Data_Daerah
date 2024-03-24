<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Provinsi extends BaseController
{
    public function index($hlm=0, $jtampil=100)
    {
        //
        $sesi=session();
        if(!$sesi->has("login"))return redirect()->to("/admin");
        else $var["foto"]='uploads/'.$sesi->login["foto"];

        $db=db_connect();
        $data=$db->query("Select provinsi.*, 
        (select count(kabupaten.provinsi) from kabupaten where provinsi.id_provinsi=kabupaten.provinsi) AS kabupaten, 
        (select count(kecamatan.provinsi) from kecamatan where provinsi.id_provinsi=kecamatan.provinsi)
        AS kecamatan,
        (select count(desa.provinsi) from desa where provinsi.id_provinsi=desa.provinsi)
        AS desa
        FROM provinsi limit ".($hlm*$jtampil).", ".$jtampil);
        $var["data"]=$data->getResultArray();

        $data=$db->query("select (SELECT count(*) from provinsi) AS tprovinsi, (SELECT count(*) from kabupaten) AS tkabupaten, (SELECT count(*) from kecamatan) AS tkecamatan, (SELECT count(*) from desa) AS tdesa");
        $var["total"]=$data->getRowArray();
        $var["jtampil"]=$jtampil;
        $var["halaman"]=$hlm;

        return view("provinsi/index", $var);
    }

    public function hapus($id)
    {
        //
        db_connect();
        $modelku=model('mprovinsi');
        $modelku->delete($id);
        return redirect()->to("provinsi/0");
    }

    public function tambah()
    {
        //
        db_connect();
        $modelku=model('mprovinsi');
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[    
            "nama" => $nama,
            "keterangan" => $keterangan
        ];
        $modelku->insert($a);
        return redirect()->to("provinsi/0");
    }

    public function form_ubah()
    {
        $id=$this->request->getVar("id");
        $modelku=model('mprovinsi');
        $var["data"]=$modelku->find($id);
        return view("provinsi/form_ubah", $var);
    }

    public function ubah()
    {
        //
        db_connect();
        $modelku=model('mprovinsi');
        $id=$this->request->getVar("id");
        $nama=$this->request->getVar("nama");
        $ibukota=$this->request->getVar("ibukota");
        $keterangan=$this->request->getVar("keterangan");

        $a=[
            "nama" => $nama,
            "ibukota" => $ibukota,
            "keterangan" => $keterangan
        ];
        $modelku->update($id, $a);
        return redirect()->to("provinsi/0");
    }
}
