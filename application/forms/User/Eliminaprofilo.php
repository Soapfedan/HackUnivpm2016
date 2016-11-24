<?php

class Application_Form_User_Eliminaprofilo extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('eliminaProf');
        $this->setAction('');
                
        $this->addElement('submit', 'elimina', array(
            'label'    => 'Eliminati',
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