<?php

class Application_Form_Public_Reg_Registrazione extends App_Form_Abstract
{
	protected $_userModel;
	
	public function init()
    {
    	$this->_userModel = new Application_Model_User();              
        $this->setMethod('post');
        $this->setName('registrazione');
        $this->setAction('');
    	
        $this->addElement('file', 'imgprofilo', array(
            'label' => 'Img profilo',
            'destination' => APPLICATION_PATH . '/../public/images/temp',
            'validators' => array( 
                    array('Count', false, 1),
                    array('Size', false, 102400),
                    array('Extension', false, array('jpg', 'gif', 'png'))),
            'decorators' => $this->fileDecorators,
            'class' =>  'ml3'
                    )); 
        
        $this->addElement('text', 'nome', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
            ));
            
        $this->addElement('text', 'cognome', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Cognome',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
            ));
            
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Username',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
            ));
        
        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Password',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
            ));
            
        $this->addElement('password', 'passwordtest', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Ripeti password',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
            ));
            
		$this->addElement('radio', 'genere', array(
			'label'      => 'Genere',
			'MultiOptions'=>array(
                'male' => 'M',
            	'female' => 'F',),
			'decorators' => $this->radioDecorators, 
		));
			
		$this->addElement('text', 'email', array(
			'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 35))
            ),
            'required'   => true,
            'label'      => 'E-mail',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
		));	
			
		$this->addElement('text', 'eta', array(
			'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Data di nascita',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
		));	

		$this->addElement('text', 'telefono', array(
			'filters'    => array('StringTrim'),
            'validators' => array(
            	array('Int'),
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Telefono',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
		));
        
        $this->addElement('text', 'indirizzo', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Indirizzo',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control2 mt5 ml3',
            ));
			
        $this->addElement('submit', 'registrazione', array(
            'label'    => 'Registrati',
            'decorators' => $this->buttonDecorators,
            'class' => 'btn-theme form-control3 mt20'
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
