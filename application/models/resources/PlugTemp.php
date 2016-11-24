<?php

class Application_Resource_PlugTemp extends Zend_Db_Table_Abstract
{
    protected $_name    = 'PLUGTEMP';
    protected $_primary = array('id_schema','id_schema');
    protected $_rowClass = 'Application_Resource_PlugTemp_Item';

    public function init()
    {
    }
	
	    
    public function getSingleSchema($id)
    {
        $select = $this->select()
                               ->where('id_schema = ?', $id);
        return $this->fetchAll($select);
    }
    
    
    public function insertSchema($newP)
    {
        $this->insert($newP);
    }
   
   public function getMaxId(){
       $maxid = $this -> select()
                       -> from('PLUGTEMP', array("id" => "MAX(ID)"));
                      
        $result = $this->fetchRow($maxid);
        
       return $result['id'] + 1;
   }
   
   
     public function updateTemp($pr,$idtemp,$idplug)
    {
         $where[] = $this->getAdapter()->quoteInto('id_plug = ?', $idtemp);   
         $where[] = $this->getAdapter()->quoteInto('id_schema = ?', $idplug);
        $this->update($pr,$where);
    }
    
    public function deleteTemp($id)
    {
       $where = $this->getAdapter()->quoteInto('id_schema = ?', $id);   
        $this->delete($where);
    }
}