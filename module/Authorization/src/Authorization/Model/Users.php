<?php
namespace Authorization\Model;

class Users
{
    public $user_id;
    public $username;
    public $password;
    public $email;
    public $display_name;
    public $status;

    public function exchangeArray($data)
    {
        $this->user_id     = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
        $this->email     = (isset($data['email'])) ? $data['email'] : null;
        $this->display_name = (isset($data['display_name'])) ? $data['display_name'] : null;
        $this->status  = (isset($data['status'])) ? $data['status'] : null;        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
