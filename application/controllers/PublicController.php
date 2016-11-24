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
    
    public function loginAction(){
        $this->_helper->layout->setLayout('login');
        $this->view->loginForm = $this->_loginform;       
    }
    
    private function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $form = new Application_Form_Public_Auth_Login();
        $form->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action'     => 'authenticate'
                        ), 
                        'default',true
                    ));
        return $form;
    }
    
      private function getNewUserForm()
    {
         $urlHelper = $this->_helper->getHelper('url');
        $form = new Application_Form_Public_Signup_Newuser();
        $form->setAction($urlHelper->url(array(
                        'controller' => 'public',
                        'action'     => 'insertnewuser'
                        ), 
                        'default',true
                    ));
                    
        return $form;
    }
        public function authenticateAction()
    {
        /* Setto anche il layout del login oltre al reindirizzamento */
        $this->_helper->layout->setLayout('login');
        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        $form = $this->_loginform;
        $this->view->loginForm = $form; 
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('login');
        }
        if (false === $this->_authentication->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
      
        return $this->_helper->redirector('index', 'user');
    }

    public function signupAction()
    {
        $this->_helper->layout->setLayout('login');
        $this->view->signupForm = $this->_newuserform;    
    }
    
    public function insertnewuserAction()
    {
        $this->_helper->layout->setLayout('login');
         $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        $form = $this->_newuserform;
        $this->view->signupForm = $form;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('signup');
        }
            $values=$form->getValues();
           
        $results = array('Username'         => $values['Username'],
                         'Password'         => $values['Password'],
                         'Nome'             => $values['Nome'],
                         'Cognome'          => $values['Cognome'],
                         'Data_di_Nascita'  => $values['Data_di_Nascita'],
                         'Citta'            => $values['Citta'],
                         'Provincia'        => $values['Provincia'],
                         'Genere'           => $values['Genere'], 
                         'Codice_fiscale'   => $values['Codice_fiscale'],
                         'Email'            => $values['Email'],
                         'Telefono'         => $values['Telefono'],
                         'Categoria'        => 1,   
                         'Societa_staff'    => $values['Societa_staff'],
             );
            
            $this->_publicModel->insertNewUser($results);
         return $this->_helper->redirector('index', 'public');
    }
    
}