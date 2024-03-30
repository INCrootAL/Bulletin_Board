<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
CModule::IncludeModule('iblock');

$arFilter = Array("IBLOCK_ID"=> "5" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
while($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$parID[] = $arFields['ID'];
}

if (isset($parID)) {
    foreach ($parID as $NewParID) {
    	$res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array("ID"=>"53"));
    	while ($ob = $res->GetNext()) {
    		$prop = $ob;
    		if ($prop['VALUE_ENUM'] == "Да") {
                $yesParID[] = $NewParID;
    		}
    	};
    }
}

$GLOBALS['smartPreFilter']=Array("ID" => $yesParID);?>

<div class="vacansii">
	<div class="page-top">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"",
	Array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);?>
		<h1><?$APPLICATION->ShowTitle()?></h1>
 <br>
 <br>
		<div class="board-sections-top">
			 <?$APPLICATION->IncludeComponent(
            	"bitrix:catalog.search",
            	"new-castom-seach",
            	Array(
            		"ACTION_VARIABLE" => "action",
            		"AJAX_MODE" => "Y",
            		"AJAX_OPTION_ADDITIONAL" => "",
            		"AJAX_OPTION_HISTORY" => "N",
            		"AJAX_OPTION_JUMP" => "N",
            		"AJAX_OPTION_STYLE" => "N",
            		"BASKET_URL" => "/personal/basket.php",
            		"CACHE_TIME" => "36000000",
            		"CACHE_TYPE" => "N",
            		"CHECK_DATES" => "Y",
            		"DETAIL_URL" => "#SITE_DIR#/vacancies/detailed/index.php?ID=#ELEMENT_ID#",
            		"DISPLAY_BOTTOM_PAGER" => "N",
            		"DISPLAY_COMPARE" => "N",
            		"DISPLAY_TOP_PAGER" => "N",
            		"ELEMENT_SORT_FIELD" => "sort",
            		"ELEMENT_SORT_FIELD2" => "id",
            		"ELEMENT_SORT_ORDER" => "asc",
            		"ELEMENT_SORT_ORDER2" => "desc",
            		"IBLOCK_ID" => "5",
            		"IBLOCK_TYPE" => "job",
            		"LINE_ELEMENT_COUNT" => "2",
            		"NO_WORD_LOGIC" => "N",
            		"OFFERS_LIMIT" => "5",
            		"PAGER_DESC_NUMBERING" => "N",
            		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            		"PAGER_SHOW_ALL" => "N",
            		"PAGER_SHOW_ALWAYS" => "N",
            		"PAGER_TEMPLATE" => "grid",
            		"PAGER_TITLE" => "Товары",
            		"PAGE_ELEMENT_COUNT" => "30",
            		"PRICE_CODE" => array(),
            		"PRICE_VAT_INCLUDE" => "N",
            		"PRODUCT_ID_VARIABLE" => "id",
            		"PRODUCT_PROPERTIES" => array("POST", "SALARY", "CURRENCY", "COUNTRY_CITY_PLANTING", "CONTRACT_TIME", "TYPE_OF_SHIP"),
            		"PRODUCT_PROPS_VARIABLE" => "prop",
            		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
            		"PROPERTY_CODE" => array("POST", "SALARY", "CURRENCY", "PLANTING_TIME", "COUNTRY_CITY_PLANTING", "CONTRACT_TIME", "VERIFIED_ADMINISTRATOR", "TYPE_OF_SHIP", "DESCRIPTION_VAL", "ADRESS_COMP", "CONTACT_PERS", "NUMBER_PHONE", "EMAIL_COMP", "SITE_COMP", ""),
            		"RESTART" => "Y",
            		"SECTION_ID_VARIABLE" => "SECTION_ID",
            		"SECTION_URL" => "",
            		"SHOW_PRICE_COUNT" => "1",
            		"USE_LANGUAGE_GUESS" => "Y",
            		"USE_PRICE_COUNT" => "N",
            		"USE_PRODUCT_QUANTITY" => "N",
            		"USE_SEARCH_RESULT_ORDER" => "N",
            		"USE_TITLE_RANK" => "N"
            	)
            );?> 
            <?$APPLICATION->IncludeComponent(
            	"bitrix:catalog.smart.filter",
            	"new-castom-smart-filter",
            	Array(
            		"CACHE_GROUPS" => "Y",
            		"CACHE_TIME" => "36000000",
            		"CACHE_TYPE" => "A",
            		"DISPLAY_ELEMENT_COUNT" => "N",
            		"FILTER_NAME" => "arrFilter",
            		"FILTER_VIEW_MODE" => "vertical",
            		"IBLOCK_ID" => "5",
            		"IBLOCK_TYPE" => "job",
            		"PAGER_PARAMS_NAME" => "arrPager",
            		"POPUP_POSITION" => "left",
            		"PREFILTER_NAME" => "smartPreFilter",
            		"SAVE_IN_SESSION" => "N",
            		"SECTION_CODE" => "",
            		"SECTION_DESCRIPTION" => "-",
            		"SECTION_ID" => $_REQUEST["SECTION_ID"],
            		"SECTION_TITLE" => "-",
            		"SEF_MODE" => "N",
            		"TEMPLATE_THEME" => "blue",
            		"XML_EXPORT" => "N"
            	)
            );?>
            <br>
		</div>
	</div>
