<?php

class Application_Model_User extends App_Model_Abstract
{
        
    public function __construct()
    {
       
    }
	
	//Consumo
	public function getConsSinglePlug($id)
    {
         return $this->getResource('CONSUMO')->getConsSinglePlug($id);
    }
    
    //Templates
    
    public function getAllTemplates()
    {
         return $this->getResource('TEMPLATES')->getAllTemplates();
    }
    
    public function getSingleTemplate($id)
    {
         return $this->getResource('TEMPLATES')->getSingleTemplate($id);
    }
    
    //TempPriority
    
    public function getAllPriorities()
    {
         return $this->getResource('TEMP_PRIORITY')->getAllPriorities();
    }
    
    public function getSinglePriority($id)
    {
         return $this->getResource('TEMP_PRIORITY')->getSinglePriority($id);
    }
    
     public function insertPriority($newP)
    {
         return $this->getResource('TEMP_PRIORITY')->insertPriority($newP);
    }
     public function updatePr($pr,$id)
    {
         return $this->getResource('TEMP_PRIORITY')->updatePr($pr,$id);
    }
     public function insertPriority($newP)
    {
         return $this->getResource('TEMP_PRIORITY')->deletePr($id);
    }
    
    
    //Presa
    public function getPlug($id)
    {
         return $this->getResource('PRESA')->getPlug($id);
    }
    
    public function updatePlug($plug,$id)
    {
         return $this->getResource('PRESA')->updatePlug($plug,$id);
    }
    
    
    //Utente
        public function getUserbyUsername($username)
    {
         return $this->getResource('UTENTE')->getUserbyUsername($username);
    }
}