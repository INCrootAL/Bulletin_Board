<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявки по резюме");
?>
<?$byNew = $USER->GetID();
$rsUserNew = CUser::GetByID($byNew);
$arUserNew = $rsUserNew->Fetch();
$arUserNew["UF_AD_APP"];
?>
            
<?if ($arUserNew["UF_AD_APP"] == "4") {?>
            <?//Получаем все ID публикаций вакансий
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $fill = parse_url($url, PHP_URL_QUERY);
            if ($fill == "fill=1" || $fill == "") {
                $styleInfo = 1;
                $arFilter = Array("IBLOCK_ID"=> "6" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                //Проверяем на проверку администратором и комментариям
                if (isset($parID)) {
                    foreach ($parID as $NewParID) {
                    	$res = CIBlockElement::GetProperty(6, $NewParID, array("sort" => "asc", ), Array('ID' => 102));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 102){
                    		    if ($prop['VALUE_ENUM'] == "Нет" || $prop['VALUE_ENUM'] == "") {
                    		        $comparison1[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                    foreach ($parID as $NewParID) {
                         $res = CIBlockElement::GetProperty(6, $NewParID, array("sort" => "asc", ), Array('ID' => 105));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 105) {
                    		    if ($prop['VALUE'] == "" || $prop['VALUE'] != 466) {
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
                $arFilter = Array("IBLOCK_ID"=> "6" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                //Проверяем на проверку администратором и комментариям
                if (isset($parID)) {
                    foreach ($parID as $NewParID) {
                    	$res = CIBlockElement::GetProperty(6, $NewParID, array("sort" => "asc", ), Array('ID' => 102));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 102){
                    		    if ($prop['VALUE_ENUM'] == "Да") {
                    		        $comparison1[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                    foreach ($parID as $NewParID) {
                        $res = CIBlockElement::GetProperty(6, $NewParID, array("sort" => "asc", ), Array('ID' => 103));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 103){
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
                $arFilter = Array("IBLOCK_ID"=> "6" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                //Проверяем на проверку администратором и комментариям
                if (isset($parID)) {
                    foreach ($parID as $NewParID) {
                    	$res = CIBlockElement::GetProperty(6, $NewParID, array("sort" => "asc", ), Array('ID' => 102));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 102){
                    		    if ($prop['VALUE_ENUM'] == "Отклонено") {
                    		        $comparison1[] = $NewParID;
                    		    }
                    		}
                    	};
                    }
                    foreach ($parID as $NewParID) {
                        $res = CIBlockElement::GetProperty(6, $NewParID, array("sort" => "asc", ), Array('ID' => 103));
                    	while ($ob = $res->GetNext()) {
                    		$prop = $ob;
                    		if ($prop["ID"] == 103){
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
    		//print_r($fill) ;
    		//print_r($result) ;
    	   // echo "<pre>";
    	   ?>
        <?//}?>
    <div class="panel-main-adm-ren">
        <div class="panel-main-adm-ren-top-left">
            <a class="not-verified" <?if ($styleInfo == 1) {?>style="font-weight: 700;"<?}?> href="/adm_resume/index.php?fill=1">Не проверенные</a> /
            <a class="yes-verified" <?if ($styleInfo == 2) {?>style="font-weight: 700;"<?}?> href="/adm_resume/index.php?fill=2">Принятые</a> /
            <a class="Rejected" <?if ($styleInfo == 3) {?>style="font-weight: 700;"<?}?> href="/adm_resume/index.php?fill=3">Отклонённые</a>
        </div>
        <div class="panel-main-adm-ren-top-left-t">
            <div class="info-panel-v">Резюме</div>
            <div class="info-panel-2">
                <a class="info-panel" href="/adm-bord/index.php?fill=1">Объявления</a>
                <a class="info-panel" href="/?fill=1">Вакансии</a>
            </div>
        </div>
        <?$GLOBALS['NEWarrFilter']=Array("ID" => $result);?>
        <div class="panel-main-adm-ren-top-left-middle">
            <?$APPLICATION->IncludeComponent(
                	"bitrix:catalog.section",
                	"new-castom-section-martimer-resume-for-adm",
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
                		"FILTER_NAME" => "NEWarrFilter",
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
        
        if (type == "res" && view == "accept") {
            var overjs = "";
            var typeJS = type;
            var pubIDJS = pubID;
            var viewJS = view;
            
            AddGeneral(typeJS, pubIDJS, viewJS, overjs);
        } else if (type == "res" && view == "del") {
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
        } else if (type == "res" && view == "vievBe") {
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
        } else if (type == "res" && view == "delBe") {
            var overjs = "";
            var typeJS = type;
            var pubIDJS = pubID;
            var viewJS = view;
            AddGeneral(typeJS, pubIDJS, viewJS, overjs);
        } else if (type == "res" && view == "editBe") {
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
<?} else {
    header('Location:' .'http://'. $_SERVER['HTTP_HOST'] .'/404.php');
    exit( ); 
    }?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>