<?php

class Application_Resource_Presa extends Zend_Db_Table_Abstract
{
    protected $_name    = 'PRESA';
    protected $_primary  = 'plug_id';
    protected $_rowClass = 'Application_Resource_Presa_Item';

    public function init()
    {
    }
	
	public function getPlug($id)
    {
        $select = $this->select()->where('plug_id = ?', $id); 
        return $this->fetchRow($select);
    }
    
    public function getAllPlugs()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }
  
    public function updatePlug($plug,$id)
    {
        $where = $this->getAdapter()->quoteInto('plug_id = ?', $id);
        
        $this->update($plug,$where);
    }
    
    public function setStatus($id){
        $where = $this->getAdapter()->quoteInto('id_plug = ?',$id);
        $this->update($form, $where);
    }
    
  
}