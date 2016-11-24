<?php

class Application_Resource_TempPriority extends Zend_Db_Table_Abstract
{
    protected $_name    = 'TEMP_PRIORITY';
    protected $_primary = 'temp_priority_id';
    protected $_rowClass = 'Application_Resource_TempPriority_Item';

    public function init()
    {
    }
	
	public function getAllPriorities()
    {
        $select = $this->select();                        
                               
        return $this->fetchAll($select);
    }
    
    public function getSinglePriority($id)
    {
        $select = $this->select()
                               ->where('temp_priority_id = ?', $id);
        return $this->fetchRow($select);
    }
    
    
	public function insertPriority($newP)
    {
         $maxid = $this -> select()
                       -> from('TEMP_PRIORITY', array("id" => "MAX(temp_priority_id)"));
                      
        $result = $this->fetchRow($maxid);
        
        $newP['temp_priority_id']= $result['id'] + 1;
        $this->insert($newP);
    }
   
     public function updatePr($pr,$id)
    {
         $where = $this->getAdapter()->quoteInto('temp_priority_id = ?', $id);   
      
        $this->update($pr,$where);
    }
    
    public function deletePr($id)
    {
       $where = $this->getAdapter()->quoteInto('temp_priority_id = ?', $id);   
        $this->delete($where);
    }

	
	
}