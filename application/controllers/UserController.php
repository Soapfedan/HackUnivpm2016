<?php

class UserController extends Zend_Controller_Action
{
    protected $_mcform;
    protected $_pform;
    protected $_utente;
    protected $_mpform;
    protected $_epform;
    protected $_seform;
	protected $_edificio;
	protected $_piano;
	protected $_idavviso;
    protected $imageBlob;
    
    public function init()
    {
        $this->_helper->layout->setLayout('user');    
        $this->_authService = new Application_Service_Auth();
        $this->_utente=new Application_Model_User();
        $this->view->mcForm=$this->getModCredenzialiForm();
    }
    
    public function indexAction()
    {} 
	
	public function gestionepresaAction()
    {} 
	
	public function crealpAction()
    {} 
	
	public function modificalpAction()
    {} 
	
	public function eliminalpAction()
    {} 
	
	public function modificaimmagineAction()
    {} 
	
	public function modificapasswordAction()
    {} 
    
    public function modprofiloAction () 
    {
        $un=$this->_authService->getIdentity()->username;
        $this->_mpform->populate($this->_utente->getUserByUName($un)->toArray());
    }
    
    public function salvamodprofiloAction () 
    {
        if(!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
        $form=$this->_mpform;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modprofilo');
        }
        $values=$form->getValues();
        //conversione del file della form in blob
        $image=APPLICATION_PATH . '/../public/images/temp/'.$values['imgprofilo'];
        $data=file_get_contents($image);
        //immissione del file blob nella variabile imgprofilo
        $values['imgprofilo']=$data;
        
        $un=$this->_authService->getIdentity()->username;
        $this->_utente->updateUser($values,$un);
        $us=$this->_authService->getIdentity()->username;
        $pa=$this->_authService->getIdentity()->password;
        $a=array("username"=>$us,"password"=>$pa);
        $this->_authService->getAuth()->clearIdentity();
        $this->_authService->authenticate($a);
        //eliminazione de file temporaneo immagine
        unlink($image);
        
    }
    
    public function modcredenzialiAction () 
    {
        $un=$this->_authService->getIdentity()->username;
        $this->_mcform->populate($this->_utente->getUserByUName($un)->toArray());
    }
    
    public function salvamodcredenzialiAction () 
    {
        if(!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
        $form=$this->_mcform;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modcredenziali');
        }
        $values=$form->getValues();
        if($values['password']==$values['passwordtest']){
            unset($values['passwordtest']);
            $un=$this->_authService->getIdentity()->username;
            $this->_utente->updateUser($values,$un);
            $this->_authService->getAuth()->clearIdentity();
            $this->_authService->authenticate($values);
        }else{
            $form->setDescription('Attenzione: le password non corrispondono.');
            return $this->render('modcredenziali');
        }
    }

	
    
    public function confermaeliminazioneprofiloAction()
    {
        $un=$this->_authService->getIdentity()->username;
        $this->_utente->deleteUser($un);
        $this->_helper->redirector('index','public');
    }
    
    protected function getModCredenzialiForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_mcform = new Application_Form_User_Modcredenziali();
        $this->_mcform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'salvamodcredenziali'),
            'default'
        ));
        return $this->_mcform;
    }

    protected function getModProfiloForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_mpform = new Application_Form_User_Modprofilo();
        $this->_mpform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'salvamodprofilo'),
            'default'
        ));
        return $this->_mpform;
    }
}