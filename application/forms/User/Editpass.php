<?php

class Application_Form_User_Editpass extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('editPass');
        $this->setAction('');
        
        $this->addElement('password', 'Password1', array(
            //'label' => 'Nuova password (almeno 5 caratteri)',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(5,30))),
            'decorators' => $this->elementDecorators,
            'class'      => 'btn-theme form-control mt20'
            ));
        /*$this->addElement('password', 'Password', array(
            'label' => 'Ripeti password (almeno 5 caratteri)',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(5,30))),
            'decorators' => $this->elementDecorators,
        ));*/
        
        $this->addElement('submit', 'aggiorna   ', array(
            'label'    => 'Aggiorna',
            'decorators' => $this->buttonDecorators,
            'class'      => 'btn-theme form-control mt20 oncenter1',
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form', 'style' => 'position: relative; left:140px')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
