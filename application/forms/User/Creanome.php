<?php

class Application_Form_User_Creanome extends App_Form_Abstract
{
  
    public function init()
    {
    
        $this->setMethod('post');
        $this->setName('creanomelp');
        $this->setAction('');
        
                
        $this->addElement('text', 'schema_name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome dello schema ',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3',
            ));
             
        $this->addElement('submit', 'sceglinome', array(
            'label'    => 'Scegli nome',
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
    