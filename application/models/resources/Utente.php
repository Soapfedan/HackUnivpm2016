<?php

class Application_Resource_Utente extends Zend_Db_Table_Abstract
{
    protected $_name    = 'UTENTE';
    protected $_primary  = 'username';
    protected $_rowClass = 'Application_Resource_Utente_Item';

    public function init()
    {
    }
	
	public function getPlug($id)
    {
        $select = $this->select()->where('plug_id = ?', $id); 
        return $this->fetchRow($select);
    }
    
	public function insertUser($usrInfo)
    {
        $this->insert($usrInfo);
    }
   
    public function getUserbyUsername($username)
    {
       $select = $this->select()->where('username = ?', $username);  
       return $this->fetchRow($select);
    }

    public function updateUser($usrInfo,$username)
    {
        $dove="username='". $username. "'";
        $this->update($usrInfo,$dove);
    }
    
    public function updateUserById($usrInfo,$idUtente)
    {
        $dove="idUtente='". $idUtente. "'";
        $this->update($usrInfo,$dove);
    }
    
    public function deleteUser($username)
    {
        $dove="username='". $username. "' AND livello!='admin'";
        $this->delete($dove);
    }

	public function getPosizionestaffByUName($username)
	{
		return $this->getAdapter()->fetchRow($this->select()->where('username = ?', $username));  
	}
	
	public function setIdPosByUName($idPos, $uName)
	{
		//$data = array(
		//'idPosizione'=>$idPos );
		//$dove = 'username = ?'.$uName;
		//$this->update($_name, $data, $dove);
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
												    'host'     => 'localhost',
												    'username' => 'root',
												    'password' => 'root',
												    'dbname'   => 'grp_04_db'
												));
		$data      = array('idPosizione' => $idPos); 
		$where[] = $db->quoteInto('username = ?', $uName); 
		$db->update($this->_name, $data, $where); 
		//$where = $this->getAdapter()->quoteInto('username = ?', $this->uName);
		//$data = array('idPosizione'=>$idPos );
		//$this->update($data, $where);
	}
	
}