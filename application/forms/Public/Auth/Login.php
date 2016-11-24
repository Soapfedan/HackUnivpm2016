<?php

class Application_Form_Public_Auth_Login extends App_Form_Abstract
{
	public function init()
    {
        $this->setMethod('post');
        $this->setName('login');
        $this->setAction('');
    	
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Username',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control mt5 ml25',
            ));
        
        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Password',
            'decorators' => $this->elementDecorators,
            'class' => 'form-control mt5 ml25',
            ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Entra',
            'decorators' => $this->buttonDecorators,
            'class' => 'btn-theme form-control mt10'
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
