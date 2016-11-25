<?php

class UserController extends Zend_Controller_Action
{
    protected $_utente;	
    protected $_aform;
    protected $_bform;	
    protected $_cform;
    protected $_dform;	
    protected $_editPictureForm;
    protected $_editpswForm;
    protected $_schemaForm;
	protected $_modPlugForm;	
    protected $_nameform;
    protected $_crealpform;
    protected $_idplug;
    protected $_idtemp;
    protected $_nametemp;
    protected $_plugname;
    protected $session;
    protected $_editplform;
    
    public function init()
    {
    	$this->session = new Zend_Session_Namespace('Default'); // default namespace
		
        $this->_helper->layout->setLayout('user');    
        $this->_authService = new Application_Service_Auth();
        $this->_utente = new Application_Model_User();
        //---
        $this->_editPictureForm = $this->getEditPictureForm();
        $this->_editpswForm = $this->getEditPswForm();
		$this->_schemaForm = $this->getSchemaForm();
		$this->_modPlugForm = $this->getModPlugForm();
		$this->_crealpform = new Application_Form_User_Crealp();
        $this->getCreaLpForm();
        $this->_nameform = new Application_Form_User_Creanome();
        $this->getCreaNomeForm();
        $this->_editplform = new Application_Form_User_Editalp();
		if($this->session->eid!=null){
        $this->_editplform->editform($this->session->eid);
		}
    }
    
    public function indexAction()
    {
    	$un = $this->_authService->getIdentity()->username;
		$user = $this->_utente->getUserbyUsername($un);
    	$pList = $this->_utente->getSingleSchema($user['id_schema']);
		$plugsList =  null;
		$nomeSchema = null;
		foreach ($pList as $plk => $pl) {
			//$nomeSchema = $pl['schema_name'];
			$consumo = $this->_utente->getSinglePlugCons($pl['id_plug']);
			$p = $this->_utente->getPlug($pl['id_plug']);		
			if($p['plug_state'] != 1)
			{
				$c = 0;
			}else{
				$c = ($consumo['consumption']/$user['max_power'])*100;
			}
			$temp = $this->_utente->getSingleTemplateAll($p['id_template']);
			$icona = $temp['icon']; 
			$plugsList[] = array('icona' => $icona,
								 'priorita'=> $pl['priority'],
								 'plug_state' => $p['plug_state'], //0 - staccata; 1 - in funzione; 2 - spenta
								 'nome' => $p['mnemonic_name'],
								 'ID' => $p['plug_id'],
								 'consumo' => $c);
			$nomeSchema = $user['id_schema'];
		}
		$this->view->assign('nomeSchema', $nomeSchema);
		$this->view->assign('plugsList', $plugsList);
		$this->view->assign('schemaForm', $this->_schemaForm);
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
	
	public function changestateAction(){
		
        /*
         * Questo metodo viene chiamato dalla view nel metodo clickToggle tramite Ajax, passando
         * come parametro l'id della presa da cui il toggle è stato attivato. Sostituire quindi
         * $_GET[id_plug] col parametro.
         */
        $id = $this->_getParam('id_plug');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $presa = $this->_utente->getPlug($id);
        $new_state = null;
        if($presa["plug_state"]==1)
            $new_state = 2;
        else if ($presa["plug_state"]==2)
            $new_state = 1;
        $virtual = array(
                        "plug_id"       => $presa["plug_id"],
                        "plug_priority" => $presa["plug_priority"],
                        "plug_state"    => $new_state,
                        "mnemonic_name" => $presa["mnemonic_name"],
                        "id_template"   => $presa["id_template"],
        );
        $this->_utente->updatePlug($virtual,$id);
		require_once 'Zend/Json.php';
		$a = TRUE;
        $a = Zend_Json::encode($a);
		echo $a;
    }

	public function modschemaAction()
	{
		$id = $this->_getParam('id_schema');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		
        $un = $this->_authService->getIdentity()->username;
		$user = $this->_utente->getUserbyUsername($un);
		
        $datiUt = array("username"       => $user["username"],
                        "password" => $user["password"],
                        "email"    => $user["email"],
                        "num_telephone" => $user["num_telephone"],
                        "imgprofilo"   => $user["imgprofilo"],
                        "livello"   => $user["livello"],
                        "max_power"   => $user["max_power"],
                        "id_schema"   => $id,                        
        );
        $this->_utente->updateUser($datiUt);
		
		require_once 'Zend/Json.php';
		$a = TRUE;
        $a = Zend_Json::encode($a);
		echo $a;
	}
	
	public function impostazioniplugAction()
	{
		$id = $this->_getParam('idPlug');
		$plug = $this->_utente->getPlug($id);
		$form = $this->_modPlugForm;
		$form->populate(array('idPlug' => $plug['plug_id'],
							  'plug_name' => $plug['mnemonic_name']));
		$this->view->assign('index', $plug['id_template']);
		$this->view->assign('modPlugForm', $form);
	}
	
	public function aggiornaplugAction()
	{
		$form = $this->_modPlugForm;
		if(!$form->isValid($_POST)){
			$form->setDescription('Attenzione: alcuni campi inseriti sono errati.');
			return $this->_helper->redirector('impostazioniplug','user');
		}
		$values = $form->getValues();
		var_dump($values);
		$plug = $this->_utente->getPlug($values['idPlug']);
		$plugInfo = array('plug_id' => $plug['plug_id'],
						  'plug_priority' => $plug['plug_priority'],
						  'plug_state' => $plug['plug_state'], 
						  'mnemonic_name' => $values['plug_name'],
						  'id_template' => $values['categorie'],);
		$this->_utente->updatePlug($plugInfo,$values['idPlug']);
		$this->_helper->redirector('index');
	}
	
	  public function creanomeAction(){
       
        $this->view->nomeform = $this->_nameform;
        $this->view->msg = 'msg';
    }
    
    public function mostraplugAction(){
        
        
        if (!$this->getRequest()->isPost()) {
             $this->_helper->redirector('index','user');
        }    
        $form = $this->_nameform;
        if (!$form->isValid($_POST)) {
          
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->_helper->redirector('creanome','index');
        }
        $values = $this->_nameform->getValues();
        $id = $this->_utente->getMaxId();
        $this->session->idtemp=$id;
        $this->session->nametemp = $values['schema_name'];
        $pList = $this->_utente->getAllPlugs();
        if($values['schema_name']!=null){
            $this->view->assign('nome', $values['schema_name']);
            $this->session->nametemp=$values['schema_name'];
        }else{
            $this->view->assign('nome',$this->session->nametemp);
        }
        $this->view->form = $this->_crealpform;
        $plugsList =  null;
        $nomeSchema = null;
        //var_dump($pList);
        foreach ($pList as $plk => $pl) {
            
            $plugsList[] = array('id_t'=> $id,
                                 'nome' => $pl['mnemonic_name'],
                                 'ID' => $pl['plug_id'] );
        }
        
        $this->view->assign('plugs', $plugsList);   
        $cat = null;
        $cat = $this->_utente->getAllTemplates();
        $categor = null;
        foreach ($cat as $key => $value) {
         $categor[]= array('id'=>$value['id_template'],
                            'name'=>$value['template_name']);
        }
        $this->view->assign('category', $categor);
        $this->view->assign('id', $id);   
        
    }

	public function crealpAction()
    {/*
       $val[]=array('schema_name'=>$this->_nametemp,
                    'id_plug'=>$this->_idplug,
                    'plug_name'=>$this->_plugname,
                    'priority'=>0);
       */
       $this->_crealpform->createForm( $this->session->idtemp, $this->session->nametemp, $this->session->idplug, $this->session->plugname,0);
       $this->getCreaLpForm();
       var_dump($this->session);
       $this->view->form = $this->_crealpform;
    } 
	public function inseriscilpAction()
    {
       if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index','user');
        }    
        $values=null;
        $pList = $this->_utente->getAllPlugs();
        foreach($pList as $plk => $pl){
            $a= 'priority'.$pl['plug_id'];
            $val=array('id_schema'=>$this->session->idtemp,
                      'id_plug' =>$pl['plug_id'],
                      'schema_name'=>$this->session->nametemp,
                      'priority'=>$_POST[$a]  );
                   
        $this->_utente->insertSchema($val);
     
        }
        
          $this->_helper->redirector('index','user');
    } 
    
    
	public function modificalpAction()
    {
        $val = $this->_utente->getAllSchema();
        $this->view->schemas=$val;
        
    } 
	
