<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
$APPLICATION->SetTitle("Детальная информация");
?>
<?

//Проверяем поьзователя
$byNew = $USER->GetID();
$rsUserNew = CUser::GetByID($byNew);
$arUserNew = $rsUserNew->Fetch();
$arUserNew["UF_AD_APP"];?>
<?
//Запрашиваем ID
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$fill = parse_url($url, PHP_URL_QUERY);
$pubIDPHP = substr($fill , 3);

$res = CIBlockElement::GetProperty(6, $pubIDPHP, array("sort" => "asc", ), Array('ID' => 102));
while ($ob = $res->GetNext()) {
	$prop = $ob;
	if ($prop["ID"] == 102) {
	    if ($prop['VALUE_ENUM'] == "Да") {
	        $comparisonPHP = $pubIDPHP;
	    }
	}
};

//Проверяем текущего пользователя и публикатора
$ver = false;
$dbr = CIBlockElement::GetList(array(), array("=ID"=>$pubIDPHP), false, false, array());
while($dbr_arr = $dbr->Fetch()) {
    if ($byNew == $dbr_arr['CREATED_BY']) {
        $ver = true;
    }
}

?>


<?if ($arUserNew["UF_AD_APP"] == "4" || $comparisonPHP != "" || $ver == true) {?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"new-casom-detail-element-info-resume",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADDITIONAL_FILTER_NAME" => "elementFilter",
		"ADD_DETAIL_TO_SLIDER" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BRAND_USE" => "N",
		"BROWSER_TITLE" => "NAME",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_SECTION_ID_VARIABLE" => "N",
		"COMPATIBLE_MODE" => "N",
		"DETAIL_PICTURE_MODE" => array(),
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PREVIEW_TEXT_MODE" => "H",
		"ELEMENT_CODE" => "",
		"ELEMENT_ID" => $_REQUEST["ID"],
		"FILE_404" => "",
		"IBLOCK_ID" => "6",
		"IBLOCK_TYPE" => "job",
		"IMAGE_RESOLUTION" => "16by9",
		"LABEL_PROP" => array(),
		"LABEL_PROP_MOBILE" => array(),
		"LABEL_PROP_POSITION" => "top-left",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"LINK_IBLOCK_ID" => "5",
		"LINK_IBLOCK_TYPE" => "job",
		"LINK_PROPERTY_SID" => "",
		"MAIN_BLOCK_PROPERTY_CODE" => array("R_FIO","R_DATA","R_LOCAL","R_JOB_TITLE","R_ABROAD","R_ENGLISH","R_ABOUT_ME","R_EMAIL","R_NUMBER","R_RELATIVE","R_RELATIVE_NUMBER","R_TYPE_DOCK","R_TYPE_DOCK_NUMBER","R_TYPE_DOCK_COUNTRY","R_TYPE_DOCK_WHY_DOING","R_TYPE_DOCK_DATE_START","R_TYPE_DOCK_DATE_END","R_DIPLOMA","R_DIPLOMA_NUMBER","R_DIPLOMA_COUNTRY","R_DIPLOMA_DATE_START","R_DIPLOMA_DATE_END","R_CERT","R_CERT_NUMBER","R_CERT_COUNTRY","R_CERT_DATE_START","R_CERT_DATE_END","R_EXPER","R_EXPER_NAME_SHIP","R_EXPER_TYPE_SHIP","R_EXPER_FLAG_SHIP","R_EXPER_ENGINE","R_EXPER_POWER","R_EXPER_DWT","R_EXPER_GRT","R_EXPER_COMP","R_EXPER_DATE_START","R_EXPER_DATE_END"),
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_COMMENTS_TAB" => "Комментарии",
		"MESS_DESCRIPTION_TAB" => "Описание",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
		"MESS_PRICE_RANGES_TITLE" => "Цены",
		"MESS_PROPERTIES_TAB" => "Характеристики",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "0",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(),
		"PRICE_VAT_INCLUDE" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
		"PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_CANONICAL_URL" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SKU_DESCRIPTION" => "N",
		"SHOW_SLIDER" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_COMMENTS" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"USE_RATIO_IN_RANGES" => "N",
		"USE_VOTE_RATING" => "N"
	)
);?><br>

<?} else {
    header('Location:' .'http://'. $_SERVER['HTTP_HOST'] .'/404.php');
    exit( );   
 }?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>