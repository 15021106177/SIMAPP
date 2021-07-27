<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Sync extends CI_Controller 
{

        
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata("logged") <> 1) {
            redirect(site_url('login'));
        }
        $this->load->helper('custom_helper');
        $this->load->model('ModelBarang', 'mb');
    }

    public function index()
    {
        $this->load->view('layouts/header');
        $this->load->view('sync/v_sync');
        $this->load->view('layouts/footer');
    }

    public function syncSimak()
    {
       $data = [];
       // If file uploaded
       if (!empty($_FILES['csvsimak']['name'])) {
           // get file extension
           $extension = pathinfo($_FILES['csvsimak']['name'], PATHINFO_EXTENSION);

           if ($extension == 'csv') {
               $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
           } elseif ($extension == 'xlsx') {
               $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
           } else {
               $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
           }
           // file path
           $spreadsheet = $reader->load($_FILES['csvsimak']['tmp_name']);
           $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

           // array Count
           $arrayCount = count($allDataInSheet);
           $flag = 0;
           $createArray = array('id_kategori', 'nama_barang', 'merek', 'tahun_perolehan',);
           $makeArray = array('id_kategori' => 'id_kategori', 'nama_barang' => 'nama_barang', 'merek' => 'merek', 'tahun_perolehan' => 'tahun_perolehan');
           $SheetDataKey = array();
           foreach ($allDataInSheet as $dataInSheet) {
               foreach ($dataInSheet as $key => $value) {
                   if (in_array(trim($value), $createArray)) {
                       $value = preg_replace('/\s+/', '', $value);
                       $SheetDataKey[trim($value)] = $key;
                   }
               }
           }
           $dataDiff = array_diff_key($makeArray, $SheetDataKey);
           if (empty($dataDiff)) {
               $flag = 1;
           }
           // match excel sheet column
           if ($flag == 1) {
               for ($i = 2; $i <= $arrayCount; $i++) {
                   $addresses = array();
                   $id_kategori = $SheetDataKey['id_kategori'];
                   $nama_barang = $SheetDataKey['nama_barang'];
                   $merek = $SheetDataKey['merek'];
                   $tahun_perolehan = $SheetDataKey['tahun_perolehan'];
                   $id_kategori = filter_var(trim($allDataInSheet[$i][$id_kategori]), FILTER_SANITIZE_STRING);
                   $nama_barang = filter_var(trim($allDataInSheet[$i][$nama_barang]), FILTER_SANITIZE_STRING);
                   $merek = filter_var(trim($allDataInSheet[$i][$merek]), FILTER_SANITIZE_EMAIL);
                   $tahun_perolehan = filter_var(trim($allDataInSheet[$i][$tahun_perolehan]), FILTER_SANITIZE_STRING);
                   $fetchData[] = array('id_kategori' => $id_kategori, 'nama_barang' => $nama_barang, 'merek' => $merek, 'tahun_perolehan' => $tahun_perolehan);
               }
               $data['dataInfo'] = $fetchData;
               $this->mb->savecsv($fetchData);
               redirect('barang');
           } else {
               echo "Please import correct file, did not match excel sheet column";
           }
       }
   }



}