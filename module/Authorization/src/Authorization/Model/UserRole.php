<?php
namespace Authorization\Model;

class UserRole
{
    public $user_role_id;
    public $user_id;
    public $role_id;
    public $description;

    public function exchangeArray($data)
    {
        $this->user_role_id     = (isset($data['user_role_id'])) ? $data['user_role_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->role_id  = (isset($data['role_id'])) ? $data['role_id'] : null;
        $this->description     = (isset($data['description'])) ? $data['description'] : null;       
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
