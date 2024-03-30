<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
 global $USER;
 ?>
<?
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

<?if ($USER->IsAuthorized()) {?>
<div class="_lk-panel">
    <div class="lk-panel-info-left">
        <div class="lk-panel-info-left-logo-comp" <?if (!isset($arUserT['WORK_LOGO'])){?> style="background: #D9D9D9;"<?}?>>
            <?echo CFile::ShowImage($arUserT['WORK_LOGO'], 98, 98, 'border=0', '', true); ?>
        </div>
        <div class="lk-panel-info-left-name-comp"><?echo $arUserT['WORK_COMPANY']?></div>
        <div class="lk-panel-info-menu">
            <a class="lk-panel-info-menu-items"<?if($APPLICATION->GetCurPage() == '/personal/profile/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?></a>Личный кабинет</a>
            <?if ($arUserNa["UF_TYPE"] == 2) {?><a class="lk-panel-info-menu-items" href="/personal/profile/vac/">Вакансии</a><?}?>
            <a class="lk-panel-info-menu-items" href="/personal/profile/wishlist/">Избранное</a>
            <a class="lk-panel-info-menu-items"href="/personal/profile/settings/">Настройки аккаунта</a>
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
            <span class="lk-panel-info-right-title-t">Личный кабинет</span>
        </div>
        <div class="lk-panel-info-right-about-us">
            <?if ($arUserNa["UF_TYPE"] == 2) {?><div class="lk-panel-info-right-about-us-bl-1"><?} else {?><div class="lk-panel-info-right-about-us-bl-1-1"><?}?>
                <a class="lk-panel-info-right-about-us-t"><?if ($arUserNa["UF_TYPE"] == 2) {?>Мои данные<?} else {?>Моё резюме<?}?></a>
            <?if ($arUserNa["UF_TYPE"] == 2) {?>
                <div class="">Название компании
                <?if ($arUserT['WORK_COMPANY']){?>
                    <a><?echo $arUserT['WORK_COMPANY']?></a>
                <?} else {?>
                    <a>—</a>
                <?}?>
                </div>
            
                <div class="lk-panel-info-right-about-us-bl-2">Адрес
                <?if ($arUserT['WORK_STREET']){?>
                    <a><?echo $arUserT['WORK_STREET']?></a>
                <?} else {?>
                    <a>—</a>
                <?}?>
                </div>
                <div class="lk-panel-info-right-about-us-bl-3">
                    <div class="">Контактное лицо
                    <?if ($arUserT['UF_CONTACTS_USER'][0]){?>
                        <a><?echo $arUserT['UF_CONTACTS_USER'][0]?></a>
                    <?} else {?>
                        <a>—</a>
                    <?}?>
                    </div>
                </div>
                <div class="lk-panel-info-right-about-us-bl-4">
                    <div class="">Веб-сайт
                    <?if ($arUserT['WORK_WWW']){?>
                        <a><?echo $arUserT['WORK_WWW']?></a>
                    <?} else {?>
                        <a>—</a>
                    <?}?>
                    </div>
                </div>
                <div class="lk-panel-info-right-about-us-bl-5">О компании
                <?if ($arUserT['WORK_PROFILE']){?>
                    <a><?echo $arUserT['WORK_PROFILE']?></a>
                <?} else {?>
                    <a>—</a>
                <?}?>
                </div>
            <?} else {?>
                <div class="lk-panel-info-resume">
                    <?$APPLICATION->IncludeComponent(
                	"bitrix:catalog.section", 
                	"new-castom-section-martimer-lk-sea", 
                	array(
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
                		"DETAIL_URL" => "#SITE_DIR#/resume/detailed/index.php?ID=#ELEMENT_ID#",
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
                		"LABEL_PROP" => array(
                		),
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
                		"PAGE_ELEMENT_COUNT" => "14",
                		"PARTIAL_PRODUCT_PROPERTIES" => "N",
                		"PRICE_CODE" => array(
                		),
                		"PRICE_VAT_INCLUDE" => "Y",
                		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                		"PRODUCT_ID_VARIABLE" => "id",
                		"PRODUCT_PROPS_VARIABLE" => "prop",
                		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
                		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false}]",
                		"PROPERTY_CODE_MOBILE" => array(
                		),
                		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                		"RCM_TYPE" => "personal",
                		"SECTION_CODE" => "",
                		"SECTION_ID" => $_REQUEST["SECTION_ID"],
                		"SECTION_ID_VARIABLE" => "SECTION_ID",
                		"SECTION_URL" => "#SITE_DIR#/resume/detailed/index.php?ID=#IBLOCK_ID#",
                		"SECTION_USER_FIELDS" => array(
                			0 => "",
                			1 => "",
                		),
                		"SEF_MODE" => "N",
                		"SET_BROWSER_TITLE" => "Y",
                		"SET_LAST_MODIFIED" => "N",
                		"SET_META_DESCRIPTION" => "Y",
                		"SET_META_KEYWORDS" => "Y",
                		"SET_STATUS_404" => "Y",
                		"SET_TITLE" => "Y",
                		"SHOW_404" => "Y",
                		"SHOW_ALL_WO_SECTION" => "Y",
                		"SHOW_FROM_SECTION" => "N",
                		"SHOW_PRICE_COUNT" => "1",
                		"SHOW_SLIDER" => "Y",
                		"SLIDER_INTERVAL" => "3000",
                		"SLIDER_PROGRESS" => "N",
                		"TEMPLATE_THEME" => "blue",
                		"USE_ENHANCED_ECOMMERCE" => "N",
                		"USE_MAIN_ELEMENT_SECTION" => "N",
                		"USE_PRICE_COUNT" => "N",
                		"USE_PRODUCT_QUANTITY" => "N",
                		"COMPONENT_TEMPLATE" => "new-castom-section-martimer-lk-comp"
                	),
                	false
                );?>
                </div>
            <?}?>
            </div>
            <?if ($arUserNa["UF_TYPE"] == 2) {?>
                <div class="lk-panel-info-left-about-us-bl-1">
                    <div class="">Номер телефона
                    <?if ($arUserT['WORK_PHONE']){?>
                        <a><?echo $arUserT['WORK_PHONE']?></a>
                    <?} else {?>
                        <a>—</a>
                    <?}?>
                    </div>
                    <div class="">Почта
                    <?if ($arUserT['EMAIL']){?>
                        <a><?echo $arUserT['EMAIL']?></a>
                    <?} else {?>
                        <a>—</a>
                    <?}?>
                    </div>
                    <div class="">Дата создания аккаунта
                        <a><?echo strtolower(FormatDate("d F Y", MakeTimeStamp($arUserT['DATE_REGISTER'])))?></a>
                    </div>
                </div>
            <?}?>
        </div>
        <?if ($arUserNa["UF_TYPE"] == 2) {?>
            <a class="buttons-profile-data" href="/personal/profile/settings/">Изменить данные</a>
        <?} else {?>
            <a class="buttons-profile-data" id="buttons-profile-data">Изменить резюме</a>
            <a class="buttons-profile-data-del" id="buttons-profile-data-del" onclick="popup_show_lk(this);" data-popup="delete">Удалить резюме</a>
        <?}?>
    </div>
</div>
<style>
.popup-lk {
    display: none;
}
</style>


<?if ($arUserNa["UF_TYPE"] != 2) {?>
    <script>
        let notIn  = $(".col-xs-6-notification").data("info");
        if (notIn == 0) {
            document.getElementById("buttons-profile-data").style = "display:none";
            document.getElementById("buttons-profile-data-del").style = "display:none";
        }
    </script>
<?}?>

<?} else {
    header('Location:' .'http://'. $_SERVER['HTTP_HOST'] .'/404.php');
    exit( ); 
  }?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>