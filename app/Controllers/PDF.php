<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Fpdf\Fpdf;

class PDF extends BaseController
{

    public function provinsi()
    {
        $db=db_connect();
        $data=$db->query("Select provinsi.*, 
        (select count(kabupaten.provinsi) from kabupaten where provinsi.id_provinsi=kabupaten.provinsi) AS kabupaten, 
        (select count(kecamatan.provinsi) from kecamatan where provinsi.id_provinsi=kecamatan.provinsi)
        AS kecamatan,
        (select count(desa.provinsi) from desa where provinsi.id_provinsi=desa.provinsi)
        AS desa
        FROM provinsi");
        $daerah=$data->getResultArray();
        $data=$db->query("select (SELECT count(*) from kecamatan) AS tkecamatan, (SELECT count(*) from kabupaten) AS tkabupaten, (SELECT count(*) from desa) AS tdesa");
        $total=$data->getRowArray();

        //
        $pdf = new FPDF('P','mm','A4');
        
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(1,13);
        $pdf->SetMargins(10,10,10);
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string
        $pdf->Cell(190,7,'Data Provinsi',0,1,'C');
        date_default_timezone_set('Asia/Jakarta');

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1,'');
        $pdf->SetX(30);
        $pdf->SetFont('Arial','B',11);

        $pdf->SetFillColor(28, 166, 205);
        $pdf->Cell(9,6,'No',1,0,'C',1);
        $pdf->Cell(54,6,'Nama',1,0,'C',1);
        $pdf->Cell(28,6,'Kabupaten',1,0,'C',1);
        $pdf->Cell(28,6,'Kecamatan',1,0,'C',1);
        $pdf->Cell(28,6,'Desa',1,0,'C',1);
        
        $pdf->SetFont('Arial','',11);
        $pdf->Ln();

        $i=1;
        foreach ($daerah as $row){
            $pdf->SetX(30);
            $pdf->Cell(9,6,$i,1,0,'C');
            $pdf->Cell(54,6,$row["nama"],1,0);
            $pdf->Cell(28,6,$row["kabupaten"],1,0);
            $pdf->Cell(28,6,$row["kecamatan"],1,0);
            $pdf->Cell(28,6,$row["desa"],1,0);
            $i++;
            $pdf->Ln();
        }

        
        $pdf->SetX(30);
        $pdf->Cell(9,6,"",1,0,'C');
        $pdf->Cell(54,6,"Total",1,0);
        $pdf->Cell(28,6,$total["tkabupaten"],1,0);
        $pdf->Cell(28,6,$total["tkecamatan"],1,0);
        $pdf->Cell(28,6,$total["tdesa"],1,0);
        $this->response->setContentType('application/pdf');
        $pdf->Output();
    }

    public function kabupaten($provinsi=0)
    {
        $db=db_connect();
        $data=$db->query("Select kabupaten.*, 
        (select count(kecamatan.provinsi) from kecamatan where kabupaten.id_kabupaten=kecamatan.kabupaten)
        AS kecamatan,
        (select count(desa.provinsi) from desa where kabupaten.id_kabupaten=desa.kabupaten)
        AS desa FROM kabupaten where provinsi=".$provinsi);
        $daerah=$data->getResultArray();
        $data=$db->query("select (SELECT count(*) from kecamatan where provinsi=".$provinsi.") AS tkecamatan, (SELECT count(*) from desa where provinsi=".$provinsi.") AS tdesa");
        $total=$data->getRowArray();

        //
        $pdf = new FPDF('P','mm','A4');
        $pdf->SetMargins(10,10,10);
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string
        $pdf->Cell(190,7,'Data Kabupaten',0,1,'C');
        date_default_timezone_set('Asia/Jakarta');

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1,'');
        $pdf->SetX(30);
        $pdf->SetFont('Arial','B',11);

        $pdf->SetFillColor(28, 166, 205);
        $pdf->Cell(9,6,'No',1,0,'C',1);
        $pdf->Cell(54,6,'Nama',1,0,'C',1);
        $pdf->Cell(42,6,'Kecamatan',1,0,'C',1);
        $pdf->Cell(42,6,'Desa',1,0,'C',1);
        
        $pdf->SetFont('Arial','',11);
        $pdf->Ln();

        $i=1;
        foreach ($daerah as $row){
            $pdf->SetX(30);
            $pdf->Cell(9,6,$i,1,0,'C');
            $pdf->Cell(54,6,$row["nama_kabupaten"],1,0);
            $pdf->Cell(42,6,$row["kecamatan"],1,0);
            $pdf->Cell(42,6,$row["desa"],1,0);
            $i++;
            $pdf->Ln();
        }

        
        $pdf->SetX(30);
        $pdf->Cell(9,6,"",1,0,'C');
        $pdf->Cell(54,6,"Total",1,0);
        $pdf->Cell(42,6,$total["tkecamatan"],1,0);
        $pdf->Cell(42,6,$total["tdesa"],1,0);
        $this->response->setContentType('application/pdf');
        $pdf->Output();
    }

