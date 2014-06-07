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
                
                if(!self::isCacheFileValid($objFile)) {
                    $objFile->delete();
                    $this->log("Cache-File '" . $strFile . "' was deleted.", __METHOD__, TL_FILES);
                } 
            } else {
                var_dump($strFile);
            }
    	}
    }

    public function purgeCacheFiles() {
    	$objFolder = new \Folder(ImmoConnector::CACHE_DIRECTORY);
    	$objFolder->purge();

    	$this->log("Cache-File were deleted.", __METHOD__, TL_FILES);
    }

    public static function isCacheFileValid($objFile) {
        
        $validTime = self::cacheFileValidTime($objFile->mtime);
        $isValid = $validTime > time();
        
        
        $GLOBALS['TL_DEBUG']['immoConnector']['cacheFiles'][$objFile->filename] = array(
            'mtime' => $objFile->mtime,
            'validTime' => $validTime,
            'isValid' => $isValid
        );
        
        
        return $isValid;
    }

    public static function cacheFileValidTime($mtime) {
        return $mtime + \Config::get('gloImmoConnectorCacheTime');
    }
}