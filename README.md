# Composer_codeigniter
membership and user listing system with PHP. The system contains 2 parts. First part is backend, and second part is front-end. These parts communicate over REST API. Front-end and back-end must be isolated from each other.

# application\controllers

public function index()
    {
        //get json object
        $input=(json_decode(file_get_contents("php://input")));
        //get the right form of my json object "{action:"",data:""}"
        try
        {
            if(empty($input->action))
            {throw new Exception('json object error');}
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
            die();
        }
        //switching between the types of the apis
        switch ($input->action){
            //login
            case 'login':
                $response=$this->login($input->data);
                break;
             //logout
            case 'logout':
                $member_id=$this->check_API_key();
                $response=$this->logout($member_id);
                break;
            //user_list
            case 'user_list':
                $member_id=$this->check_API_key();
                $response=$this->user_list();
                break;
            //user_get
            case 'user_get':
                $member_id=$this->check_API_key();
                $response=$this->user_get($input->data);
                break;

            default:
                $e=new Exception('so such action error');
                print_r($e->getMessage());
                die();

        }
        //return the result of the api request

        //print_r($response);// dumping the data in the array view for debugging
        print_r(json_encode($response));//send the api result in json form
        die();

    }
		
		#login api
		 function login($data)
    {
        try
        {
            if(empty($data->email)||empty($data->password))
            {throw new Exception('email or password error');}
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
            die();
        }
        $api_key=$this->data_model->login($data);
        $result['response']="success";
        $result['data']['API_key']=$api_key;
        return $result;
    }
		
		#logout api
		function logout($member_id)
    {
        $this->data_model->logout($member_id);
        $result['response']="success";
        $result['data']="";
        return $result;
    }
		
		#check the api key from the header
		function check_API_key()
    {
        try
        {
            if(empty(getallheaders()['API_key']))
            {throw new Exception('API key error');}
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
            die();
        }
        // get the member id if the key is true
        $member_id=$this->data_model->get_member_id(getallheaders()['API_key']);
        return $member_id;
    }
		
    #get all the users
    function user_list()
    {
       $data=$this->data_model->get_all_members();
       return $data;
    }
		
    #get single user
    function user_get($data)
    {
        try
        {
            if(empty($data->member_id))
            {throw new Exception('please select a user');}
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
            die();
        }
        $single_member=$this->data_model->get_member_data_by_id($data->member_id);
        $result['response']="success";
        $result['data']=$single_member;
        return $result;
    }
