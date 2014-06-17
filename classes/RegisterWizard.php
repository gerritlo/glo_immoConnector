<?php

namespace GloImmoConnector;

class RegisterWizard extends \Backend {
  
  public function registerApplication() {
    $sCertifyURL = \Environment::uri(); // Komplette URL inkl. Parameter auf der das Script eingebunden wird
    $objTemplate = new \BackendTemplate('be_registrationForm');
    
    if(isset(\Input::get('main_registration')) || isset(\Input::get('state'))) {
        if(isset(\Input::post('user'))) {
          $sUser = \Input::post('user');
        }
        
        if(isset(\Input::get('user'))) {
          $sUser=\Input::get('user');
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
