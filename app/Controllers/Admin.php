<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function index()
    {
        $sesi = session();
        if(!$sesi->has("login")){
            $data=$sesi->getFlashdata();
            $var["status_login"]="";
            if($sesi->has("status"))$var["status_login"]=$sesi->status;
            return view("login", $var);
        }else{
            $var["foto"]="uploads/".$sesi->login["foto"];

            $db=db_connect();
            $data=$db->query("select (SELECT count(*) from provinsi) AS tprovinsi, (SELECT count(*) from kabupaten) AS tkabupaten, (SELECT count(*) from kecamatan) AS tkecamatan, (SELECT count(*) from desa) AS tdesa");
            $var["total"]=$data->getRowArray();
            return view("dashboard", $var);
        }
    }

    public function login()
    {
        //
        db_connect();
        $modelku=model("mpengguna");
        $nama=$this->request->getVar("nama");
        $password=hash("md5", $this->request->getVar("password"));
        $hasil=$modelku->where("username", $nama)->where("password", $password)->first();
        $sesi = session();
        if($hasil){
            $login=[
                "nama" => $nama,
                "password" => $password,
                "foto" => $hasil["foto"]
            ];
            $sesi->set("login", $login);
        }else{
            $sesi->setFlashdata('status', 'Username atau Password Salah');
        }

        return redirect()->to("/admin");
    }

    public function logout()
    {
        //
        $sesi=session();
        $sesi->destroy();

        return redirect()->to("/admin");
    }
}
