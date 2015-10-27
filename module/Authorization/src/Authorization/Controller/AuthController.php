<?php
namespace Authorization\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

use Authorization\Form\LoginForm;

class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
    protected $usersTable;
    protected $userRoleTable;
     
    public function getAuthService()
    {
        if (! $this->authservice) 
        {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
         
        return $this->authservice;
    }
     
    public function getSessionStorage()
    {
        if (! $this->storage) 
        {
            $this->storage = $this->getServiceLocator()->get('Authorization\Model\AuthStorage');
        }         
        return $this->storage;
    }
     
    public function getForm()
    {
        if (! $this->form) 
        {            
            $loginForm = new LoginForm();
            
            $this->form = $loginForm;
        }
         
        return $this->form;
    }
     
    public function loginAction()
    {
        if ($this->getAuthService()->hasIdentity())
        {
            return $this->redirect()->toRoute('success');
        }
                 
        $form = $this->getForm();
         
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
     
    public function authenticateAction()
    {
        $form = $this->getForm();
        $redirect = 'login';
         
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                //check authentication...
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential($request->getPost('password'));
                                        
                $result = $this->getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }
                 
                if ($result->isValid()) 
                {
                    $redirect = 'success';
                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') == 1 ) 
                    {
                        $this->getSessionStorage()
                             ->setRememberMe(1);
                        //set storage again 
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    $this->getAuthService()->getStorage()->write($request->getPost('username'));
                    
                    $usersTable = $this->getUsersTable();
                    $userData = $usersTable->getUserData( $request->getPost('username') );
                    $userData = (array)$userData;
                    
                    $userRoleTable = $this->getUserRoleTable();
                    $userRoleData = $userRoleTable->getUserRoleData( $userData['user_id'] );
                    $userRoleData = (array)$userRoleData;                    
                    
                    $container = new Container('userData');
                    $container->profile = $userData;
                    $container->role = $userRoleData;                    
                }
            }
        }
         
        return $this->redirect()->toRoute($redirect);
    }
     
    public function logoutAction()
    {
        $container = new Container('userData');
        $container->getManager()->getStorage()->clear();
                
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
         
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('login');
    }
    
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('Authorization\Model\UsersTable');
        }
        return $this->usersTable;
    }
    
    public function getUserRoleTable()
    {
        if (!$this->userRoleTable) {
            $sm = $this->getServiceLocator();
            $this->userRoleTable = $sm->get('Authorization\Model\UserRoleTable');
        }
        return $this->userRoleTable;
    }
}