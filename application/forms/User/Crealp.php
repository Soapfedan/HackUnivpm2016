<?php

class Application_Form_User_Crealp extends App_Form_Abstract
{
    protected $_userModel;
    
    public function init()
    {
        $this->_userModel = new Application_Model_User();              
        $this->setMethod('post');
        $this->setName('crealp');
        $this->setAction('');
        
                
        $this->addElement('text', 'schema_name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome dello schema',
            'decorators' => $this->elementDecorators,
            'class'      => 'form-control mt3'
            ));
            
        $values = $this->_userModel->getFloors($imm);
            $valuearr = $values->toArray();
                // Crea un radioButton
            $radio = new Zend_Form_Element_Radio('floors');
                // Cicla sulla lista di piani e aggiunge l'opzione relativa al radioButton
            foreach($valuearr as $floor){
                $radio->addMultiOption($floor['Id_piano'], 'Piano '.$floor['Id_piano']);
            }
            
        $this->addElement('submit', 'aggiorna   ', array(
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
