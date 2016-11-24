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
        $this->view->pForm=$this->getPosizioneForm();
        $this->view->mpForm=$this->getModProfiloForm();
        $this->view->epForm=$this->getEliminaProfiloForm();
		$this->view->seForm=$this->getSegnalazioneForm();
        
		$un = $this->_authService->getIdentity()->username;
		$idPos = $this->_utente->getUserByUName($un);
		$this->view->idPos = $idPos['idPosizione'];
		if(($idPos['idPosizione']) != null){
			$datiPosizione = $this->_utente->getDataByIdPosizione($idPos['idPosizione']);
			$this->view->data = $datiPosizione;
			$imm = $this->_utente->getMappaEvaquazioneByEdifPianoZona($datiPosizione['edificio'], $datiPosizione['piano'], $datiPosizione['zona']);
			$base64 = base64_encode($imm['mappaEvaquazione']);
			$this->view->planimetriaCorretta = 'data:image/png;base64,'.$base64;
            $this->view->assign('posizione',$datiPosizione['edificio']);
		}
        //passaggio informazioni alle notifiche
        
        $avvisi=$this->_utente->getAvvisiByDate();     
        $elavvisi=$this->_utente->getAllElAvvisi();
        $posiz=$this->_utente->getPosizione();
        $this->view->assign(array('dataNotifica'=>$avvisi));
        $this->view->assign(array('tipoNotifica'=>$elavvisi));
        $this->view->assign(array('doveNotifica'=>$posiz));

    }
    
    public function indexAction()
    {} 
    
    public function viewstaticAction () 
    {}
    
    public function profiloAction () 
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

	
    public function edificioAction () 
    {}


    public function posizioneAction () 
    {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		
        if ($this->getRequest()->isXmlHttpRequest()) {
        	//Prendo i due parametri passati con l'ajax
            $this->_piano = $this->_getParam('pia');
			$this->_edificio = $this->_getParam('edif');
			
			//Prendo l'id planimetria corretto e attraverso quello prendo la mappa corrispondente
            $idPlan = $this->_utente->getIdPlanimetriaByEdificioPiano($this->_edificio, $this->_piano);
			$mappa = $this->_utente->getPlanimetriaById($idPlan['idPlanimetria']);	
			//Istanzio la session e salvo i parametri piano ed edificio		
			$session = new Zend_Session_Namespace('session');
            $session->_piano = $this->_getParam('pia');
			$session->_edificio = $this->_getParam('edif'); 
			//Codifico l'immagine e assieme metto il map           
            $base64 = base64_encode($mappa['mappa']);
			$image = 'data:image/png;base64,'.$base64;
			$map = $mappa['map'];
			$a = array("mappa"=>$image,
					   "map"=>$map);
						require_once 'Zend/Json.php';
			//Codifico i dati in formato Json e li rimando indietro
			require_once 'Zend/Json.php';
            $a = Zend_Json::encode($a);
			echo $a;
        } 
    }
    
	public function mappasegnalazioneAction () 
    {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		
        if ($this->getRequest()->isXmlHttpRequest()) {
        	$us=$this->_authService->getIdentity()->username;
			$utente	 = $this->_utente->getUserByUName($us);
			
			$date = new Zend_Date(); 
			$dd= $date->get('dd');
			$MM = $date->get('MM');
			$yyyy =$date->get('YYYY');
			$HH = $date->get('HH');
			//$mm = $date->get('mm');
			//$ss = $date->get('ss');
			
			$a = 1;
			if($this->_utente->getAvvisoByIdUtente($utente['idUtente'], $MM, $yyyy, $dd, $HH)){  
	        	//Prendo i due parametri passati con l'ajax
	            $_avviso = $this->_getParam('av');
				
				$IdAvviso = $this->_utente->getIdElAvvisoByTipo($_avviso);
				$a = $IdAvviso['idElencoAvviso'];
				//Istanzio la session e salvo il parametro idAvviso		
				$session = new Zend_Session_Namespace('session');
	            $session->_idavviso = $a;
				
				$idPos = $this->_utente->getUserByUName($us);
				
				$dat = $this->_utente->getDataByIdPosizione($idPos['idPosizione']);
				
				//Prendo l'id planimetria corretto e attraverso quello prendo la mappa corrispondente
	            $idPlan = $this->_utente->getIdPlanimetriaByEdificioPiano($dat['edificio'], $dat['piano']);
				$mappa = $this->_utente->getPlanimetriaById($idPlan['idPlanimetria']);	
				//Codifico l'immagine e assieme metto il map           
	            $base64 = base64_encode($mappa['mappa']);
				$image = 'data:image/png;base64,'.$base64;
				$map = $mappa['map'];
				$a = array("mappa"=>$image,
						   "map"=>$map);
							require_once 'Zend/Json.php';
				//Codifico i dati in formato Json e li rimando indietro
				require_once 'Zend/Json.php';
	            $a = Zend_Json::encode($a);
            }
			echo $a;
        } 
    }
	
	public function aulaAction () 
    {
    	//Prendo l'aula passata attraverso la selezione dall'immagine
    	$aula = $this->getParam('au');
		//Creo un'istanza della sessione per poter prendere i parametri precedentemente salvati
    	$session = new Zend_Session_Namespace('session');
		//Prelevo l'id posizione relativo all'edificio, il piano e l'aula
		$idPos = $this->_utente->getIdPosizioneByEdPiAl($session->_edificio, $session->_piano, $aula);
		//Prendo l'username e attraverso quello imposto l'id posizione corretto e faccio il redirect all'index
		$uName=$this->_authService->getIdentity()->username;
		$this->_utente->setIdPosByUName($idPos['idPosizione'], $uName);
		$this->_helper->redirector('index');
    }
	
	public function aulasegnalazioneAction ()
	{		
		//Prendo l'aula passata attraverso la selezione dall'immagine
    	$aula = $this->getParam('aus');
		$us=$this->_authService->getIdentity()->username;
		$utente	 = $this->_utente->getUserByUName($us);	
			
		$dat = $this->_utente->getDataByIdPosizione($utente['idPosizione']);	
		
		$idPos = $this->_utente->getIdPosizioneByEdPiAl($dat['edificio'], $dat['piano'], $aula);
		
		$date = new Zend_Date(); 
		$createdDate= $date->get('YYYY-MM-dd HH:mm:ss');
		 
		//Creo un'istanza della sessione per poter prendere i parametri precedentemente salvati
    	$session = new Zend_Session_Namespace('session');
		
		$avviso = (array('idPosizione'=>$idPos['idPosizione'],
					  'idUtente'=> $utente['idUtente'],
					  'data'=>$createdDate,
					  'idElencoAvviso'=>$session->_idavviso,
		));
		$this->_utente->inserisciSegnalazione($avviso);
		
		$this->_helper->redirector('index');
	}
	
    public function pianoAction () 
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		
        if ($this->getRequest()->isXmlHttpRequest()) {
        	//Prendo l'edificio passato con l'ajax
            $_edificio = $this->_getParam('edif');
			//Ricerco le corrispondenti aule e le rimando indietro in formato Json
            $piano = $this->_utente->getPianoByEdificio($_edificio);		
            require_once 'Zend/Json.php';
            $a = Zend_Json::encode($piano);
            echo $a;
        } 
    }
	
	public function modificaposizioneAction () 
    {
    	//Prendo l'user e modifico a NULL il suo id posizione nel DB
    	$us = $this->_authService->getIdentity()->username;
    	$this->_utente->setIdPosByUName(null, $us);
    	$this->_helper->redirector('index');
    }
	
	public function pericoloAction () 
    {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		
        if ($this->getRequest()->isXmlHttpRequest()) {
        	$us = $this->_authService->getIdentity()->username;
			$utente	 = $this->_utente->getUserByUName($us);
			$posUser = $this->_utente->getDataByIdPosizione($utente['idPosizione']);
        	$pericolo = $this->_utente->getPericolo($posUser['edificio']);
			if($pericolo){
					$tipoAvv = $this->_utente->getAvvisoById($pericolo['idElencoAvviso']);
					$immag = $this->_utente->getMappaEvaquazioneByEdifPianoZona($posUser['edificio'], $posUser['piano'], $posUser['zona']);
					
					$base64 = base64_encode($immag['mappaEvaquazione']);
					$planimetriaEvacuazione = 'data:image/png;base64,'.$base64;
					$arrayPericolo = array('tipoAvviso'=> $tipoAvv['tipoAvviso'],
										   'immEvac'=>$planimetriaEvacuazione);
										   
		        	require_once 'Zend/Json.php';
		            $ap = Zend_Json::encode($arrayPericolo);
					
		        	echo $ap;
				
			}
        }
    }
    
	public function segnalazioneAction()
	{}
    
    public function eliminaprofiloAction () 
    {}
    
    public function confermaeliminazioneprofiloAction()
    {
        $un=$this->_authService->getIdentity()->username;
        $this->_utente->deleteUser($un);
        $this->_helper->redirector('index','public');
    }
    
    protected function getEliminaProfiloForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_epform = new Application_Form_User_Eliminaprofilo();
        $this->_epform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'confermaeliminazioneprofilo'),
            'default'
        ));
        return $this->_epform;
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
    
    protected function getPosizioneForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_pform = new Application_Form_User_Posizione();
        $this->_pform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'index'),
            'default'
        ));
        return $this->_pform;
    }
	
	protected function getSegnalazioneForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_seform = new Application_Form_User_Segnalazione();
        $this->_seform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'index'),
            'default'
        ));
        return $this->_seform;
    }
}