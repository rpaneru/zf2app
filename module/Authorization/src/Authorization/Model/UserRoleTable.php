<?php
namespace Authorization\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;

class UserRoleTable extends AbstractTableGateway
{
    protected $table = 'user_role';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Users());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getUserRoleData($userId)
    {
        $userId = (int)$userId;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from( 'user_role');        
        $where = new  Where();
        $where->equalTo('user_id', $userId);
        $select->where($where);

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet;
        $resultSet->initialize($results);
        $resultSet->buffer();
        
        $rolesArray = array();
        foreach($resultSet as $menu)
        {    
            if(!in_array( $menu["role_id"], $rolesArray) )
            {
                array_push( $rolesArray , $menu["role_id"] );
            }
        }
        
        return $rolesArray;
    }
}
