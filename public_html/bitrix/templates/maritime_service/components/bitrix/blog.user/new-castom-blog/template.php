<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Page\Asset; 
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style.css'); 
?>
<?
if (!$this->__component->__parent || empty($this->__component->__parent->__name) || $this->__component->__parent->__name != "bitrix:blog"):
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/themes/blue/style.css');
endif;
?>

<?
if($arResult["FATAL_ERROR"] <> '')
{
	?>
	<span class='errortext'><?=$arResult["FATAL_ERROR"]?></span><br /><br />
	<?
}
else
{
	if($arResult["ERROR_MESSAGE"] <> '')
	{
		?>
		<span class='errortext'><?=$arResult["ERROR_MESSAGE"]?></span><br /><br />
		<?
	}
	
	if($arResult["bEdit"]=="Y")
	{
		?>
		<form method="post" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data">
		<table class="blog-table-header-left">
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_ALIAS")?></th><?//=$arResult["arUser"]["WORK_COMPANY"]?>
			<td><input type=text size="47" name="ALIAS" value="<?=$arResult["User"]["WORK_COMPANY"]?>"></td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_ABOUT")?></th>
			<td><textarea name="DESCRIPTION" style="width:98%" rows="5"><?=$arResult["User"]["DESCRIPTION"]?></textarea></td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_SITE")?></th>
			<td><input type=text size="47" name="PERSONAL_WWW" value="<?=$arResult["User"]["PERSONAL_WWW"]?>"></td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_SEX")?></th>
			<td>
				<select name="PERSONAL_GENDER">
					<?
					foreach($arResult["arSex"] as $k => $v)
					{
					?>
						<option value="<?=$k?>"<?if($k==$arResult["User"]["PERSONAL_GENDER"]) echo " selected";?>><?=$v?></option>
					<?
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_BIRTHDAY")?></th>
			<td>
			<?
			$APPLICATION->IncludeComponent(
				'bitrix:main.calendar',
				'',
				array(
					'SHOW_INPUT' => 'Y',
					'FORM_NAME' => 'form1',
					'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
					'INPUT_VALUE' => $arResult["User"]["PERSONAL_BIRTHDAY"],
					'SHOW_TIME' => 'N'
				),
				null,
				array('HIDE_ICONS' => 'Y')
			);?></td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_PHOTO")?></th>
			<td>
				<input name="PERSONAL_PHOTO" size="30" type="file"><br />
				<label><input name="PERSONAL_PHOTO_del" value="Y" type="checkbox"><?=GetMessage("BU_DELETE_FILE");?></label>
				<?if ($arResult["User"]["PERSONAL_PHOTO_ARRAY"]!==false):?>
					<br /><?=$arResult["User"]["PERSONAL_PHOTO_IMG"]?>
				<?endif?>
			</td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_AVATAR")?></th>
			<td>
				<input name="AVATAR" size="30" type="file"><br />
				<label><input name="AVATAR_del" value="Y" type="checkbox"><?=GetMessage("BU_DELETE_FILE");?></label>
				<?if ($arResult["User"]["AVATAR_ARRAY"]!==false):?>
					<br /><?=$arResult["User"]["AVATAR_IMG"]?>
				<?endif?>
			</td>
		</tr>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_INTERESTS")?></th>
			<td><textarea name="INTERESTS" style="width:98%" rows="5"><?=$arResult["User"]["INTERESTS"]?></textarea></td>
		</tr>
		<?// ********************* User properties ***************************************************?>
		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
			<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
			<tr><th>
				<?if ($arUserField["MANDATORY"]=="Y"):?>
					<span class="required">*</span>
				<?endif;?>
				<?=$arUserField["EDIT_FORM_LABEL"]?>:</th><td>
					<?$APPLICATION->IncludeComponent(
						"bitrix:system.field.edit", 
						$arUserField["USER_TYPE"]["USER_TYPE_ID"], 
						array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
			<?endforeach;?>
		<?endif;?>
		
		<?// ******************** /User properties ***************************************************?>
		<tr>
			<th nowrap><?=GetMessage("B_B_USER_LAST_AUTH")?></th>
			<td><?=$arResult["User"]["LAST_VISIT_FORMATED"]?>&nbsp;</td>
		</tr>
		</table>
		<?
		if ($arParams['USER_CONSENT'] == 'Y')
			$APPLICATION->IncludeComponent(
				"bitrix:main.userconsent.request",
				"",
				array(
					"ID" => $arParams["USER_CONSENT_ID"],
					"IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
					"AUTO_SAVE" => "Y",
					"IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
					"ORIGIN_ID" => "sender/sub",
					"ORIGINATOR_ID" => "",
					"REPLACE" => array(
						'button_caption' => GetMessage("B_B_USER_SAVE"),
						'fields' => array(GetMessage("B_B_USER_ALIAS"), GetMessage("B_B_USER_SITE"), GetMessage("B_B_USER_BIRTHDAY"), GetMessage("B_B_USER_PHOTO"))
					),
				)
			);
		?>
		<div class="blog-buttons">
			<input type="hidden" name="BLOG_USER_ID" value="<?=$arResult["BlogUser"]["ID"]?>">
			<input type="hidden" name="ID" value="<?=$arParams["ID"]?>">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="mode" value="edit">
			<input type="submit" name="save" value="<?=GetMessage("B_B_USER_SAVE")?>">
			<input type="reset" name="cancel" value="<?=GetMessage("B_B_USER_CANCEL")?>" OnClick="window.location='<?=$arResult["urlToCancel"]?>'">
		</div>
		</form>
		<?
	}
	else
	{
		if($arResult["urlToEdit"] <> '')
		{
		}
		?>
		<?//THIS?>
		<div class="blog-table-header-left-class-new">
		    <div class="blog-table-header-left-class-new-left">
        		<table class="blog-table-header-left">
        		<tr>
        			<th class="blog-table-header-left-adress" id="blog-table-header-left-adress" data-name="<?=$arResult["User"]["WORK_COMPANY"]?>">Адрес</th>
        			<td><?if ($arResult["User"]["WORK_STREET"] != ""){?><?=$arResult["User"]["WORK_STREET"]?><?} else {?>—<?}?><br />
        			</td>
        		</tr>
        		</table>
        		<table class="blog-table-header-left-three">
            		<tr>
            			<th class="blog-table-header-left-number-phone">Номер телефона</th>
            			<td class="blog-table-header-left-number-phone-1"><?if ($arResult["User"]["WORK_PHONE"] != ""){?><?=$arResult["User"]["WORK_PHONE"]?><?} else {?>—<?}?></td>
            		</tr>
            		<tr class="blog-table-header-left-email-all">
            			<th class="blog-table-header-left-email">Почта</th>
            			<td><?if ($arResult["User"]["EMAIL"] != ""){?><?=$arResult["User"]["EMAIL"]?><?} else {?>—<?}?></td>
            		</tr>
            		<tr>
            			<th class="blog-table-header-left-www">Веб-сайт</th>
            			<td><?if ($arResult["User"]["WORK_WWW"] != ""){?><?=$arResult["User"]["WORK_WWW"]?><?} else {?>—<?}?></td>
            		</tr>
        		</table>
        		<table class="blog-table-header-left-line-m">
        		<?// ********************* User properties ***************************************************?>
        		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
        			<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
        			<th nowrap><?=$arUserField["EDIT_FORM_LABEL"]?>:</th><td>
        					<?$APPLICATION->IncludeComponent(
        						"bitrix:system.field.view", 
        						$arUserField["USER_TYPE"]["USER_TYPE_ID"], 
        						array("arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?></td></tr>			
        			<?endforeach;?>
        		<?endif;?>
        		<?// ******************** /User properties ***************************************************?>		
        		</table>
        		<table class="blog-table-header-left-reg-info">
        			<th class="blog-table-header-left-title-acc">Дата создания аккаунта</th>
        			<td class="blog-table-header-left-acc-date"><? echo strtolower(FormatDate("d F Y", MakeTimeStamp($arResult["User"]['DATE_REG'])))?></td>
        		</tr>
        		</table>
    		</div>
    		<div class="blog-table-header-left-class-new-right">
    		    <table class="blog-table-header-class-new-right-table">
    		        <?if (isset($arResult["User"]['WORK_LOGO'])) {?>
    		            <td class="blog-table-header-class-new-right-table-logo"><?echo CFile::ShowImage($arResult["User"]['WORK_LOGO'], 98, 98, 'border=0', '', true); ?></td>
    		        <?} else {?>
    		            <td class="blog-table-header-class-new-right-table-logo-1" style="background: #D9D9D9;left: 109px; width: 313px;height: 313px;top: -120px;position: relative;margin-bottom: -114px;"><a>фото отсутствует</a></td>
    		        <?}?>
    		        <?$byNew = $USER->GetID();
                    $rsUserNew = CUser::GetByID($byNew);
                    $arUserNew = $rsUserNew->Fetch();
                    $arUserNew["UF_AD_APP"];
                    ?>
                    
    		        <?if ($arUserNew["UF_AD_APP"] == "4") {?>
    		        <?
    		            //Получаем id пользователя
    		            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $fill = parse_url($url, PHP_URL_QUERY);
                        $pubIDPHP = substr($fill , 3);
                        
                        //Проверка на заблокированность
                        $rsUser = CUser::GetByID($pubIDPHP);
                        $arUser = $rsUser->Fetch();
                        $arUser['BLOCKED'];
                        $arUser['UF_EXAMIN'];
                        //print_r ($arUser['UF_EXAMIN'])
    		           ?>
    		            <td class="vac-examen-user-or-comp"><input class="vac-examen-user-or-comp-input <? if ($arUser['UF_EXAMIN'] == 6){?>active" checked="checked" <?} else {?>"<?}?> id="vac-examen-user-or-comp-input" data-type="examen" data-user=<?=$pubIDPHP?> type="checkbox">Не проверять вакансии</input></td>
    		            <td class="vac-block-user-or-comp"><input class="vac-block-user-or-comp-input <? if ($arUser['BLOCKED'] == "Y"){?>active" checked="checked"<?}else {?>"<?}?> id="vac-block-user-or-comp-input" data-type="blocked" data-user=<?=$pubIDPHP?> type="checkbox">Заблокировать пользователя</input></td>
    		           <style>
    		               .blog-table-header-class-new-right-table-logo {
                                width: 313px;
                                height: 199px;
                            }
                            .blog-table-header-class-new-right-table tr {
                                display:grid;
                            }
                            td.vac-examen-user-or-comp {
                                margin-left: 109px;
                                margin-top: 20px;
                                font-size: 16px;
                                font-weight: 500;
                            }
                            
                            td.vac-block-user-or-comp {
                                margin-left: 109px;
                                margin-top: 20px;
                                font-size: 16px;
                                font-weight: 500;
                            }
                            
                            input.vac-examen-user-or-comp-input {
                                cursor: pointer;
                                width: 18px;
                                height: 18px;
                                padding: 0;
                                margin: 0px 5px 0 0;
                                appearance: none;
                                background-color: initial;
                                border: 1px solid #333;
                                border: 1px solid #D9D9D9;
                                flex-shrink: 0;
                                border-radius: 5px;
                            }
                            
                            .vac-examen-user-or-comp-input.active {
                                background: #035AA6;
                                background-image: url(/bitrix/templates/maritime_service/images/svg/checkbox.svg), url(/bitrix/templates/maritime_service/images/svg/tick.svg);
                                background-position: top right 15px, bottom 4px left 3px, top left 10px;
                                background-repeat: no-repeat;
                            }
                            
                            input.vac-block-user-or-comp-input {
                                cursor: pointer;
                                margin-top: -4px;
                                padding-top: 1px;
                                width: 18px;
                                height: 18px;
                                padding: 0px 0px 0px 0px;
                                margin: 0px 5px 0 0;
                                appearance: none;
                                background-color: initial;
                                border: 1px solid #333;
                                border: 1px solid #D9D9D9;
                                flex-shrink: 0;
                                border-radius: 5px;
                            }
                            .vac-block-user-or-comp-input.active {
                                background: #035AA6;
                                background-image: url(/bitrix/templates/maritime_service/images/svg/checkbox.svg), url(/bitrix/templates/maritime_service/images/svg/tick.svg);
                                background-position: top right 15px, bottom 4px left 3px, top left 10px;
                                background-repeat: no-repeat;
                            }
    		           </style>
    		           
    		           <script>
    		           // функция отслеживания клика для изменения подтверждения политики и раскрытие блока с правилами 
                        $(document).ready(function() {
                            
                            //Блокировка
                            $('#vac-block-user-or-comp-input').live('click', function() {
                                $('#vac-block-user-or-comp-input').addClass("active");
                                if (document.getElementById('vac-block-user-or-comp-input').checked == true) {
                                    let _par = $("#vac-block-user-or-comp-input").data('user');
                                    let _parType = $("#vac-block-user-or-comp-input").data('type');
                                    let _view = true;
                                    
                                    admDelandNot(_par, _parType, _view)
                                }
                            });
                            //Снятие блокировки
                            $('.vac-block-user-or-comp-input.active').live('click', function() {
                                $('#vac-block-user-or-comp-input').removeClass("active");
                                if (document.getElementById('vac-block-user-or-comp-input').checked == false) {
                                    let _par = $("#vac-block-user-or-comp-input").data('user');
                                    let _parType = $("#vac-block-user-or-comp-input").data('type');
                                    let _view = false;
                                    
                                    admDelandNot(_par, _parType, _view)
                                }
                            });
                            
                            //Не проверять вакансии
                            $('#vac-examen-user-or-comp-input').live('click', function() {
                                  $('#vac-examen-user-or-comp-input').addClass("active");
                                  if (document.getElementById('vac-examen-user-or-comp-input').checked == true) {
                                    let _par = $("#vac-examen-user-or-comp-input").data('user');
                                    let _parType = $("#vac-examen-user-or-comp-input").data('type');
                                    let _view = true;
                                    
                                    admDelandNot(_par, _parType, _view)
                                }
                            });
                            //Проверять вакансии
                            $('.vac-examen-user-or-comp-input.active').live('click', function() {
                                  $('#vac-examen-user-or-comp-input').removeClass("active");
                                  if (document.getElementById('vac-examen-user-or-comp-input').checked == false) {
                                    let _par = $("#vac-examen-user-or-comp-input").data('user');
                                    let _parType = $("#vac-examen-user-or-comp-input").data('type');
                                    let _view = false;
                                    
                                    admDelandNot(_par, _parType, _view)
                                }
                            });
                        })
    		           </script>
    		        <?}?>
    		    </table>
		    </div>
    	</div>
		</div>
		<table class="blog-table-header-left-notifi-info">
			<th class="blog-table-header-left-title-notifi">Описание компании</th>
			<td class="blog-table-header-left-notifi"><?=$arResult["User"]['WORK_PROFILE']?></td>
		</tr>
		</table>
		<table class="blog-table-header-left-all-seach-public">
		    <th class="blog-table-header-left-all-seach-public-cells">Вакансии компании</th>
		    <td class="blog-table-header-left-all-seach-public-cells-viv">
		        <?
		        //print_r($arResult["User"]['ID']);?>
		        <?$arFilter = Array("IBLOCK_ID"=> "5" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "CREATED_BY" => $arResult["User"]['USER_ID']);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
                while($ob = $res->GetNextElement()) {
                	$arFields = $ob->GetFields();
                	$parID[] = $arFields['ID'];
                }
                
                ?>

		        <? if (isset($parID)) {
		            foreach ($parID as $newID) {
                	     $res = CIBlockElement::GetProperty(5, $newID, array("sort" => "asc", ), Array("ID"=>"53"));
                    	 while ($ob = $res->GetNext()) {
                    		 $prop = $ob;
                    		 if ($prop['VALUE_ENUM'] == "Да") {
                                 $yesParID[] = $newID;
                    	     };
                         }
		            }
                 }?>
		         <?$GLOBALS['arrFilterRR'] = Array("ID" => $yesParID);?>
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
                    		"FILTER_NAME" => "arrFilterRR",
                    		"IBLOCK_ID" => "5",
                    		"IBLOCK_TYPE" => "job",
                    		"INCLUDE_SUBSECTIONS" => "Y",
                    		"LABEL_PROP" => array(),
                    		"LAZY_LOAD" => "Y",
                    		"LINE_ELEMENT_COUNT" => "1",
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
                    );?>
		    </td>
		</table>
		<?
	}
}
?>
<script>
let newPars = $('.blog-table-header-left-adress');
document.querySelector('.page-left-top h1').innerHTML = newPars.data('name');
</script>