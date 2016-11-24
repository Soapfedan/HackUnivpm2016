<?php

class PublicController extends Zend_Controller_Action
{
    protected $_vistaFaq;
    protected $_authService;
    
    public function init()
    {
         $this->_helper->layout->setLayout('main');
         $this->_vistaFaq=new Application_Model_Vistafaq();
         $this->_authService = new Application_Service_Auth();
    }
    
    public function indexAction()
    {
    	
    } 
    
    public function viewstaticAction () 
    {
    	$page = $this->_getParam('staticPage');
    	$this->render($page);
    }
    
    public function faqAction()
    {
         $Faq=$this->_vistaFaq->getFaqOrderById();
         $this->view->assign(array('faq'=>$Faq));
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