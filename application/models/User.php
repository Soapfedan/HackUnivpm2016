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
    
        public function getAllConsumption()
    {
         return $this->getResource('CONSUMO')->getAllConsumption();
    }
	
	public function getSinglePlugCons($id)
    {
         return $this->getResource('CONSUMO')->getSinglePlugCons($id);
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
	public function getSingleTemplateAll($id)
    {
         return $this->getResource('TEMPLATES')->getSingleTemplateAll($id);
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
     public function deletePr($id)
    {
         return $this->getResource('TEMP_PRIORITY')->deletePr($id);
    }
    
    
    //Presa
    public function getPlug($id)
    {
         return $this->getResource('PRESA')->getPlug($id);
    }
    
    public function getAllPlugs()
    {
         return $this->getResource('PRESA')->getAllPlugs();
    }
    
    public function updatePlug($plug,$id)
    {
         return $this->getResource('PRESA')->updatePlug($plug,$id);
    }
    public function setStatus($id)
    {
         return $this->getResource('PRESA')->setStatus($id);
    }
	
  
    
    //Utente
    public function getUserbyUsername($username)
    {
         return $this->getResource('UTENTE')->getUserbyUsername($username);
    }
	public function getUser(){
        return $this->getResource('UTENTE')->getUser();
    }
    public function updateUser($form){
        return $this->getResource('UTENTE')->updateUser($form);
    }
    
    //PlugSchema
    public function getSingleSchema($id)
    {
         return $this->getResource('PLUGTEMP')->getSingleSchema($id);
    }
	public function getSchemaName()
	{
         return $this->getResource('PLUGTEMP')->getSchemaName();
    }
    public function insertSchema($newP)
    {
         return $this->getResource('PLUGTEMP')->insertSchema($newP);
    }
    public function getMaxId()
    {
         return $this->getResource('PLUGTEMP')->getMaxId();
    }
    public function updateTemp($pr,$idtemp,$idplug)
    {
         return $this->getResource('PLUGTEMP')->updateTemp($pr,$idtemp,$idplug);
    }
    public function deleteTemp($id)
    {
         return $this->getResource('PLUGTEMP')->deleteTemp($id);
    }
    public function getAllSchema()
    {
         return $this->getResource('PLUGTEMP')->getAllSchema();
    }
    
    

}