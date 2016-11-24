<?php

class Application_Model_User extends App_Model_Abstract
{
        
    public function __construct()
    {
       
    }
	
	//AVVISI
	public function getAvvisi()
    {
         return $this->getResource('Avvisi')->getAvvisi();
    }
    
    public function getAvvisiByDate()
    {
         return $this->getResource('Avvisi')->getAvvisiByDate();
    }
    
    

	public function inserisciSegnalazione($seInfo)
	{
		return $this->getResource('Avvisi')->inserisciSegnalazione($seInfo);		
	}
	
	public function getAvvisoByIdUtente($IdUtente, $MM, $yyyy, $dd, $HH)
	{
		$data = $this->getResource('Avvisi')->getAvvisoByIdUtente($IdUtente, $MM, $yyyy, $dd);
		$c = count($data);
		if($c != 0){
			foreach ($data as $d){
			$dateString = Zend_Locale_Format::getDate($d['data'],
											array('date_format' => 'YYYY-MM-dd HH:mm:ss'));		
				$h = $dateString['hour'];
				if(($HH-$h)<4){
					return false;
				}
			}
		}
		return true;
	}
	
	public function getPericolo($edificio)
	{
		return $this->getResource('Avvisi')->getPericolo($edificio);
	}
	
	//CATEGORIE
	
	//ELENCO AVVISI
	public function getElAvvisi()
	{
		return $this->getResource('ElencoAvvisi')->getElAvvisi();
	}	
    
    public function getAllElAvvisi()
    {
        return $this->getResource('ElencoAvvisi')->getAllElAvvisi();
    }   
	
	public function getIdElAvvisoByTipo($TAvviso)
	{
		return $this->getResource('ElencoAvvisi')->getIdElAvvisoByTipo($TAvviso);
	}
	
	public function getAvvisoById($id)
    {
        return $this->getResource('ElencoAvvisi')->getElAvvisoById($id);
    }
	
	//FAQ
	
	//MAPPA EVAQUAZIONE
	public function getMappaEvaquazioneByEdifPianoSel($edificio, $piano)
	{
	   return $this->getResource('MappaEvaquazione')->getMappaEvaquazioneByEdifPianoSel($edificio, $piano);
	}

	public function getMappaEvaquazioneByEdifPianoZona($edificio, $piano, $zona)
	{
	   return $this->getResource('MappaEvaquazione')->getMappaEvaquazioneByEdifPianoZona($edificio, $piano, $zona);
	}
	
    public function getMappaEvaquazioneById($idmappa)
    {
        return $this->getResource('MappaEvaquazione')->getMappaEvaquazioneById($idmappa);
    }
    
    public function getMappaEvaquazioneOrderById()
    {
       return $this->getResource('MappaEvaquazione')->getMappaEvaquazioneOrderById();
    }
    
    public function aggiungiMappaEvaquazione($mapInfo)
    {
       return $this->getResource('MappaEvaquazione')->aggiungiMappaEvaquazione($mapInfo);
    }
     
     public function deleteMapEv($mapID)
     {
       return $this->getResource('MappaEvaquazione')->deleteMapEv($mapID);
     }
     
     public function modificaMapEv($mapInfo,$ID)
    {
        return $this->getResource('MappaEvaquazione')->modificaMapEv($mapInfo,$ID);
    }
    
    
	//PLANIMETRIE
	public function getPlanimetriaById($idPlanimetria)
	{
		return $this->getResource('Planimetrie')->getPlanimetriaById($idPlanimetria);
	}
    
     public function getMaxIdPlan()
    {
       return $this->getResource('Planimetrie')->getMaxIdPlan();
    }
    
    public function getPlanimetrieOrderById()
    {
        return $this->getResource('Planimetrie')->getPlanimetrieOrderById();
    }
    
    public function aggiungiPlanimetria($planInfo)
    {
        return $this->getResource('Planimetrie')->aggiungiPlanimetria($planInfo);
    }
    
     public function deletePlan($planID)
    {
        return $this->getResource('Planimetrie')->deletePlan($planID);
    }
    
     public function modificaPlanimetria($planInfo,$ID)
    {
        return $this->getResource('Planimetrie')->modificaPlanimetria($planInfo,$ID);
    }
	
    
	//POSIZIONE
	public function aggiungiPosizione($posInfo)
	{
	    return $this->getResource('Posizione')->aggiungiPosizione($posInfo);
	}
	
	public function getPosizione()
    {
        return $this->getResource('Posizione')->getPosizione();
    }
    
    public function getPosizioneByIdPlanimetria($idplan){
        return $this->getResource('Posizione')->getPosizioneByIdPlanimetria($idplan);
    }
	
	public function getEdifici()
    {
        return $this->getResource('Posizione')->getEdifici();
    }
    
    public function getPianoByEdificio($edif)
    {
        return $this->getResource('Posizione')->getPianoByEdificio($edif);
    }
	
	public function getIdPlanimetriaByEdificioPiano($edificio, $piano)
	{
		return $this->getResource('Posizione')->getIdPlanimetriaByEdificioPiano($edificio, $piano);
	}
	
	public function getIdPosizioneByEdPiAl($ed, $pi, $al)
	{
		return $this->getResource('Posizione')->getIdPosizioneByEdPiAl($ed, $pi, $al);
	}
	
	public function getDataByIdPosizione($idPos)
	{
		return $this->getResource('Posizione')->getDataByIdPosizione($idPos);
	}
    
    public function deletePosizioneByIdPlan($IdPlan)
    {
        return $this->getResource('Posizione')->deletePosizioneByIdPlan($IdPlan);
    }
	
	//UTENTE
	public function insertUser($usrInfo)
    {
        return $this->getResource('Utente')->insertUser($usrInfo);
    }
	
	public function deleteUser($username)
    {
        return $this->getResource('Utente')->deleteUser($username);
    }
    
    public function updateUser($usrI,$un)
    {
        return $this->getResource('Utente')->updateUser($usrI,$un);
    }
    
    public function updateUserById($usrI,$ID)
    {
        return $this->getResource('Utente')->updateUserByID($usrI,$ID);
    }
    
    public function  getUserByUName($uname)
    {
        return $this->getResource('Utente')-> getUserByUName($uname);
    }
	
	public function  getUserOrderById()
    {
        return $this->getResource('Utente')->getUserOrderById();
    }
	
	public function setIdPosByUName($idPos, $uName)
	{
		return $this->getResource('Utente')->setIdPosByUName($idPos, $uName);
	}
}