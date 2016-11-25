<?php

class Application_Resource_Consumo extends Zend_Db_Table_Abstract
{
    protected $_name    = 'CONSUMO';
    protected $_primary = array('plug_id','timestamp');
    protected $_rowClass = 'Application_Resource_Consumo_Item';

    public function init()
    {
    }
	
	public function getConsSinglePlug($id)
    {
        $select = $this->select()->where('plug_id = ?', $id); 
        return $this->fetchAll($select);
    }
	
     public function getAllConsumption(){
          $sum = $this -> select()
                       -> from('CONSUMO', array("id" => "SUM(consumption)"));
            
        $result = $this->fetchRow($sum);
        
       
        return $result;
     }
	 
	public function getSinglePlugCons($id)
    {
        $select = $this->select()->where('plug_id = ?', $id)->order('timestamp DESC'); 
        return $this->fetchRow($select);
    }
    
    public function getPlugAllCons($id){
        $select = $this->select()->where('plug_id = ?', $id)->order('timestamp DESC'); 
        return $this->fetchAll($select);
    }
}