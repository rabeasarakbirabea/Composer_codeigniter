<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_faker extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->database();
        $this->load->model(array('data_model'));//database handler
    }

    public function index()
    {
        $faker = Faker\Factory::create();   // initialise the faker library

        //create the 10 member array

        $data= array();
        for ($i=0; $i < 10; $i++) {
            //members attributes
            $member= new stdClass();
            $member->name=$faker->name;
            $member->email=$faker->email;
            $member->password=$faker->password;
            $member->address=$faker->address;
            $member->phone_number=$faker->PhoneNumber;
            $member->company=$faker->Company;
            $member->text=$faker->Text;
            $member->b_date=$faker->dateTimeThisCentury->format('Y-m-d');
            //add member to array of members
            array_push($data,$member);
        }
        // adding 10 members to the database
        $insert_flag=$this->data_model->insert_entry($data);
        if($insert_flag)
            echo "new 10 users has been added to the database";
        else
            echo "error try again later";
    }

}