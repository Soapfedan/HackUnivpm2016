<?php

class Application_Resource_Templates extends Zend_Db_Table_Abstract
{
    protected $_name    = 'TEMPLATES';
    protected $_primary = 'id_template';
    protected $_rowClass = 'Application_Resource_Templates_Item';

    public function init()
    {
    }
	
    public function getAllTemplates()
    {
        $select = $this->select()
                        ->from(array('p' => 'TEMPLATES'),
                               array('id_template', 'template_name'));
                               
        return $this->fetchAll($select);
    }
    
    public function getSingleTemplate($id)
    {
        $select = $this->select()
                               ->where('id_template = ?', $id);
        return $this->fetchRow($select);
    }
	
}