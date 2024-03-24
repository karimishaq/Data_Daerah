<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\SpreadSheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends BaseController
{
    function provinsi(){
        $db=db_connect();
        $data=$db->query("Select provinsi.*, 
        (select count(kabupaten.provinsi) from kabupaten where provinsi.id_provinsi=kabupaten.provinsi) AS kabupaten, 
        (select count(kecamatan.provinsi) from kecamatan where provinsi.id_provinsi=kecamatan.provinsi)
        AS kecamatan,
        (select count(desa.provinsi) from desa where provinsi.id_provinsi=desa.provinsi)
        AS desa
        FROM provinsi");
        $daerah=$data->getResultArray();

        // Settingan awal fil excel
        $excel = new Spreadsheet();
        $excel->getProperties()->setCreator('My Notes Code')
                 ->setLastModifiedBy('My Notes Code')
                 ->setTitle("Data Provinsi")
                 ->setSubject("Provinsi")
                 ->setDescription("Laporan Semua Data Provinsi")
                 ->setKeywords("Data Provinsi");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat Header baris ke 1
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Provinsi"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai G1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    
        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "No"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "Nama"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "Kabupaten"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "Kecamatan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "Desa"); // Set kolom E3 dengan tulisan "ALAMAT"
    
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
    
        
        $i=1;
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 5
        foreach($daerah as $row){ // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $i);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row["nama"]);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row["kabupaten"]);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row["kecamatan"]);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row["desa"]);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
      
            $i++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "=SUM(C5:C".($numrow-1).")");
        $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "=SUM(D5:D".($numrow-1).")");
        $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, "=SUM(E5:E".($numrow-1).")");

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Anggota");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        $this->response->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Provinsi.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
    }

    function kabupaten($provinsi=0){
        $db=db_connect();
        $data=$db->query("Select kabupaten.*, 
        (select count(kecamatan.provinsi) from kecamatan where kabupaten.id_kabupaten=kecamatan.kabupaten)
        AS kecamatan,
        (select count(desa.provinsi) from desa where kabupaten.id_kabupaten=desa.kabupaten)
        AS desa FROM kabupaten where provinsi=".$provinsi);
        $daerah=$data->getResultArray();

        // Settingan awal fil excel
        $excel = new Spreadsheet();
        $excel->getProperties()->setCreator('My Notes Code')
                 ->setLastModifiedBy('My Notes Code')
                 ->setTitle("Data Kabupaten")
                 ->setSubject("Kabupaten")
                 ->setDescription("Laporan Semua Data Kabupaten")
                 ->setKeywords("Data Kabupaten");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat Header baris ke 1
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA Kabupaten"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai G1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    
        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "No"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "Nama"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "Kecamatan"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "Desa"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
    
        
        $i=1;
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 5
        foreach($daerah as $row){ // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $i);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row["nama_kabupaten"]);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row["kecamatan"]);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row["desa"]);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
      
            $i++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "=SUM(C5:C".($numrow-1).")");
        $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, "=SUM(D5:D".($numrow-1).")");

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Anggota");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        $this->response->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Kabupaten.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
    }

    function kecamatan($kabupaten=0){
        $db=db_connect();
        $data=$db->query("Select kecamatan.*,
        (select count(desa.provinsi) from desa where kecamatan.id_kecamatan=desa.kecamatan)
        AS desa FROM kecamatan where kabupaten=".$kabupaten);
        $daerah=$data->getResultArray();
        $data=$db->query("Select (SELECT count(*) from desa where kabupaten=".$kabupaten.") AS tdesa");
        $total=$data->getRowArray();

        // Settingan awal fil excel
        $excel = new Spreadsheet();
        $excel->getProperties()->setCreator('My Notes Code')
                 ->setLastModifiedBy('My Notes Code')
                 ->setTitle("Data Kecamatan")
                 ->setSubject("Kecamatan")
                 ->setDescription("Laporan Semua Data Kecamatan")
                 ->setKeywords("Data Kecamatan");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat Header baris ke 1
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Kecamatan"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai G1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    
        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "No"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "Kecamatan"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "Desa"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        
        $i=1;
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 5
        foreach($daerah as $row){ // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $i);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row["nama_kecamatan"]);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row["desa"]);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
      
            $i++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, "=SUM(C5:C".($numrow-1).")");
        
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Anggota");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        $this->response->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Kecamatan.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
        exit();
    }

    function desa($kecamatan=0){
        $db=db_connect();
        $modelku=model('mdesa');
        $mprovinsi=model('mprovinsi');
        $mkabupaten=model('mkabupaten');
        $mkecamatan=model('mkecamatan');
        $daerah=$modelku->where('kecamatan', $kecamatan)->findAll();

        // Settingan awal fil excel
        $excel = new Spreadsheet();
        $excel->getProperties()->setCreator('My Notes Code')
                 ->setLastModifiedBy('My Notes Code')
                 ->setTitle("Data Desa")
                 ->setSubject("Desa")
                 ->setDescription("Laporan Semua Data Desa")
                 ->setKeywords("Data Desa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat Header baris ke 1
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Desa"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:B1'); // Set Merge Cell pada kolom A1 sampai G1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    
        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "No"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "Desa"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
    
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        
        $i=1;
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 5
        foreach($daerah as $row){ // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $i);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row["nama_desa"]);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
      
            $i++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Desa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        $this->response->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Desa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = new Xlsx($excel);
        $write->save('php://output');
        exit();
    }
}
