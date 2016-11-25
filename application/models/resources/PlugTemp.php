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
        $select = $this->select()->where('id_schema = ?', $id);
        return $this->fetchAll($select);
    }
    
	public function getAllSchema(){
	    $select = $this->select()
	         ->distinct()
	         ->from(array('p' => 'PLUGTEMP'), array('id_schema','schema_name'))
	         ->group('id_schema','schema_name');
	    return $this->fetchAll($select);
    }
		
	public function getSchemaName()
	{
		$select = $this->select()->distinct()->from(array('p' => 'PLUGTEMP'), 'schema_name');
								   
		//$select = $this->select()->columns(array(new Expression('DISTINCT(schema_name) as schema_name')));
        return $this->fetchAll($select);
	}
    
    public function insertSchema($newP)
    {
        $this->insert($newP);
    }
   
   public function getMaxId(){
       $maxid = $this -> select()
                       -> from('PLUGTEMP', array("id" => "MAX(id_schema)"));
                      
        $result = $this->fetchRow($maxid);
        
       return $result['id'] + 1;
   }
   
   
    public function updateTemp($pr,$idtemp,$idplug)
    {
         $where[] = $this->getAdapter()->quoteInto('id_plug = ?', $idplug);   
         $where[] = $this->getAdapter()->quoteInto('id_schema = ?', $idtemp);
        $this->update($pr,$where);
    }
	
    public function deleteTemp($id)
    {
       $where = $this->getAdapter()->quoteInto('id_schema = ?', $id);   
       return $this->delete($where);
    }
}