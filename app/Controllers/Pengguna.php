<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pengguna extends BaseController
{
    public function index()
    {
        //
        $sesi=session();
        if(!$sesi->has("login"))return redirect()->to("/admin");
        else $var["foto"]="uploads/".$sesi->login["foto"];

        $db=db_connect();
        $modelku=model("mpengguna");
        $var["data"]=$modelku->findAll();

        return view("pengguna/index", $var);
    }

    public function hapus($id)
    {
        //
        db_connect();
        $modelku=model('mpengguna');
        $data=$modelku->find($id);
        if($data){
            if($data){
                unlink('uploads/'.$data['foto']);
            }
            $modelku->delete($id);
        }
        return redirect()->to("/pengguna");
    }

    public function tambah()
    {
        //
        db_connect();
        $modelku=model('mpengguna');
        $nama=$this->request->getVar("nama");
        $password=$this->request->getVar("password");

        $a=[    
            "username" => $nama,
            "password" => hash("md5", $password),
            "foto" => ""
        ];
        $modelku->insert($a);
        return redirect()->to("/pengguna");
    }

    public function upload($id){
        $img = $this->request->getFile('foto');

        if (! $img->hasMoved()) {
            $temp = explode('.', $img->getClientName());
            $nama_baru="foto_".$id.".".$temp[1];
            $img->move('uploads', $nama_baru);
            $modelku=model('mpengguna');
            $modelku->update($id, ["foto" => $nama_baru]);
        }
        return redirect()->to('/pengguna');
    }
}
