<?php

class Application_Model_User extends App_Model_Abstract
{
        
    public function __construct()
    {
       
    }
	
	//Consumo
	public function getConsSinglePlug($id)
    {
         return $this->getResource('Consumo')->getConsSinglePlug($id);
    }
    
        public function getAllConsumption()
    {
         return $this->getResource('Consumo')->getAllConsumption();
    }
	
	public function getSinglePlugCons($id)
    {
         return $this->getResource('Consumo')->getSinglePlugCons($id);
    }
	
	
	
    //Templates
    
    public function getAllTemplates()
    {
         return $this->getResource('Templates')->getAllTemplates();
    }
    
    public function getSingleTemplate($id)
    {
         return $this->getResource('Templates')->getSingleTemplate($id);
    }
	public function getSingleTemplateAll($id)
    {
         return $this->getResource('Templates')->getSingleTemplateAll($id);
    }
    
    //TempPriority
    
    public function getAllPriorities()
    {
         return $this->getResource('TempPriority')->getAllPriorities();
    }
    
    public function getSinglePriority($id)
    {
         return $this->getResource('TempPriority')->getSinglePriority($id);
    }
    
     public function insertPriority($newP)
    {
         return $this->getResource('TempPriority')->insertPriority($newP);
    }
     public function updatePr($pr,$id)
    {
         return $this->getResource('TempPriority')->updatePr($pr,$id);
    }
     public function deletePr($id)
    {
         return $this->getResource('TempPriority')->deletePr($id);
    }
    
    
    //Presa
    public function getPlug($id)
    {
         return $this->getResource('Presa')->getPlug($id);
    }
    
    public function getAllPlugs()
    {
         return $this->getResource('Presa')->getAllPlugs();
    }
    
    public function updatePlug($plug,$id)
    {
         return $this->getResource('Presa')->updatePlug($plug,$id);
    }
    public function setStatus($id)
    {
         return $this->getResource('Presa')->setStatus($id);
    }
	
  
    
    //Utente
    public function getUserbyUsername($username)
    {
         return $this->getResource('Utente')->getUserbyUsername($username);
    }
	public function getUser(){
        return $this->getResource('Utente')->getUser();
    }
    public function updateUser($form){
        return $this->getResource('Utente')->updateUser($form);
    }
	public function controllaPsw($username, $password)
	{
         if(count($this->getResource('Utente')->controllaPsw($username, $password)) == 1){
         	return true;
         }else{
         	return false;
         }
    }
    
    //PlugSchema
    public function getSingleSchema($id)
    {
         return $this->getResource('PlugTemp')->getSingleSchema($id);
    }
	public function getSchemaName()
	{
         return $this->getResource('PlugTemp')->getSchemaName();
    }
    public function insertSchema($newP)
    {
         return $this->getResource('PlugTemp')->insertSchema($newP);
    }
    public function getMaxId()
    {
         return $this->getResource('PlugTemp')->getMaxId();
    }
    public function updateTemp($pr,$idtemp,$idplug)
    {
         return $this->getResource('PlugTemp')->updateTemp($pr,$idtemp,$idplug);
    }
    public function deleteTemp($id)
    {
         return $this->getResource('PlugTemp')->deleteTemp($id);
    }
    public function getAllSchema()
    {
         return $this->getResource('PlugTemp')->getAllSchema();
    }
    
    

}