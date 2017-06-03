<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data_model extends CI_Model
{
    function insert_entry($data)
    {
        $this->db->insert_batch('members', $data);
        return $this->db->trans_status();
    }
    function login($data)
    {
        //the password not coded for testing resons and cz the random data
        $query = $this->db->get_where('members', array('email' => $data->email,'password'=>$data->password));
        if(empty($query->result()))
        {
            $e=new Exception('email or password error');
            print_r($e->getMessage());
            die();
        }
        else
        {
            //genirate api key here we can use Java tokens but i used this php uniqid function cz it serve what we need
            $API_key=md5(uniqid(rand(), true));
            //update the api key in the database
            $this->db->update('members',array('API_key'=>$API_key),array('id'=>$query->result()[0]->id));
            return $API_key;
           //return $query->result()[0]->id;
        }

    }
    function get_member_id($api_key)
    {
        $this->db->select('id');
        $query = $this->db->get_where('members', array('API_key' => $api_key));
        if(empty($query->result()))
        {
            $e=new Exception('API key not exist ');
            print_r($e->getMessage());
            die();
        }
        else
        {
            return $query->result()[0]->id;
        }
    }
    function logout($id)
    {
        $this->db->update('members',array('API_key'=>''),array('id'=>$id));
        return $this->db->trans_status();
    }
    function get_all_members()
    {

        $query = $this->db->get('members');
        return $query->result();
    }
    function get_member_data_by_id($id)
    {
        $query = $this->db->get_where('members', array('id' => $id));
        if(empty($query->result()))
        {
            $e=new Exception('member not exist');
            print_r($e->getMessage());
            die();
        }
        else
        {
            return $query->result()[0];
        }
    }

}