<?php

class Application_Form_User_Posizione extends App_Form_Abstract
{
    protected $_usr;
    
    public function init()
    {
        $this->_usr=new Application_Model_User();
        $edifici=$this->_usr->getEdifici(); 
        
        $this->setMethod('post');
        $this->setName('setPosizione');
        $this->setAction('');
        
        $this->addElement('select', 'edificio', array(
            'required'   => true,
            'label'      => 'Edificio',
            
            'MultiOptions' => array('0' => '-- Seleziona Edificio --'),
            'onChange' => 'FillPiani()',
            'class'    => 'form-control'
            ));
		
		$i = 1;
		foreach ($edifici as $ed) {
			$this->edificio->addMultiOption($i,$ed['value']);
			$i = $i+1;
		}
		
		
        $this->addElement('select', 'piano', array(
            'required'   => true,
            'label'      => 'Piano',
            'MultiOptions' => array('0' => '-- Seleziona Piano --'),
            'onChange' => 'FillMap()',
            'class'    => 'form-control'
            ));
			
			
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