</div>
             <?$APPLICATION->IncludeComponent(
                	"bitrix:catalog.section",
                	"new-castom-section-martimer",
                	Array(
                		"ACTION_VARIABLE" => "action",
                		"ADD_PICT_PROP" => "-",
                		"ADD_PROPERTIES_TO_BASKET" => "N",
                		"ADD_SECTIONS_CHAIN" => "N",
                		"AJAX_MODE" => "Y",
                		"AJAX_OPTION_ADDITIONAL" => "",
                		"AJAX_OPTION_HISTORY" => "N",
                		"AJAX_OPTION_JUMP" => "N",
                		"AJAX_OPTION_STYLE" => "N",
                		"BACKGROUND_IMAGE" => "-",
                		"BASKET_URL" => "/personal/basket.php",
                		"BROWSER_TITLE" => "-",
                		"CACHE_FILTER" => "N",
                		"CACHE_GROUPS" => "Y",
                		"CACHE_TIME" => "36000000",
                		"CACHE_TYPE" => "A",
                		"COMPATIBLE_MODE" => "N",
                		"DETAIL_URL" => "#SITE_DIR#/vacancies/detailed/index.php?ID=#ELEMENT_ID#",
                		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
                		"DISPLAY_BOTTOM_PAGER" => "N",
                		"DISPLAY_COMPARE" => "N",
                		"DISPLAY_TOP_PAGER" => "N",
                		"ELEMENT_SORT_FIELD" => "sort",
                		"ELEMENT_SORT_FIELD2" => "id",
                		"ELEMENT_SORT_ORDER" => "asc",
                		"ELEMENT_SORT_ORDER2" => "desc",
                		"ENLARGE_PRODUCT" => "STRICT",
                		"FILE_404" => "",
                		"FILTER_NAME" => "arrFilter",
                		"IBLOCK_ID" => "5",
                		"IBLOCK_TYPE" => "job",
                		"INCLUDE_SUBSECTIONS" => "Y",
                		"LABEL_PROP" => array(),
                		"LAZY_LOAD" => "Y",
                		"LINE_ELEMENT_COUNT" => "3",
                		"LOAD_ON_SCROLL" => "N",
                		"MESSAGE_404" => "",
                		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
                		"MESS_BTN_BUY" => "Купить",
                		"MESS_BTN_DETAIL" => "Подробнее",
                		"MESS_BTN_LAZY_LOAD" => "Показать ещё...",
                		"MESS_BTN_SUBSCRIBE" => "Подписаться",
                		"MESS_NOT_AVAILABLE" => "",
                		"MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                		"META_DESCRIPTION" => "-",
                		"META_KEYWORDS" => "-",
                		"OFFERS_LIMIT" => "5",
                		"PAGER_BASE_LINK_ENABLE" => "N",
                		"PAGER_DESC_NUMBERING" => "N",
                		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                		"PAGER_SHOW_ALL" => "N",
                		"PAGER_SHOW_ALWAYS" => "N",
                		"PAGER_TEMPLATE" => "grid",
                		"PAGER_TITLE" => "Товары",
                		"PAGE_ELEMENT_COUNT" => "30",
                		"PARTIAL_PRODUCT_PROPERTIES" => "N",
                		"PRICE_CODE" => array(),
                		"PRICE_VAT_INCLUDE" => "Y",
                		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                		"PRODUCT_ID_VARIABLE" => "id",
                		"PRODUCT_PROPS_VARIABLE" => "prop",
                		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
                		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'1','BIG_DATA':false}]",
                		"PROPERTY_CODE_MOBILE" => array(),
                		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                		"RCM_TYPE" => "personal",
                		"SECTION_CODE" => "",
                		"SECTION_ID" => $_REQUEST["SECTION_ID"],
                		"SECTION_ID_VARIABLE" => "SECTION_ID",
                		"SECTION_URL" => "#SITE_DIR#/vacancies/detailed/index.php?ID=#IBLOCK_ID#",
                		"SECTION_USER_FIELDS" => array("",""),
                		"SEF_MODE" => "N",
                		"SET_BROWSER_TITLE" => "Y",
                		"SET_LAST_MODIFIED" => "N",
                		"SET_META_DESCRIPTION" => "Y",
                		"SET_META_KEYWORDS" => "Y",
                		"SET_STATUS_404" => "Y",
                		"SET_TITLE" => "Y",
                		"SHOW_404" => "Y",
                		"SHOW_ALL_WO_SECTION" => "N",
                		"SHOW_FROM_SECTION" => "N",
                		"SHOW_PRICE_COUNT" => "1",
                		"SHOW_SLIDER" => "Y",
                		"SLIDER_INTERVAL" => "3000",
                		"SLIDER_PROGRESS" => "N",
                		"TEMPLATE_THEME" => "blue",
                		"USE_ENHANCED_ECOMMERCE" => "N",
                		"USE_MAIN_ELEMENT_SECTION" => "N",
                		"USE_PRICE_COUNT" => "N",
                		"USE_PRODUCT_QUANTITY" => "N"
                	)
                );?><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>