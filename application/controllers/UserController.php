<?php

class UserController extends Zend_Controller_Action
{
    protected $_mcform;
    protected $_pform;
    protected $_utente;
    //---
    protected $_aform;
    protected $_bform;
    //---
    protected $_epform;
    protected $_seform;
	protected $_edificio;
	protected $_piano;
	protected $_idavviso;
    protected $imageBlob;
    //---
    protected $_editPictureForm;
    protected $_editpswForm;
    
    public function init()
    {
        $this->_helper->layout->setLayout('user');    
        $this->_authService = new Application_Service_Auth();
        $this->_utente = new Application_Model_User();
        //---
        $this->_editPictureForm = $this->getEditPictureForm();
        $this->_editpswForm = $this->getEditPswForm();
    }
    
    public function indexAction()
    {
    	$un = $this->_authService->getIdentity()->username;
		$user = $this->_utente->getUserbyUsername($un);
    	$pList = $this->_utente->getSingleSchema($user['id_schema']);
		$plugsList =  null;
		$nomeSchema = null;
		foreach ($pList as $plk => $pl) {
			$nomeSchema = $pl['schema_name'];
			$consumo = $this->_utente->getSinglePlugCons($pl['id_plug']);
			$c = ($consumo['consumption']/$user['max_power'])*100;
			$p = $this->_utente->getPlug($pl['id_plug']);
			$temp = $this->_utente->getSingleTemplate($p['id_template']);
			$icona = $temp['icon']; 
			$plugsList[] = array('icona' => $icona,
								 'priorita'=> $pl['priority'],
								 'plug_state' => $p['plug_state'], //0 - staccata; 1 - in funzione; 2 - spenta
								 'nome' => $p['mnemonic_name'],
								 'ID' => $p['plug_id'],
								 'consumo' => $c);
		}
		$this->view->assign('nomeSchema', $nomeSchema);
		$this->view->assign('plugsList', $plugsList);
    } 
	
	public function getdatiAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		
		$un = $this->_authService->getIdentity()->username;
		$user = $this->_utente->getUserbyUsername($un);
    	$pList = $this->_utente->getSingleSchema($user['id_schema']);
		$plugsList =  null;
		$nomeSchema = null;
		$c = null;
		foreach ($pList as $plk => $pl) {
			$consumo = $this->_utente->getSinglePlugCons($pl['id_plug']);
			$p = $this->_utente->getPlug($pl['id_plug']);			
			var_dump($p['plug_id']);
			if($p['plug_state'] != 1)
			{
				$c = 0;
			}else{
				$c = ($consumo['consumption']/$user['max_power'])*100;
			}
			
			$plugsList[] = array('ID' => $p['plug_id'],
								 'consumo' => $c);
		}
		//Codifico i dati in formato Json e li rimando indietro
		require_once 'Zend/Json.php';
        $a = Zend_Json::encode($plugsList);
		echo $a;
	}
	
	public function consumopresaAction()
    {} 
	
	public function crealpAction()
    {
       
    } 
	
	public function modificalpAction()
    {} 
	
	public function eliminalpAction()
    {} 
	
	public function modificaimmagineAction()
    {
        //---
        $this->view->f = $this->_editPictureForm;
    } 
	
	public function modificapasswordAction()
    {
        //---
        $this->view->f = $this->_editpswForm;
    } 
    
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
        $form = $this->_aform;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->_helper->redirector('modificaimmagine');
        }
        $values=$form->getValues();
        //conversione del file della form in blob
        $image=APPLICATION_PATH . '/../public/images/temp/'.$values['imgprofilo'];
        $data=file_get_contents($image);
        
        //immissione del file blob nella variabile imgprofilo
        $us = $this->_utente->getUser();
        //$un=$this->_authService->getIdentity()->username;
        $virtual = array('username'      => $us['username'],
                         'password'      => $us['password'],
                         'email'         => $us['email'],
                         'num_telephone' => $us['num_telephone'],
                         'imgprofilo'    => $data,
                         'livello'       => $us['livello'],
                         'max_power'     => $us['max_power'],
                         'id_schema'     => $us['id_schema'],
                        );
        $this->_utente->updateUser($virtual);
        Zend_Layout::getMvcInstance()->setLayout('user');   
        //$us=$this->_authService->getIdentity()->username;
        //$pa=$this->_authService->getIdentity()->password;
        //$a=array("username"=>$us,"password"=>$pa);
        //$this->_authService->getAuth()->clearIdentity();
        //$this->_authService->authenticate($a);
         
        //eliminazione de file temporaneo immagine
        unlink($image);
        $this->_helper->redirector('index');
    }

    public function salvamodpasswordAction () 
    {
        if(!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
        $form = $this->_bform;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->_helper->redirector('modificapassword');
        }
        $values=$form->getValues();

        $us = $this->_utente->getUser();
        $virtual = array('username'      => $us['username'],
                         'password'      => $values['Password1'],
                         'email'         => $us['email'],
                         'num_telephone' => $us['num_telephone'],
                         'imgprofilo'    => $us['imgprofilo'],
                         'livello'       => $us['livello'],
                         'max_power'     => $us['max_power'],
                         'id_schema'     => $us['id_schema'],
                        );
        $this->_utente->updateUser($virtual);
        $this->_helper->redirector('index');
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
    
    //---
    protected function getEditPictureForm(){
        $urlHelper = $this->_helper->getHelper('url');
        $this->_aform = new Application_Form_User_Editpicture();
        $this->_aform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'salvamodprofilo'),
            'default'
        ));
        return $this->_aform;
    }
    protected function getEditPswForm(){
        $urlHelper = $this->_helper->getHelper('url');
        $this->_bform = new Application_Form_User_Editpass();
        $this->_bform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'salvamodpassword'),
            'default'
        ));
        return $this->_bform;
    }
}