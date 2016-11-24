<?php

class Application_Form_User_Modcredenziali extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('modCredenziali');
        $this->setAction('');
        
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Username',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3'
            ));
        
        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Password',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3'
            ));
            
        $this->addElement('password', 'passwordtest', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Rip password',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3'
            ));

        $this->addElement('submit', 'aggiorna', array(
            'label'      => 'Aggiorna',
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
