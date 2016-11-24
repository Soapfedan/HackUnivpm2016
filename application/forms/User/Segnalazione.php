<?php

class Application_Form_User_Segnalazione extends App_Form_Abstract
{
    protected $_usr;
    
    public function init()
    {
        $this->_usr=new Application_Model_User();
        $avvisi=$this->_usr->getElAvvisi();
        
        $this->setMethod('post');
        $this->setName('setPosizione');
        $this->setAction('');
        
        $this->addElement('select', 'avvisi', array(
            'required'   => true,
            'label'      => 'Avviso',
            
            'MultiOptions' => array('0' => '-- Seleziona Avviso --'),
            'onChange' => 'MappaSegnalazione()',
            'class'    => 'form-control'
            ));
		
		$i = 1;
		foreach ($avvisi as $av) {
			$this->avvisi->addMultiOption($i,$av['value']);
			$i = $i+1;
		}			
			
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
