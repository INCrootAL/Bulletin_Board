<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
/* Избранное */
global $APPLICATION;
if($_GET['idResume'])
{
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arElements = ($arUser['UF_RESPONSES']) ? : array();  // Достаём избранное пользователя
        if(!in_array($_GET['idResume'], $arElements)) // Если еще нету этой позиции в избранном
        {
            $arElements[] = $_GET['idResume'];
            $result = 2;
        }
        else {
            $key = array_search($_GET['idResume'], $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            $result = 1;
        }
        $USER->Update($idUser, Array("UF_RESPONSES" => $arElements)); // Добавляем элемент в избранное
}
/* Избранное */
echo json_encode($result);
die();
?>