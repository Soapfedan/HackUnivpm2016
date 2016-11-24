<?php

class AccessController extends Zend_Controller_Action
{
    protected $_form;
	protected $_regForm;
    protected $_authService;
	protected $_userModel;
    
    public function init()
    {
        $this->_helper->layout->setLayout('login');
        $this->_userModel = new Application_Model_User();
        $this->_authService = new Application_Service_Auth();
        $this->view->loginForm = $this->getLoginForm();
        $this->view->registerForm=$this->getRegForm();
    }
    
    public function indexAction()
    {} 
    
    public function viewstaticAction () 
    {}
    
    public function loginAction()
    {}
       
    public function registrazioneAction()
    {}
	
	public function newregAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
		$form=$this->_regForm;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('registrazione');
        }
        $values = $form->getValues();
        if($values['password']==$values['passwordtest']){
            $values['livello']='user';
            $image=APPLICATION_PATH . '/../public/images/temp/'.$values['imgprofilo'];
            $data=file_get_contents($image);
            $values['imgprofilo']=$data;
            unset($values['passwordtest']);
       	    $this->_userModel->insertUser($values);
            $this->authenticateAction();
        }else{
            $form->setDescription('Attenzione: le password non corrispondono.');
            return $this->render('registrazione');
        }
    } 
	

    public function authenticateAction()
    {        
        $request = $this->getRequest();
        
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        
        $form = $this->_form;
        
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('login');
        }
        
        if (false === $this->_authService->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        
		if($this->_authService->getIdentity()->livello == 'user')
		{
			//Elimino la posizione dell'utente
	    	$un = $this->_authService->getIdentity()->username;
			$this->_userModel->setIdPosByUName(null, $un);
		
		}
        return $this->_helper->redirector('index', $this->_authService->getIdentity()->livello);
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
    
    protected function getRegForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_regForm = new Application_Form_Public_Reg_Registrazione();
        $this->_regForm->setAction($urlHelper->url(array(
            'controller' => 'access',
            'action' => 'newreg'),
            'default'
        ));
        return $this->_regForm;
    
    }
	
            

}