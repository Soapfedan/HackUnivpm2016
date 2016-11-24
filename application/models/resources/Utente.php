<?php

class Application_Resource_Utente extends Zend_Db_Table_Abstract
{
    protected $_name    = 'UTENTE';
    protected $_primary  = 'username';
    protected $_rowClass = 'Application_Resource_Utente_Item';

    public function init()
    {
    }
	

    public function getUserbyUsername($username)
    {
       $select = $this->select()->where('username = ?', $username);  
       return $this->fetchRow($select);
    }
 
	
}