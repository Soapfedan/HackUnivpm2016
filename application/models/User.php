<?php

class Application_Model_User extends App_Model_Abstract
{
        
    public function __construct()
    {
       
    }
	
	//Consumo
	public function getConsSinglePlug($id)
    {
         return $this->getResource('Utente')->getConsSinglePlug($id);
    }
    
    //User
    
    //Presa
    
    //Utente
        public function getUserbyUsername($username)
    {
         return $this->getResource('Utente')->getUserbyUsername($username);
    }
}