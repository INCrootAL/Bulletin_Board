<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $USER;
use Bitrix\Main\Page\Asset;

$byNew = $USER->GetID();
$rsUserNew = CUser::GetByID($byNew);
$arUserNew = $rsUserNew->Fetch();
$arUserNew["UF_AD_APP"];
if ($arUserNew["UF_AD_APP"] != "4") {
    $APPLICATION->SetTitle("Главная");
} else {
    $APPLICATION->SetTitle("Заявки по вакансиям");
}
?>
<?if ($arUserNew["UF_AD_APP"] != "4") {?>
<div class="body-main-top">
    <div class="body-main-top-img">
        <a class="body-main-top-img-logo"><img src="/bitrix/templates/maritime_service/images/christophe.png" alt="logo"></a>
    </div>
    <div class="apply_job">
        <div class="apply_job_title">
            <span id="a1">Крюинговый сервис</span>
            <span id="a2">Подбор и найм экипажа для судов</span>
        </div>
        <div class="apply_job_seach">
            <?$APPLICATION->IncludeComponent("bitrix:search.form", "new-castom-sea", Array(
	"PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
		"USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
	),
	false
);?><br>
        </div>
        <div class="apply_job_button">
          <?$by = $USER->GetID();
            $rsUser = CUser::GetByID($by);
            $arUser = $rsUser->Fetch();
            $arUser["UF_TYPE"];?>
        <?if ($arUser["UF_TYPE"] == 2) {?>
            <a class="apply_job_position" <?if ($USER->IsAuthorized()) {?>onclick="popup_show_job_position(this);" data-popup="position"<?}?>>Подать ваканcию
            </a>
            <?} else if ($arUser["UF_TYPE"] == 1) {?>
            <?
            $arFilter = Array("IBLOCK_ID"=> "6" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
            $parID = false;
            while($ob = $res->GetNextElement()) {
            	$arFields = $ob->GetFields();
            	if ($by == $arFields['CREATED_BY']) {
            	    $parID = true;
            	}
            }
            ?>
            <a class="apply_job_resume"<?if ($USER->IsAuthorized() && $parID == false) {?>onclick="popup_show_job_position(this);" data-popup="resume"<?} else if ($USER->IsAuthorized() && $parID == true){?> data-par="true"<?}?>>Оставить резюме
            </a>
            <script>
                _warning_resume = false;
                $(document).ready(function() {
            	    $('.apply_job_resume').live('click', function() {
                        let dataPar = $('.apply_job_resume').data("par");
                        if (dataPar == true) {
                            let popup_war = document.getElementById("popup_war");
            	            popup_war.classList.add('active');
            	            popup_war.style.height = "63px";
            	            $('#popup_wrapper').addClass('active');
            	            if (_warning_resume == false || _warning_resume == true) {
    	                        _warning_resume = true;
                	            let aldInnerW = '<a class="for_info_war_svg"><svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'+'<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'+'<path d="M10.5 6.75298V10.9752M10.5526 14.1419V14.2474L10.4474 14.247V14.1419H10.5526ZM1 16.6224V4.37798C1 3.19565 1 2.60404 1.2301 2.15245C1.4325 1.75522 1.75522 1.4325 2.15245 1.2301C2.60404 1 3.19565 1 4.37798 1H16.6224C17.8048 1 18.3951 1 18.8467 1.2301C19.2439 1.4325 19.5677 1.75522 19.7701 2.15245C20 2.6036 20 3.19449 20 4.37452V16.626C20 17.806 20 18.3961 19.7701 18.8472C19.5677 19.2444 19.2439 19.5677 18.8467 19.7701C18.3955 20 17.8055 20 16.6255 20H4.37452C3.19449 20 2.6036 20 2.15245 19.7701C1.75522 19.5677 1.4325 19.2444 1.2301 18.8472C1 18.3956 1 17.8048 1 16.6224Z" stroke="#A60303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>'+'</svg></svg></a>'
                	            document.getElementById("for_info_war").innerHTML = aldInnerW+"К сожалению, больше одного резюме нельзя оставлять"
            	            }
                        }
                    });
                });
            </script>
            <?} else if (empty($arUser["UF_TYPE"])) {?>
            <a class="apply_job_position" <?if ($USER->IsAuthorized()) {?>onclick="popup_show_job_position(this);" data-popup="position"<?} else {?>onclick="popup_show(this);" data-popup="auth"<?}?>>Подать ваканcию
            </a>
            <a class="apply_job_resume"<?if ($USER->IsAuthorized()) {?>onclick="popup_show_job_position(this);" data-popup="resume"<?} else {?>onclick="popup_show(this);" data-popup="auth"<?}?>>Оставить резюме
            </a>
        <?}?>
            <a class="apply_bord"<?if ($USER->IsAuthorized()) {?>onclick="popup_show_job_position(this);" data-popup="bord"<?} else {?>onclick="popup_show(this);" data-popup="auth"<?}?>>Разместить объявление
            </a>
        </div>
    </div>
        <div class="main-all-logo">
            <a class="item"><svg xmlns="http://www.w3.org/2000/svg" width="66" height="81" viewBox="0 0 66 81" fill="none">
                <path d="M27.34 41.0616H15.9V30.2716H27.51C27.51 27.5416 27.66 24.9816 27.42 22.4616C27.35 21.7416 26.21 21.0816 25.5 20.4716C18.8 14.7516 20.57 3.9916 28.75 0.801605C34.07 -1.2784 40.09 0.801607 43.03 5.74161C45.95 10.6516 44.81 17.0816 40.14 20.6716C38.77 21.7216 38.32 22.7716 38.41 24.3716C38.51 26.2216 38.43 28.0816 38.43 30.1916H50.08V41.1616C47.2 41.1616 44.33 41.1116 41.46 41.1716C38.3 41.2316 38.45 40.5616 38.44 44.1816C38.4 51.9916 38.43 59.8016 38.43 67.6016C38.43 68.2416 38.43 68.8716 38.43 69.7516C43.7 68.5716 47.66 65.7716 50.86 61.8216C54.06 57.8816 55.45 53.2416 55.78 48.1616H65.95C65.46 59.6016 60.83 68.7916 51.41 75.0216C39.99 82.5916 27.92 82.7416 16.15 75.8216C5.83999 69.7616 0.7 60.3116 0 48.2016H10.18C10.74 54.9016 13.22 60.7716 18.44 65.2416C20.96 67.4016 23.86 68.8916 27.35 69.7716V41.0416L27.34 41.0616ZM37.59 11.6316C37.6 9.10161 35.61 7.04161 33.11 7.01161C30.51 6.98161 28.36 9.05161 28.37 11.5916C28.37 14.1916 30.46 16.2516 33.06 16.2216C35.56 16.1916 37.58 14.1416 37.59 11.6216V11.6316Z" fill="#044F91"/>
                </svg>Крюинг</a>
            <a class="item"><svg xmlns="http://www.w3.org/2000/svg" width="92" height="81" viewBox="0 0 92 81" fill="none">
                <path d="M0.0105024 52.4002C0.336754 52.4213 0.66303 52.4528 0.989282 52.4528C17.9649 52.4528 34.9405 52.4529 51.9161 52.4739C52.6212 52.4739 53.1369 52.2845 53.6526 51.8003C55.8943 49.7165 58.178 47.6538 60.4618 45.6226C60.7249 45.3911 61.1354 45.2016 61.4721 45.2016C71.3334 45.1806 81.184 45.1806 91.0452 45.1911C91.161 45.1911 91.2768 45.2121 91.5083 45.2437C91.5083 46.9802 91.5293 48.7272 91.4872 50.4743C91.4872 50.7374 91.2452 51.011 91.0874 51.2636C85.478 60.6302 79.8474 69.9862 74.259 79.3633C73.8697 80.0158 73.4698 80.2368 72.712 80.2368C48.8851 80.2158 25.0582 80.2158 1.24185 80.2263C0.831408 80.2263 0.410446 80.2789 0 80.3V52.4107L0.0105024 52.4002ZM9.18765 59.0516V64.3031H14.4393V59.0516H9.18765ZM26.058 59.0621H20.7854V64.2926H26.058V59.0621ZM37.6136 59.0621H32.3621V64.3242H37.6136V59.0621ZM43.9177 59.0621V64.3137H49.1693V59.0621H43.9177ZM55.5154 59.0621V64.3453H60.7565V59.0621H55.5154ZM67.092 59.0621V64.3242H72.3437V59.0621H67.092Z" fill="#044F91"/>
                <path d="M61.1774 24.6794H66.1554V14.5024H81.405V24.6899H86.4672V39.7501H61.1774V24.6794Z" fill="#044F91"/>
                <path d="M17.3545 26.9315V12.2397H22.806V17.5965H28.1418V12.2502H33.6565V26.921H17.3545V26.9315Z" fill="#044F91"/>
                <path d="M10.9137 32.4252V37.7084H16.26V32.4147H21.7642V47.0329H5.43054V32.4252H10.9137Z" fill="#044F91"/>
                <path d="M43.5493 47.0539H27.2367V32.4252H32.6987V37.7189H38.0767V32.4042H43.5493V47.0539Z" fill="#044F91"/>
                <path d="M81.3524 9.00875H66.2185V0H81.3524V9.00875Z" fill="#044F91"/>
                </svg>Снабжение флота</a>
            <a class="item"><svg xmlns="http://www.w3.org/2000/svg" width="70" height="83" viewBox="0 0 70 83" fill="none">
                <path d="M53.7999 83C53.1954 82.8668 52.591 82.7541 51.9967 82.6004C45.4088 80.9611 41.0749 75.1416 41.3003 68.2258C41.5052 61.8632 46.4436 56.2896 52.8881 55.1421C60.5518 53.7692 67.8774 59.0149 69.1684 66.7914C70.4286 74.3629 65.0292 81.7193 57.4064 82.8463C57.2322 82.8771 57.058 82.9488 56.8839 83H53.7999ZM44.9272 68.0516C47.673 70.7974 50.4188 73.5433 53.0417 76.1764C56.8941 72.324 60.7977 68.4204 64.6398 64.5783L61.3509 61.2997C58.6256 64.0251 55.8695 66.7914 52.9905 69.6704L48.1751 64.8242L44.9169 68.0618L44.9272 68.0516Z" fill="#044F91"/>
                <path d="M0.0101931 73.1949V0H34.1487V18.0836H52.3245V18.9749C52.3245 29.1386 52.3245 39.3023 52.3347 49.4557C52.3347 50.0602 52.2323 50.3164 51.556 50.4496C42.1096 52.4065 35.7573 60.8592 36.4642 70.5106C36.5257 71.3917 36.6896 72.2625 36.8023 73.1847H0L0.0101931 73.1949ZM32.3455 30.7267C35.1425 26.403 33.493 22.2843 31.0955 20.2659C28.3087 17.9196 24.2412 17.8684 21.3827 20.1327C18.9954 22.0282 17.059 26.1981 19.9482 30.7164C19.8151 30.8291 19.6716 30.9521 19.5282 31.0751C19.3848 31.198 19.2413 31.3209 19.0978 31.4439C17.3458 33.0525 16.2188 35.0299 15.9832 37.4069C15.8397 38.8822 15.8807 40.3679 15.8602 41.8535C15.85 42.6219 15.8602 43.4006 15.8602 44.1895H36.4437C36.4437 42.8371 36.4744 41.5154 36.4437 40.2039C36.413 38.9949 36.4232 37.7655 36.1978 36.577C35.7368 34.1487 34.3639 32.2328 32.3557 30.7062L32.3455 30.7267ZM7.90961 54.681H33.9643V49.9168H7.90961V54.681ZM7.91987 60.3571V65.1111H23.4522V60.3571H7.91987ZM7.91987 8.03258V12.8173H18.2475V8.03258H7.91987Z" fill="#044F91"/>
                <path d="M49.3533 13.2169H39.1179V2.98149L49.3533 13.2169Z" fill="#044F91"/>
                <path d="M20.7679 39.3228C20.5528 35.9417 22.7454 33.7799 26.2904 33.8004C29.6407 33.8209 31.7718 36.0442 31.5361 39.3228H20.7679Z" fill="#044F91"/>
                <path d="M28.9644 26.1059C28.9747 27.6223 27.7247 28.903 26.1981 28.9337C24.692 28.9645 23.3908 27.7145 23.3498 26.1879C23.3088 24.651 24.61 23.3293 26.1571 23.3293C27.6735 23.3293 28.9439 24.5896 28.9644 26.1162V26.1059Z" fill="#044F91"/>
                </svg>Трудоустройство моряков</a>
            <a class="item"><svg xmlns="http://www.w3.org/2000/svg" width="88" height="76" viewBox="0 0 88 76" fill="none">
                <path d="M0 60.3243V0H63.2975V46.2377H9.32956L0 60.3243Z" fill="#044F91"/>
                <path d="M87.3083 76V15.6757H68.1571L67.8598 50.8L24.0109 50.6052V61.9134H77.9788L87.3083 76Z" fill="#044F91"/>
                <path d="M53.0145 10.0575H11.0314V14.4557H53.0145V10.0575Z" fill="white"/>
                <path d="M53.0145 21.1709H11.0314V25.5691H53.0145V21.1709Z" fill="white"/>
                <path d="M53.0145 32.2844H11.0314V36.6826H53.0145V32.2844Z" fill="white"/>
                </svg>Консультирование</a>
            <a class="item"><svg xmlns="http://www.w3.org/2000/svg" width="77" height="76" viewBox="0 0 77 76" fill="none">
                <path d="M63.6974 14.5146C67.7056 14.5146 70.9548 11.2654 70.9548 7.25731C70.9548 3.2492 67.7056 0 63.6974 0C59.6893 0 56.4401 3.2492 56.4401 7.25731C56.4401 11.2654 59.6893 14.5146 63.6974 14.5146Z" fill="#044F91"/>
                <path d="M13.3126 14.5146C17.3207 14.5146 20.5699 11.2654 20.5699 7.25731C20.5699 3.2492 17.3207 0 13.3126 0C9.30451 0 6.0553 3.2492 6.0553 7.25731C6.0553 11.2654 9.30451 14.5146 13.3126 14.5146Z" fill="#044F91"/>
                <path d="M55.8259 59.1206C55.8259 59.1206 63.0832 66.6487 71.6837 59.1206C71.6837 59.1206 78.1289 63.9623 76.1193 74.9784H51.3278C51.3278 74.9784 48.8497 66.4508 55.8363 59.1206H55.8259Z" fill="#044F91"/>
                <path d="M71.6732 15.7225C63.0727 23.2505 55.8154 15.7225 55.8154 15.7225C55.2219 16.3472 54.7221 16.9719 54.264 17.6071C58.5955 21.0848 61.7295 25.9785 62.9894 31.5803H76.0984C78.1184 20.5641 71.6628 15.7225 71.6628 15.7225H71.6732Z" fill="#044F91"/>
                <path d="M23.3189 17.9715C22.2568 16.4513 21.2885 15.7225 21.2885 15.7225C12.688 23.2505 5.43064 15.7225 5.43064 15.7225C-1.55596 23.0423 0.922144 31.5803 0.922144 31.5803H14.6246C15.947 26.1243 19.0602 21.3763 23.3084 17.9715H23.3189Z" fill="#044F91"/>
                <path d="M63.6975 43.3981C63.4268 43.3981 63.1561 43.419 62.8958 43.4398C61.917 47.4589 59.9595 51.0824 57.3044 54.0811C58.5331 56.3614 60.9279 57.9024 63.6975 57.9024C67.7062 57.9024 70.9548 54.6538 70.9548 50.6451C70.9548 46.6364 67.7062 43.3877 63.6975 43.3877V43.3981Z" fill="#044F91"/>
                <path d="M18.5155 51.7367L0.631897 69.6204L6.78701 75.7755L24.6706 57.8919L18.5155 51.7367Z" fill="#044F91"/>
                <path d="M38.6249 16.7116C27.3797 16.7116 18.2585 25.8327 18.2585 37.0779C18.2585 43.4918 21.2364 49.2082 25.8699 52.9462C26.0885 49.8641 27.1714 45.8034 30.7532 42.0446C30.7532 42.0446 38.0105 49.5726 46.611 42.0446C46.611 42.0446 51.0779 45.4285 51.4007 52.9358C56.0341 49.1978 59.0016 43.4918 59.0016 37.0779C59.0016 25.8327 49.8805 16.7116 38.6353 16.7116H38.6249ZM38.6249 40.8472C34.6161 40.8472 31.3675 37.5985 31.3675 33.5898C31.3675 29.5811 34.6161 26.3325 38.6249 26.3325C42.6336 26.3325 45.8822 29.5811 45.8822 33.5898C45.8822 37.5985 42.6336 40.8472 38.6249 40.8472Z" fill="#044F91"/>
                </svg>Подбор персонала</a>
        </div>
</div>
<div class="body-main-middle">
    <div class="body-main-middle-left">
        <span id="body-main-middle-left-title">Новые вакансии</span>
        <div class="body-main-middle-left-info">
         <?$APPLICATION->IncludeComponent(
            	"bitrix:catalog.section",
            	"new-castom-section-martimer-main",
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
            		"DISPLAY_BOTTOM_PAGER" => "Y",
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
            		"LAZY_LOAD" => "N",
            		"LINE_ELEMENT_COUNT" => "3",
            		"LOAD_ON_SCROLL" => "N",
            		"MESSAGE_404" => "",
            		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
            		"MESS_BTN_BUY" => "Купить",
            		"MESS_BTN_DETAIL" => "Подробнее",
            		"MESS_BTN_LAZY_LOAD" => "Показать ещё",
            		"MESS_BTN_SUBSCRIBE" => "Подписаться",
            		"MESS_NOT_AVAILABLE" => "",
            		"MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
            		"META_DESCRIPTION" => "-",
            		"META_KEYWORDS" => "-",
            		"OFFERS_LIMIT" => "5",
            		"PAGER_BASE_LINK_ENABLE" => "N",
            		"PAGER_DESC_NUMBERING" => "N",
            		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            		"PAGER_SHOW_ALL" => "Y",
            		"PAGER_SHOW_ALWAYS" => "N",
            		"PAGER_TEMPLATE" => "grid",
            		"PAGER_TITLE" => "Товары",
            		"PAGE_ELEMENT_COUNT" => "4",
            		"PARTIAL_PRODUCT_PROPERTIES" => "N",
            		"PRICE_CODE" => array(),
            		"PRICE_VAT_INCLUDE" => "Y",
            		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
            		"PRODUCT_ID_VARIABLE" => "id",
            		"PRODUCT_PROPS_VARIABLE" => "prop",
            		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
            		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false},{'VARIANT':'1','BIG_DATA':false}]",
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
    </div>
    <div class="body-main-middle-right">
        <span id="body-main-middle-left-title">Новые резюме</span>
        <div class="body-main-middle-right-info">
         <?$APPLICATION->IncludeComponent(
        	"bitrix:catalog.section",
        	"new-castom-section-martimer-resume-main",
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
        		"SECTION_URL" => "#SITE_DIR#/resume/detailed/index.php?ID=#IBLOCK_ID#",
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
    </div>
</div>

<?if (!$USER->IsAuthorized()) {?>
    <style>
        input.search-suggest::placeholder {
            top: -1px;
        }
        .se-main-in input[type="text"]::placeholder {
            color: #989898;
            font-family: Montserrat;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 0.28px;
            top: 15px;
            margin-left: 41px;
        }
    </style>
<?}?>
<?} else {?>
            <?//Получаем все ID публикаций вакансий
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $fill = parse_url($url, PHP_URL_QUERY);
            if ($fill == "fill=1" || $fill == "") {
                $styleInfo = 1;
                $arFilter = Array("IBLOCK_ID"=> "5" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                //Проверяем на проверку администратором и комментариям
                if (isset($parID)) {
                    foreach ($parID as $NewParID) {
                    	$res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array('ID' => 53));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 53){
                    		    if ($prop['VALUE_ENUM'] == "Нет" || $prop['VALUE_ENUM'] == "") {
                    		        $comparison1[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                    foreach ($parID as $NewParID) {
                        $res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array('ID' => 106));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 106) {
                    		    if ($prop['VALUE'] == "" || $prop['VALUE'] != 468) {
                    		        $comparison2[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                }
                if (@$comparison1 or $comparison2 === 0) {  
                    $notVerified = array_intersect($comparison1, $comparison2);
                }
                if ($notVerified[1] != "" || $notVerified[0] != "") {
                    $result = $notVerified;
                } else {
                    $result = 1;
                }
            } else if ($fill == "fill=2") {
                $styleInfo = 2;
                $arFilter = Array("IBLOCK_ID"=> "5" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                //Проверяем на проверку администратором и комментариям
                if (isset($parID)) {
                    foreach ($parID as $NewParID) {
                    	$res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array('ID' => 53));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 53){
                    		    if ($prop['VALUE_ENUM'] == "Да") {
                    		        $comparison1[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                    foreach ($parID as $NewParID) {
                        $res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array('ID' => 56));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 56){
                    		    if ($prop['VALUE'] == "" || $prop['VALUE'] != "") {
                    		        $comparison2[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                }
                if (@$comparison1 or $comparison2 === 0) {  
                    $notVerified = array_intersect($comparison1, $comparison2);
                }
                if ($notVerified[1] != "" || $notVerified[0] != "") {
                    $result = $notVerified;
                } else {
                    $result = 1;
                }
            } else if ($fill == "fill=3") {
                $styleInfo = 3;
                $arFilter = Array("IBLOCK_ID"=> "5" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                //Проверяем на проверку администратором и комментариям
                if (isset($parID)) {
                    foreach ($parID as $NewParID) {
                    	$res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array('ID' => 53));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 53){
                    		    if ($prop['VALUE_ENUM'] == "Отклонено") {
                    		        $comparison1[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                    foreach ($parID as $NewParID) {
                        $res = CIBlockElement::GetProperty(5, $NewParID, array("sort" => "asc", ), Array('ID' => 56));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 56){
                    		    if ($prop['VALUE'] != "" || $prop['VALUE'] == "") {
                    		        $comparison2[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                }
                if (@$comparison1 or $comparison2 === 0) {  
                    $notVerified = array_intersect($comparison1, $comparison2);
                }
                if ($notVerified[1] != "" || $notVerified[0] != "") {
                    $result = $notVerified;
                } else {
                    $result = 1;
                }
            }
            //echo "<pre>";
    		//print_r($notVerified) ;
    		//print_r($result) ;
    	   // echo "<pre>";
    	   ?>
        <?//}?>
    <div class="panel-main-adm-ren">
        <div class="panel-main-adm-ren-top-left">
            <a class="not-verified" <?if ($styleInfo == 1) {?>style="font-weight: 700;"<?}?> href="/?fill=1">Не проверенные</a> /
            <a class="yes-verified" <?if ($styleInfo == 2) {?>style="font-weight: 700;"<?}?> href="/?fill=2">Принятые</a> /
            <a class="Rejected" <?if ($styleInfo == 3) {?>style="font-weight: 700;"<?}?> href="/?fill=3">Отклонённые</a>
        </div>
        <div class="panel-main-adm-ren-top-left-t">
            <div class="info-panel-v">Вакансии</div>
            <div class="info-panel-2">
                <a class="info-panel"href="/adm-bord/index.php?fill=1">Объявления</a>
                <a class="info-panel" href="/adm_resume/index.php?fill=1">Резюме</a>
            </div>
        </div>
        <?$GLOBALS['NEWarrFilter']=Array("ID" => $result);?>
        <div class="panel-main-adm-ren-top-left-middle">
            <?$APPLICATION->IncludeComponent(
                	"bitrix:catalog.section",
                	"new-castom-section-martimer-for-adm",
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
                		"FILTER_NAME" => "NEWarrFilter",
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
        </div>
        <div class="panel-main-adm-ren-new-applick" style="display:none">Новых заявок не поступало</div>
    </div>
<script>
    let _ver_panel = document.querySelector('.product-item');
    if (_ver_panel == null) {
        document.querySelector('.panel-main-adm-ren-new-applick').style = "display: block"
    }

    function general_all_adm(e) {
        let type = $(e).data("type");
        let pubID = $(e).data("id");
        let view = $(e).data("view");
        
        if (type == "vac" && view == "accept") {
            var overjs = "";
            var typeJS = type;
            var pubIDJS = pubID;
            var viewJS = view;
            
            AddGeneral(typeJS, pubIDJS, viewJS, overjs);
        } else if (type == "vac" && view == "del") {
            var overjs = document.querySelector('.form-titlle-fall-input').value;
            if (overjs == "") {
                let popup_fall_info = document.getElementById("popup_fall_info");
                popup_fall_info.classList.add('active');
                $('#popup_wrapper').addClass('active');
                let button = document.querySelector(".form-titlle-fall-buttons");
                button.setAttribute('data-type', type);
                button.setAttribute('data-id', pubID);
                button.setAttribute('data-view', view);
            } else {
                var typeJS = type;
                var pubIDJS = pubID;
                var viewJS = view;
                AddGeneral(typeJS, pubIDJS, viewJS, overjs);
            }
        } else if (type == "vac" && view == "vievBe") {
            let overBe = $(e).data("info");
            let buttonDelIsDel = document.querySelector(".form-titlle-fall-buttons-del-del");
            let popup_fall_info = document.getElementById("popup_fall_info");
            document.querySelector('.form-titlle-fall-input').value = overBe;
            popup_fall_info.classList.add('active');
            $('#popup_wrapper').addClass('active');
            document.querySelector('.form-titlle-fall-buttons-del-del').style = "display:block"
            buttonDelIsDel.setAttribute('data-type', type);
            buttonDelIsDel.setAttribute('data-id', pubID);
            document.getElementById('form-titlle-fall-buttons').textContent = "Изменить";
            let button = document.querySelector(".form-titlle-fall-buttons");
            button.setAttribute('data-type', type);
            button.setAttribute('data-id', pubID);
            button.setAttribute('data-view', 'editBe');
        } else if (type == "vac" && view == "delBe") {
            var overjs = "";
            var typeJS = type;
            var pubIDJS = pubID;
            var viewJS = view;
            AddGeneral(typeJS, pubIDJS, viewJS, overjs);
        } else if (type == "vac" && view == "editBe") {
            var overjs = document.querySelector('.form-titlle-fall-input').value;
            if (overjs != "") {
                var typeJS = type;
                var pubIDJS = pubID;
                var viewJS = view;
                AddGeneral(typeJS, pubIDJS, viewJS, overjs);
            } else {
                alert("Нельзя изменять на пустой комментарий!")
            }
        }
    };
    
</script>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>