<?php

class Application_Form_User_Schema extends App_Form_Abstract
{
    protected $_usr;
    
    public function init()
    {
        $this->_usr=new Application_Model_User();
		
        $templates = $this->_usr->getSchemaName();
        
        $this->setMethod('post');
        $this->setName('setSchema');
        $this->setAction('');
        
        $this->addElement('select', 'template', array(
            'required'   => true,
            'label'      => 'Seleziona il template:',
            
            'onChange' => 'ChangeSchema()',
            'class'    => 'form-control'
            ));
		$i = 0;
		foreach ($templates as $tl) {
			$this->template->addMultiOption($i,$tl['schema_name']);
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
