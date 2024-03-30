<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

global $APPLICATION;
if ($_GET['usIDJS']) {
    $usIDJS = $_GET['usIDJS'];
    $usPhotoJS = $_GET['usPhotoJS'];
    $newParUsPhoto = CFile::GetPath($usPhotoJS);
    $arIMAGE = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $newParUsPhoto);
    $arIMAGE["MODULE_ID"] = "main";
    
    //Устанавливаем время публикации в 1 месяц
    $user = new CUser;
    $fields = Array(
        'WORK_LOGO' => $arIMAGE,
    );
    $user->Update($usIDJS, $fields);
    $strError .= $user->LAST_ERROR;
    if ($strError) {
       $result = $strError;
    } else {
        $result = 1;
    }
}

echo json_encode($result);
die();
?>