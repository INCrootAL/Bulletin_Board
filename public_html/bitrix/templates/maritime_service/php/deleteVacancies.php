<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
if($_GET['id'])
{
    if(CModule::IncludeModule("iblock")) {
        if(CIBlock::GetPermission(5)>='W') {
            $DB->StartTransaction();
            if(!CIBlockElement::Delete($_GET['id'])) {
                $strWarning .= 'Error!';
                $DB->Rollback();
                $result = 2;
            } else {
                $DB->Commit();
                $result = 1;
            }
        }
    }
}

echo json_encode($result);
die();
?>