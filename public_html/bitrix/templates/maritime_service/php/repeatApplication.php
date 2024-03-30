<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

global $APPLICATION;
if ($_GET['pubID_US_JS']) {
    $pubID_US_JS = $_GET['pubID_US_JS'];
    $typeBlockJS = $_GET['typeBlockJS'];
    
    if ($typeBlockJS == "vac") {
        $ELEMENT_ID = $pubID_US_JS;
        $PROPERTY_CODE_2 = "DATE_PUBLICK";
        $PROPERTY_VALUE_2 = 469;
        $dbrNewS = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arrNEW = $dbrNewS->Fetch()) {
            $IBLOCK_ID = $dbr_arrNEW["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE_2, $PROPERTY_CODE_2);
        }
        $result = 1;
        
    } else if ($typeBlockJS == "res") {
        $ELEMENT_ID = $pubID_US_JS;
        $PROPERTY_CODE_2 = "R_DATE_PUBLICK";
        $PROPERTY_VALUE_2 = 467;
        $dbrNewS = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arrNEW = $dbrNewS->Fetch()) {
            $IBLOCK_ID = $dbr_arrNEW["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE_2, $PROPERTY_CODE_2);
        }
        $result = 1;
        
    } else if ($typeBlockJS == "auto") {
        $ELEMENT_ID = $pubID_US_JS;
        $PROPERTY_CODE = "VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 108;  // 108 = да, 109 - нет, 463 отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch()) {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array ("ACTIVE_TO" => $newdate);
        $res = $el->Update($pubID_US_JS, $arLoadProductArray);
        $result = 1;
        
    } else {
        $result = 2;
    }
} else {
    $result = 2;
};
echo json_encode($result);
die();
?>