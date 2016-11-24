<?php

class Application_Resource_Consumo extends Zend_Db_Table_Abstract
{
    protected $_name    = 'consumo';
    protected $_primary = array('plug_id','date','time');
    protected $_rowClass = 'Application_Resource_Consumo_Item';

    public function init()
    {
    }
	
	public function getConsSinglePlug($id)
    {
        $select = $this->select()->where('plug_id = ?', $id); 
        return $this->fetchAll($select);
    }
    
	
}