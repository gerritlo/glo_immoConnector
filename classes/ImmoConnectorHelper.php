<?php

namespace GloImmoConnector;

class ImmoConnectorHelper extends \Backend {

    public function purgeExpiredCacheFiles() {
        $strFolder = TL_ROOT . '/' . ImmoConnector::CACHE_DIRECTORY;
        
        //Ist der Ordner nicht vorhanden, gibt es nichts zu löschen
        if(!is_dir($strFolder)) {
            return true;
        }

    	//Durchlaufen des Cache-Verzeichnisses
    	foreach(scan($strFolder) as $strFile) {
                if(is_file($strFolder.$strFile)) {
                    $objFile = new \File(ImmoConnector::CACHE_DIRECTORY . $strFile);
                    
                    if(($objFile->ctime + \Config::get('gloImmoConnectorCacheTime')) < time()) {
                        $objFile->delete();
                        $this->log("Cache-File '" . $strFile . "' was deleted.", __METHOD__, TL_FILES);
                    } 
                }else {
                        var_dump($strFile);
                    }
    		
                
    	}
    }

    public function purgeCacheFiles() {
    	$objFolder = new \Folder(TL_ROOT . ImmoConnector::CACHE_DIRECTORY);
    	$objFolder->purge();

    	$this->log("Cache-File were deleted.", __METHOD__, TL_FILES);
    }
}