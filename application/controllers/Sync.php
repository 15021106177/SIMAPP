<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        if (isset($_POST['import'])) {

            $file = $_FILES['csvsimak']['tmp_name'];

            // Medapatkan ekstensi file csv yang akan diimport.
            $ekstensi  = explode('.', $_FILES['csvsimak']['name']);

            // Tampilkan peringatan jika submit tanpa memilih menambahkan file.
            if (empty($file)) {
                echo 'File tidak boleh kosong!';
            } else {
                // Validasi apakah file yang diupload benar-benar file csv.
                if (strtolower(end($ekstensi)) === 'csv' && $_FILES["csvsimak"]["size"] > 0) {

                    $i = 0;
                    $handle = fopen($file, "r");

                    while (($row = fgetcsv($handle, 2048))) {
                        $i++;
                        if ($i == 1) continue;
                        // Data yang akan disimpan ke dalam databse
                        pre($row);
                        $data = [
                            'id_kategori' => $row[0],
                            'nama_barang' => $row[1],
                            'merek' => $row[2],
                            'tahun_perolehan' => $row[3],
                        ];

                        // Simpan data ke database.
                        $this->mb->savecsv($data);
                    }
                    fclose($handle);
                    redirect('data');
                } else {
                    echo 'Format file tidak valid!';
                }
            }
        }
    }

    //     echo "ada";
    //     $count = 0;
    //     $fp = fopen($_FILES['csvsimak']['tmp_name'], 'r') or die("can't open file");
    //     while ($csv_line = fgetcsv($fp, 2048)) {
    //         $count++;
    //         if ($count == 1) {
    //             continue;
    //         } //keep this if condition if you want to remove the first row
    //         for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
    //             $insert_csv = array();
    //             $insert_csv['id_kategori'] = $csv_line[1];
    //             $insert_csv['nama_barang'] = $csv_line[2];
    //             $insert_csv['merek'] = $csv_line[3];
    //             $insert_csv['tahun_perolehan'] = $csv_line[4];
    //         }
    //         $i++;
    //         $data = array(
    //             'id_kategori' => $insert_csv['id_kategori'],
    //             'nama_barang' => $insert_csv['nama_barang'],
    //             'merek' => $insert_csv['merek'],
    //             'tahun_perolehan' => $insert_csv['tahun_perolehan'],
    //         );
    //     }
    // }
    public function syncSimak2()
    {
        echo "ada";
        $count = 0;
        $fp = fopen($_FILES['csvsimak']['tmp_name'], 'r') or die("can't open file");
        while ($csv_line = fgetcsv($fp, 1024)) {
            $count++;
            if ($count == 1) {
                continue;
            } //keep this if condition if you want to remove the first row
            for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                $insert_csv = [];
                $insert_csv['id_kategori'] = $csv_line[1];
                $insert_csv['nama_barang'] = $csv_line[2];
                $insert_csv['merek'] = $csv_line[3];
                $insert_csv['tahun_perolehan'] = $csv_line[4];
            }
            $i++;
            $data = array(
                'id_kategori' => $insert_csv['id_kategori'],
                'nama_barang' => $insert_csv['nama_barang'],
                'merek' => $insert_csv['merek'],
                'tahun_perolehan' => $insert_csv['tahun_perolehan'],
            );
            pre($data);
        }
    }
}
