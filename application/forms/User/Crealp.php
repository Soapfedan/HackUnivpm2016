<?php

class Application_Form_User_Crealp extends App_Form_Abstract
{

     protected $_utente;
    
    public function init()
    {
        $this->_utente=new Application_Model_User();
    
        $this->setMethod('post');
        $this->setName('crealp');
        $this->setAction('');
        /*
        $this->addElement('text', 'id_template', array(
            //'required'   => true,
            'label'      => 'Id dello schema',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3',
            'value' =>$idt,
           // 'attribs'    => array('disabled' => 'disabled')
            
            ));
                
        $this->addElement('text', 'schema_name', array(
            'filters'    => array('StringTrim'),
            
            //'required'   => true,
            'label'      => 'Nome dello schema',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3',
            'value' =>$sn,
          //'attribs'    => array('disabled' => 'disabled')
            
            ));
            
                   
              
            $this->addElement('text', 'id_plug', array(
            
           // 'required'   => true,
            'label'      => 'Presa',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3',
            'value' =>$pi,
            //'attribs'    => array('disabled' => 'disabled')
            ));
            
             $this->addElement('text', 'plug_name', array(
            
            //'required'   => true,
            'label'      => 'Plug_name',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3',
            'value' =>$pn,
            //'attribs'    => array('disabled' => 'disabled')
            ));
            */
            $pList = $this->_utente->getAllPlugs();
            foreach ($pList as $key => $pl) {
             
            $id="priority".  $pl['plug_id']  ;                              
            $e = $this->createElement('select', $id);
            /*$e->setLabel('Priority')
                ->setAttrib('size', 1);*/
            $e->setDecorators($this->elementDecorators);
            //$e->setAttribs(array('class'  => 'form-control mt3'));
            $optionClasses = array();
            for($a=1; $a<=10; $a++){
                $e->addMultiOption($a,$a);
            }
            $e->setValue(1);
            $this->addElement($e);
            }
            
            
            
            
        $this->addElement('submit', 'inserisci', array(
            'label'    => 'Inserisci',
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
