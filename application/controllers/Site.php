<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
/*        $this->load->database();
        $this->load->model(array('data_model'));//database handler*/
    }
    public function index()
    {
        $data['nglink']=base_url().'application/views/';
        $this->load->view('index',$data);
    }
    public function home()
    {
        $this->load->view('pages/home');
    }
    public function about()
    {
        $this->load->view('pages/about');
    }
    public function contact()
    {
        $this->load->view('pages/contact');
    }
    public function login()
    {
        $data['action']='login';
        $data['data'] = $this->input->post();

        print_r(json_encode($data));
    }
}