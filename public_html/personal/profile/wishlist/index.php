<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?if(!$USER->IsAuthorized()) // Для неавторизованного
{
    global $APPLICATION;
    $favorites = unserialize($_COOKIE["favorites"]);
} else {
     $idUser = $USER->GetID();
     $rsUser = CUser::GetByID($idUser);
     $arUser = $rsUser->Fetch();
     $favorites = $arUser['UF_FAVORITES'];
     //print_r($favorites);
    if ($favorites[0] == ""){
        $favorites = 1;
    }  
    //print_r($favorites);
}
$GLOBALS['arrFilter']=Array("ID" => $favorites);
?>
<?
global $USER;
use Bitrix\Main\Page\Asset; 
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style.css');
$rsUser = CUser::GetByID($USER->GetID()); 
$arUserT = $rsUser->Fetch();
?>

<?
//Проверка зарегестрирванного пользователя
$by = $USER->GetID();
$rsUserNa = CUser::GetByID($by);
$arUserNa = $rsUserNa->Fetch();
$arUserNa["UF_TYPE"];
?>
<div class="_lk-panel">
    <div class="lk-panel-info-left">
        <div class="lk-panel-info-left-logo-comp" <?if (!isset($arUserT['WORK_LOGO'])){?> style="background: #D9D9D9;"<?}?>>
            <?echo CFile::ShowImage($arUserT['WORK_LOGO'], 98, 98, 'border=0', '', true); ?>
        </div>
        <div class="lk-panel-info-left-name-comp"><?echo $arUserT['WORK_COMPANY']?></div>
        <div class="lk-panel-info-menu">
            <a class="lk-panel-info-menu-items" href="/personal/profile/"<?if($APPLICATION->GetCurPage() == '/personal/profile/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?></a>Личный кабинет</a>
            <?if ($arUserNa["UF_TYPE"] == 2) {?><a class="lk-panel-info-menu-items"href="/personal/profile/vac/"<?if($APPLICATION->GetCurPage() == '/personal/profile/vac/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?>>Вакансии</a><?}?>
            <a class="lk-panel-info-menu-items"href="/personal/profile/wishlist/"<?if($APPLICATION->GetCurPage() == '/personal/profile/wishlist/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?>>Избранное</a>
            <a class="lk-panel-info-menu-items"href="/personal/profile/settings/"<?if($APPLICATION->GetCurPage() == '/personal/profile/settings/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?>>Настройки аккаунта</a>
        </div>
    </div>
    <div class="lk-panel-info-right">
        <div class="lk-panel-info-right-title">
            <?$APPLICATION->IncludeComponent(
                    	"bitrix:breadcrumb",
                    	"",
                    	Array(
                    		"PATH" => "",
                    		"SITE_ID" => "s1",
                    		"START_FROM" => "0"
                    	)
                    );?>
            <span class="lk-panel-info-right-title-t">Избранное</span>
        </div>
        <?if ($arUserNa["UF_TYPE"] == 1) {?>
        <? if ($favorites == 1){?>
            <?if ($arUserNa["UF_TYPE"] == 2) {?>
                <div class="lk-panel-info-right-about-us-war-info">К сожалению, у вас пока что нету избранных Резюме, давайте это исправим. Просто перейдите по <a href="/resume/">ссылке.</a></div>
            <?} else {?>
                <div class="lk-panel-info-right-about-us-war-info">К сожалению, у вас пока что нету избранных Вакансий, давайте это исправим. Просто перейдите по <a href="/vacancies/">ссылке.</a></div>
            <?}?>
        <?} else {?>
            <div class="lk-panel-info-right-about-us">
                <?$APPLICATION->IncludeComponent(
                    	"bitrix:catalog.section",
                    	"new-castom-section-martimer-lk",
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
                    		"PAGE_ELEMENT_COUNT" => "2",
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
                    );?>
                </div>
            <?}?>
        <?} else {?>
            <? if ($favorites == 1){?>
            <?if ($arUserNa["UF_TYPE"] == 2) {?>
                <div class="lk-panel-info-right-about-us-war-info">К сожалению, у вас пока что нету избранных Резюме, давайте это исправим. Просто перейдите по <a href="/resume/">ссылке.</a></div>
            <?} else {?>
                <div class="lk-panel-info-right-about-us-war-info">К сожалению, у вас пока что нету избранных Вакансий, давайте это исправим. Просто перейдите по <a href="/vacancies/">ссылке.</a></div>
            <?}?>
        <?} else {?>
            <div class="lk-panel-info-right-about-us">
                <?$APPLICATION->IncludeComponent(
                    	"bitrix:catalog.section",
                    	"new-castom-section-martimer-resume",
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
                    		"IBLOCK_ID" => "6",
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
                    		"PAGE_ELEMENT_COUNT" => "2",
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
                    );?>
                </div>
            <?}?>
        <?}?>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>