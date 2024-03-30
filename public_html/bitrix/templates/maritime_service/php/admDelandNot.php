<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

global $APPLICATION;
if ($_GET['_par']) {
    $_par = $_GET['_par'];
    $_parType = $_GET['_parType'];
    $_view = $_GET['_view'];
    
    if ($_parType == "blocked" && $_view == "true") {
        $user = new CUser;
        $fields = Array(
        	"BLOCKED" => "Y",
        );
        $user->Update($_par, $fields);
        $strError .= $user->LAST_ERROR;
        if ($strError == "") {
           $result = 1; 
        } else {
            $result = 2;
        }
        
    } else if ($_parType == "blocked" && $_view == "false") {
        $user = new CUser;
        $fields = Array(
        	"BLOCKED" => "N",
        );
        $user->Update($_par, $fields);
        $strError .= $user->LAST_ERROR;
        if ($strError == "") {
           $result = 1; 
        } else {
            $result = 2;
        }
        
    } else if ($_parType == "examen" && $_view == "true") {
        
        $user = new CUser;
        $fields = Array("UF_EXAMIN" => 6); 
        $user->Update($_par, $fields);
        $result = $_view;
        if ($strError == "") {
           $result = 1; 
        } else {
            $result = 2;
        }
        
    } else if ($_parType == "examen" && $_view == "false") {
        
        $user = new CUser;
        $fields = Array("UF_EXAMIN" => 5); 
        $user->Update($_par, $fields);
        $result = $user;
        if ($strError == "") {
           $result = 1; 
        } else {
            $result = 2;
        }
        
    } else {
        $result = 2;
    }
} else {
    $result = 2;
}


echo json_encode($result);
die();
?>