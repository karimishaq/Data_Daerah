<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Desa extends BaseController
{
    public function index($provinsi=0, $kabupaten=0, $kecamatan=0, $hlm=0, $jtampil=100)
    {
        //
        $sesi=session();
        if(!$sesi->has("login"))return redirect()->to("/admin");
        else $var["foto"]='uploads/'.$sesi->login["foto"];
        
        $db=db_connect();
        $modelku=model('mdesa');
        $mprovinsi=model('mprovinsi');
        $mkabupaten=model('mkabupaten');
        $mkecamatan=model('mkecamatan');
        $var["data"]=$modelku->where('kecamatan', $kecamatan)->findAll($jtampil, $hlm*$jtampil);

        $var["total"]=$modelku->selectCount("nama_desa", "tdesa")->where("kecamatan", $kecamatan)->first();
        $var["jtampil"]=$jtampil;
        $var["halaman"]=$hlm;

        $var["provinsi"]=$mprovinsi->find($provinsi);
        $var["kabupaten"]=$mkabupaten->find($kabupaten);
        $var["kecamatan"]=$mkecamatan->find($kecamatan);
        
        return view("desa/index", $var);
    }

    public function hapus($id)
    {
        //
        db_connect();
        $modelku=model('mdesa');
        $data=$modelku->find($id);
        $modelku->delete($id);
        return redirect()->to(base_url("desa/".$data["provinsi"]."/".$data["kabupaten"]."/".$data["kecamatan"])."/0");
    }

    public function tambah()
    {
        //
        db_connect();
        $modelku=model('mdesa');
        $provinsi=$this->request->getVar("provinsi");
        $kabupaten=$this->request->getVar("kabupaten");
        $kecamatan=$this->request->getVar("kecamatan");
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[
            "nama_desa" => $nama,
            "keterangan" => $keterangan,
            "provinsi" => $provinsi,
            "kabupaten" => $kabupaten,
            "kecamatan" => $kecamatan
        ];
        $modelku->insert($a);
        return redirect()->to("desa/".$provinsi."/".$kabupaten."/".$kecamatan."/0");
    }

    public function form_ubah($provinsi, $kabupaten, $kecamatan, $id)
    {
        $sesi=session();
        if(!$sesi->has("login"))return redirect()->to("/admin");
        else $var["foto"]='uploads/'.$sesi->login["foto"];

        $modelku=model('mdesa');
        $var["data"]=$modelku->find($id);
        return view("desa/form_ubah", $var);
    }

    public function ubah()
    {
        //
        db_connect();
        $modelku=model('mdesa');
        $provinsi=$this->request->getVar("provinsi");
        $kabupaten=$this->request->getVar("kabupaten");
        $kecamatan=$this->request->getVar("kecamatan");
        $id=$this->request->getVar("id");
        $nama=$this->request->getVar("nama");
        $keterangan=$this->request->getVar("keterangan");

        $a=[    
            "nama_desa" => $nama,
            "keterangan" => $keterangan
        ];
        $modelku->update($id, $a);
        return redirect()->to("desa/".$provinsi."/".$kabupaten."/".$kecamatan."/0");
    }

    public function batch_add($provinsi=0, $kabupaten=0, $kecamatan=0)
    {
        //
        db_connect();
        $modelku=model('mdesa');
        $temp=preg_split('/\r\n|[\r\n]/', $this->request->getVar("nama"));

        $a=[];
        foreach($temp as $dt){
            if($dt!=""){
                array_push($a, [
                    "nama_desa" => ucwords(strtolower($dt)),
                    "keterangan" => "",
                    "provinsi" => $provinsi,
                    "kabupaten" => $kabupaten,
                    "kecamatan" => $kecamatan
                ]);
            }
        }
        $modelku->insertBatch($a);
        return redirect()->to("desa/".$provinsi."/".$kabupaten."/".$kecamatan."/0");
    }

    public function batch_delete(){
        $provinsi=$this->request->getVar("provinsi");
        $kabupaten=$this->request->getVar("kabupaten");
        $kecamatan=$this->request->getVar("kecamatan");

        $data=[];
        $pilihan=$this->request->getVar("pilihan");
        if($pilihan){
            foreach($pilihan as $id){
                array_push($data, ["id_desa" => $id]);
            };

            $db=db_connect();
            $db->table('desa')->onConstraint('id_desa')->setData($data, true)->deleteBatch();
        }
        return redirect()->to("desa/".$provinsi."/".$kabupaten."/".$kecamatan."/0");
    }
}