    public function kecamatan($kabupaten=0)
    {
        $db=db_connect();
        $data=$db->query("Select kecamatan.*,
        (select count(desa.provinsi) from desa where kecamatan.id_kecamatan=desa.kecamatan)
        AS desa FROM kecamatan where kabupaten=".$kabupaten);
        $daerah=$data->getResultArray();
        $data=$db->query("Select (SELECT count(*) from desa where kabupaten=".$kabupaten.") AS tdesa");
        $total=$data->getRowArray();

        //
        $pdf = new FPDF('P','mm','A4');
        $pdf->SetMargins(10,10,10);
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string
        $pdf->Cell(190,7,'Data Kecamatan',0,1,'C');
        date_default_timezone_set('Asia/Jakarta');

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1,'');
        $pdf->SetX(30);
        $pdf->SetFont('Arial','B',11);

        $pdf->SetFillColor(28, 166, 205);
        $pdf->Cell(9,6,'No',1,0,'C',1);
        $pdf->Cell(54,6,'Nama',1,0,'C',1);
        $pdf->Cell(84,6,'Desa',1,0,'C',1);
        
        $pdf->SetFont('Arial','',11);
        $pdf->Ln();

        $i=1;
        foreach ($daerah as $row){
            $pdf->SetX(30);
            $pdf->Cell(9,6,$i,1,0,'C');
            $pdf->Cell(54,6,$row["nama_kecamatan"],1,0);
            $pdf->Cell(84,6,$row["desa"],1,0);
            $i++;
            $pdf->Ln();
        }

        
        $pdf->SetX(30);
        $pdf->Cell(9,6,"",1,0,'C');
        $pdf->Cell(54,6,"Total",1,0);
        $pdf->Cell(84,6,$total["tdesa"],1,0);
        $this->response->setContentType('application/pdf');
        $pdf->Output();
        exit();
    }

    public function desa($kecamatan=0)
    {
        $db=db_connect();
        $modelku=model('mdesa');
        $mprovinsi=model('mprovinsi');
        $mkabupaten=model('mkabupaten');
        $mkecamatan=model('mkecamatan');
        $daerah=$modelku->where('kecamatan', $kecamatan)->findAll();

        //
        $pdf = new FPDF('P','mm','A4');
        $pdf->SetMargins(10,10,10);
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string
        $pdf->Cell(190,7,'Data Desa',0,1,'C');
        date_default_timezone_set('Asia/Jakarta');

        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1,'');
        $pdf->SetX(30);
        $pdf->SetFont('Arial','B',11);

        $pdf->SetFillColor(28, 166, 205);
        $pdf->Cell(9,6,'No',1,0,'C',1);
        $pdf->Cell(138,6,'Desa',1,0,'C',1);
        
        $pdf->SetFont('Arial','',11);
        $pdf->Ln();

        $i=1;
        foreach ($daerah as $row){
            $pdf->SetX(30);
            $pdf->Cell(9,6,$i,1,0,'C');
            $pdf->Cell(138,6,$row["nama_desa"],1,0);
            $i++;
            $pdf->Ln();
        }
        $this->response->setContentType('application/pdf');
        $pdf->Output();
        exit();
    }
}
