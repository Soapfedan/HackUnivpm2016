<?php

class PublicController extends Zend_Controller_Action
{
    protected $_authService;
    protected $_form;

    public function init()
    {
         $this->_helper->layout->setLayout('main');
         $this->_authService = new Application_Service_Auth();
         $this->view->loginForm = $this->getLoginForm();
    }
    
    public function indexAction()
    {
    } 
    
    public function infoAction () 
    {
        
    }
    
    protected function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Public_Auth_Login();
        $this->_form->setAction($urlHelper->url(array(
            'controller' => 'access',
            'action' => 'authenticate'),
            'default'
        ));
        return $this->_form;
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