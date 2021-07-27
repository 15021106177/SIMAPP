<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends CI_Controller {

        
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata("logged") <> 1) {
            redirect(site_url('login'));
        }
        $this->load->helper('custom_helper');
        // $this->load->model('ModelBarang', 'mb');
    }

    public function index()
    {
        $this->load->view('layouts/header');
        $this->load->view('sync/v_sync');
        $this->load->view('layouts/footer');
    }



}