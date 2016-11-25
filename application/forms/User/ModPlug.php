<?php

class Application_Form_User_ModPlug extends App_Form_Abstract
{
    protected $_usr;
    
    public function init()
    {
        $this->_usr=new Application_Model_User();
		
        $categorie = $this->_usr->getAllTemplates();
        
        $this->setMethod('post');
        $this->setName('modPlug');
        $this->setAction('');
        
		$this->addElement('hidden', 'idPlug', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(1, 25))
            ),
            'required'   => true,
            ));
			
		$this->addElement('text', 'plug_name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome della presa: ',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control'
            ));
			
        $this->addElement('select', 'categorie', array(
            'required'   => true,
            'label'      => 'Categoria: ',
            'class'    => 'form-control'
            ));
		$i = 0;
		foreach ($categorie as $c) {
			$this->categorie->addMultiOption($i,$c['template_name']);
			$i = $i+1;
		}	
		
		$this->addElement('submit', 'aggiorna   ', array(
            'label'    => 'Aggiorna',
            'decorators' => $this->buttonDecorators,
            'class'      => 'btn-theme form-control mt20'
        ));
			
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