	public function editschemaAction()
    {
        $this->session->eid = $this->_getParam('modid');
        $result = $this->_utente->getSingleSchema($this->session->eid);
        $pList = $this->_utente->getAllPlugs();
        $this->view->plugs = $pList;
        $this->view->template = $result;
        $this->view->form = $this->_editplform;
    } 
    public function modificatempAction()
    {
       if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index','user');
        }    
        $values=null;
        $pList = $this->_utente->getSingleSchema($this->session->eid);
        foreach($pList as $plk => $pl){
            $a= 'priority'.$pl['id_plug'];
            $val=array('id_schema'=>$this->session->eid,
                         'id_plug' =>$pl['id_plug'],
                      'schema_name'=>$pl['schema_name'],
                      'priority'=>$_POST[$a]  );
                   
        $this->_utente->updateTemp($val,$val['id_schema'],$val['id_plug']);
     
        }
        
          $this->_helper->redirector('index','user');
    } 
    
	public function eliminalpAction()
    {
        $val = $this->_utente->getAllSchema();
        $this->view->schemas=$val;
        
    }
    
    public function eliminatlAction(){
        $id = $this->_getParam('id_template');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $delT = $this->_utente->deleteTemp($id);
        $a = TRUE;
        require_once 'Zend/Json.php';
        $a = Zend_Json::encode($a);
        echo $a;
    }

	
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
    
    public function consumopresaAction(){
        $ipl = $this->getParam('idPlug');
        $this->view->vals = $this->_utente->getPlugAllCons($ipl);
        $this->view->assign('idplug', $ipl);
    }
    
    
	protected function getCreaNomeForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_nameform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'mostraplug',
            ),
            'default'
        ));
        
    }
	
    protected function getCreaLpForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
       
        $this->_crealpform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'inseriscilp'),
            'default'
        ));
        
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
	
	 protected function getSchemaForm(){
        $urlHelper = $this->_helper->getHelper('url');
        $this->_cform = new Application_Form_User_Schema();
        $this->_cform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'index'),
            'default'
        ));
        return $this->_cform;
    }
	 
	 protected function getModPlugForm(){
        $urlHelper = $this->_helper->getHelper('url');
        $this->_dform = new Application_Form_User_ModPlug();
        $this->_dform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'aggiornaplug'),
            'default'
        ));
        return $this->_dform;
    }
}