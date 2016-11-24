<?php

class PublicController extends Zend_Controller_Action
{
    protected $_authService;
    
    public function init()
    {
         $this->_helper->layout->setLayout('main');
         $this->_authService = new Application_Service_Auth();
    }
    
    public function indexAction()
    {
        
    } 
    
    public function infoAction () 
    {
        
    }
    
    
          
    public function logoutAction()
    {
        //Elimino la posizione dell'utente
        $_utente=new Application_Model_User();
        $un = $this->_authService->getIdentity()->username;
        $_utente->setIdPosByUName(null, $un);
        
        $this->_authService->clear();
        return $this->_helper->redirector('index','public');    
    }
    
}