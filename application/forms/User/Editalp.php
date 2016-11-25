<?php

class Application_Form_User_Editalp extends App_Form_Abstract
{

     protected $_utente;
    
    public function init()
    {}
    public function editform($id){
        $this->_utente=new Application_Model_User();
    
        $this->setMethod('post');
        $this->setName('editalp');
        $this->setAction('');
       
            $pList = $this->_utente->getSingleSchema($id);
            foreach ($pList as $key => $pl) {
             
            $id="priority".  $pl['id_plug'];                              
            $e = $this->createElement('select', $id);
            $e->setDecorators($this->elementDecorators);
            $optionClasses = array();
            for($a=1; $a<=10; $a++){
                $e->addMultiOption($a,$a);
            }
            $e->setValue($pl['priority']);
            $this->addElement($e);
            }
            
            
            
            
        $this->addElement('submit', 'aggiorna', array(
            'label'    => 'Aggiorna',
            'decorators' => $this->buttonDecorators,
            'class'      => 'btn-theme form-control mt20'
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
}
