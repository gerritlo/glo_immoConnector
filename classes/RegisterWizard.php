<?php

namespace GloImmoConnector;

class RegisterWizard extends \Backend {
  
  public function registerApplication() {
    $sCertifyURL = \Environment::get('requestUri'); // Komplette URL inkl. Parameter auf der das Script eingebunden wird
    $objTemplate = new \BackendTemplate('be_registrationForm');
    
    $objImmoConnector = new ImmoConnector('is24',\Config::get('gloImmoConnectorKey'),\Config::get('gloImmoConnectorSecret'));
    $immocaster = $objImmoConnector->getImmocaster();
     
    if(\Input::get('main_registration') != null || \Input::get('state') != null) {
        if(\Input::post('user') != null) {
          $sUser = \Input::post('user');
        }
        
        if(\Input::get('user') != null) {
          $sUser = \Input::get('user');
        }
        
        $aParameter = array('callback_url' => $sCertifyURL . '?user=' . $sUser , 'verifyApplication' => true);
        // Benutzer neu zertifizieren
        if($immocaster->getAccess($aParameter)) {
          $objTemplate->certificationSuccessful = 'Zertifizierung war erfolgreich.';
        }
        else {
          // Test ob Benutzer schon zertifiziert ist
          if($immocaster->getApplicationTokenAndSecret($sUser)) {
            $objTemplate->alreadyCertified = 'Dieser Benutzer ist bereits zertifiziert.';
          }
        }
      }
      
      $objTemplate->sCertifyURL = $sCertifyURL;
      return $objTemplate->parse();
  }
}
