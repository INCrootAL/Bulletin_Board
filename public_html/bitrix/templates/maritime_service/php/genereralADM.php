<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

global $APPLICATION;
if ($_GET['pubIDJS']) {
    $pubIDJS = $_GET['pubIDJS'];
    $viewJS = $_GET['viewJS'];
    $typeJS = $_GET['typeJS'];
    $overjs = $_GET['overjs'];
    
    if ($typeJS == "vac" && $viewJS == "accept") {
        //Устанавливаем значение проверки администратором
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 108;  // 108 = да, 109 - нет, 463 отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => $newdate
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        
        $PROPERTY_CODE_2 = "DATE_PUBLICK";
        $PROPERTY_VALUE_2 = 472;
        $dbrNewS = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arrNEW = $dbrNewS->Fetch()) {
            $IBLOCK_ID = $dbr_arrNEW["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE_2, $PROPERTY_CODE_2);
        }
        
        $result = 1;
    } else if ($typeJS == "vac" && $viewJS == "del" && $overjs != "") {
        //Устанавливаем значение проверки администратором
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 463;  // 108 = да, 109 - нет, 463 отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => ""
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        
        //Устанавливаем причину отказа
        CIBlockElement::SetPropertyValueCode("$ELEMENT_ID", "R_DEVIATION", $overjs);
        $result = 1;
    } else if ($typeJS == "vac" && $viewJS == "delBe") {
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 108;  // 108 = да, 109 - нет, 463 отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        $PROPERTY_CODE_2 = "DATE_PUBLICK";
        $PROPERTY_VALUE_2 = 472;
        $dbrNewS = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arrNEW = $dbrNewS->Fetch()) {
            $IBLOCK_ID = $dbr_arrNEW["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE_2, $PROPERTY_CODE_2);
        }
        
        //Устанавливаем причину отказа
        CIBlockElement::SetPropertyValueCode("$ELEMENT_ID", "R_DEVIATION", $overjs);
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => $newdate
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        $result = 1;
    } else if ($typeJS == "vac" && $viewJS == "editBe")  {
        //Изменяем причину отказа
        CIBlockElement::SetPropertyValueCode("$pubIDJS", "R_DEVIATION", $overjs);
        $result = 1;
    } 
    // resume
    else if ($typeJS == "res" && $viewJS == "accept") {
        //Устанавливаем значение проверки администратором
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "R_VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 461;  // 461 = да, 462 - нет, 464 - отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        $PROPERTY_CODE_2 = "R_DATE_PUBLICK";
        $PROPERTY_VALUE_2 = 473;
        $dbrNewS = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arrNEW = $dbrNewS->Fetch()) {
            $IBLOCK_ID = $dbr_arrNEW["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE_2, $PROPERTY_CODE_2);
        }
        
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => $newdate
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        $result = 1;
    } else if ($typeJS == "res" && $viewJS == "del" && $overjs != ""){
        //Устанавливаем значение проверки администратором
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "R_VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 464;  // 461 = да, 462 - нет, 464 - отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => ""
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        
        //Устанавливаем причину отказа
        CIBlockElement::SetPropertyValueCode("$ELEMENT_ID", "R_R_DEVIATION", $overjs);
        $result = 1;
    } else if ($typeJS == "res" && $viewJS == "delBe") {
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "R_VERIFIED_ADMINISTRATOR";
        $PROPERTY_VALUE = 461;  // 461 = да, 462 - нет, 464 - отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        $PROPERTY_CODE_2 = "R_DATE_PUBLICK";
        $PROPERTY_VALUE_2 = 473;
        $dbrNewS = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arrNEW = $dbrNewS->Fetch()) {
            $IBLOCK_ID = $dbr_arrNEW["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE_2, $PROPERTY_CODE_2);
        }
        
        //Устанавливаем причину отказа
        CIBlockElement::SetPropertyValueCode("$ELEMENT_ID", "R_R_DEVIATION", $overjs);
        
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => $newdate
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        $result = 1;
    } else if ($typeJS == "res" && $viewJS == "editBe")  {
        //Изменяем причину отказа
        CIBlockElement::SetPropertyValueCode("$pubIDJS", "R_R_DEVIATION", $overjs);
        $result = 1;
    }
    
    //bord
    else if ($typeJS == "bor" && $viewJS == "accept") {
        //Устанавливаем значение проверки администратором
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "D_VER_ADM";
        $PROPERTY_VALUE = 114;  // 114	- да, 115 - Нет. 465 - отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => $newdate
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        $result = 1;
    } else if ($typeJS == "bor" && $viewJS == "del" && $overjs != ""){
        //Устанавливаем значение проверки администратором
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "D_VER_ADM";
        $PROPERTY_VALUE = 465;  // 114	- да, 115 - Нет. 465 - отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => ""
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        
        //Устанавливаем причину отказа
        CIBlockElement::SetPropertyValueCode("$ELEMENT_ID", "D_R_DEVIATION", $overjs);
        $result = 1;
    } else if ($typeJS == "bor" && $viewJS == "delBe") {
        $ELEMENT_ID = $pubIDJS;
        $PROPERTY_CODE = "D_VER_ADM";
        $PROPERTY_VALUE = 114;  // 114	- да, 115 - Нет. 465 - отклонено
        $dbr = CIBlockElement::GetList(array(), array("=ID"=>$ELEMENT_ID), false, false, array("ID", "IBLOCK_ID"));
        if ($dbr_arr = $dbr->Fetch())
        {
        	$IBLOCK_ID = $dbr_arr["IBLOCK_ID"];
        	CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
        }
        
        //Устанавливаем причину отказа
        CIBlockElement::SetPropertyValueCode("$ELEMENT_ID", "D_R_DEVIATION", $overjs);
        
        //Устанавливаем время публикации в 1 месяц
        $date = date('d.m.Y');
        $newdate = date('d.m.Y', strtotime($date) + 31 * 24 * 3600);
        $el = new CIBlockElement;
        $arLoadProductArray = Array (
        	"ACTIVE_TO"    => $newdate
        );
        $res = $el->Update($pubIDJS, $arLoadProductArray);
        $result = 1;
    } else if ($typeJS == "bor" && $viewJS == "editBe")  {
        //Изменяем причину отказа
        CIBlockElement::SetPropertyValueCode("$pubIDJS", "D_R_DEVIATION", $overjs);
        $result = 1;
    }
} else {
    $result = 2;
}


echo json_encode($result);
die();
?>