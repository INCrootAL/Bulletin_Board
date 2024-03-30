<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Компания");
?>
<?
//Запрашиваем ID
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$fill = parse_url($url, PHP_URL_QUERY);
$pubIDPHP = substr($fill , 3);

//Проверяем поьзователя
$byNew = $USER->GetID();
$rsUserNew = CUser::GetByID($byNew);
$arUserNew = $rsUserNew->Fetch();
$arUserNew["UF_AD_APP"];

$war = 1;
$arParams["FIELDS"] = Array();
$filter = Array("ACTIVE"=>"Y", "BLOCKED"=>"Y");
$rsUsers = CUser::GetList(($by="id"), ($order="desc"), $filter, $arParams);
while($res = $rsUsers->GetNext()) {
    if ($res['ID'] == $pubIDPHP && $res['BLOCKED'] != "Y") {
        $war = 2;
    }
}
?>

<?if ($arUserNew["UF_AD_APP"] == "4" || $war == 2) {?>
<div class="info-company-use">
<?$APPLICATION->IncludeComponent("bitrix:blog.user", "new-castom-blog", Array(
	"BLOG_VAR" => "",	// Имя переменной для идентификатора блога
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",	// Формат показа даты и времени
		"ID" => $id,	// Идентификатор пользователя
		"PAGE_VAR" => "",	// Имя переменной для страницы
		"PATH_TO_BLOG" => "",	// Шаблон пути к странице блога
		"PATH_TO_SEARCH" => "",	// Шаблон пути к странице поиска
		"PATH_TO_USER" => "",	// Шаблон пути к странице пользователя
		"PATH_TO_USER_EDIT" => "",	// Шаблон пути к странице редактирования пользователя
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"USER_CONSENT" => "N",	// Запрашивать согласие
		"USER_CONSENT_ID" => "0",	// Соглашение
		"USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
		"USER_CONSENT_IS_LOADED" => "N",	// Загружать текст сразу
		"USER_PROPERTY" => "",	// Показывать доп. свойства
		"USER_VAR" => "",	// Имя переменной для пользователя
	),
	false
);?>
<br>
</div>
<?} else {
    header('Location:' .'http://'. $_SERVER['HTTP_HOST'] .'/404.php');
    exit();   
}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>