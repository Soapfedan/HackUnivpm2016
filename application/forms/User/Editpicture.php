<?php

class Application_Form_User_Editpicture extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('editPicture');
        $this->setAction('');
        
        $this->addElement('file', 'imgprofilo', array(
            //'label' => 'Img profilo',
            'destination' => APPLICATION_PATH . '/../public/images/temp',
            'required' => true,
            'validators' => array( 
                    array('Count', false, 1),
                    array('Size', false, 102400),
                    array('Extension', false, array('jpg', 'gif', 'png'))),
            'decorators' => $this->fileDecorators,
            'class'      => 'btn-theme form-control mt20'
                    ));
        $this->addElement('submit', 'aggiorna   ', array(
            'label'    => 'Aggiorna',
            'decorators' => $this->buttonDecorators,
            'class'      => 'btn-theme form-control mt20 oncenter2'
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form', 'style' => 'position: relative; left:100px')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
