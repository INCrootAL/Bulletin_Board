<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
global $USER;
use Bitrix\Main\Page\Asset;
?>
<div class="search-page" id="search-page-seach">
	<?if($arParams["SHOW_TAGS_CLOUD"] == "Y")
	{
		$arCloudParams = Array(
			"SEARCH" => $arResult["REQUEST"]["~QUERY"],
			"TAGS" => $arResult["REQUEST"]["~TAGS"],
			"CHECK_DATES" => $arParams["CHECK_DATES"],
			"arrFILTER" => $arParams["arrFILTER"],
			"SORT" => $arParams["TAGS_SORT"],
			"PAGE_ELEMENTS" => $arParams["TAGS_PAGE_ELEMENTS"],
			"PERIOD" => $arParams["TAGS_PERIOD"],
			"URL_SEARCH" => $arParams["TAGS_URL_SEARCH"],
			"TAGS_INHERIT" => $arParams["TAGS_INHERIT"],
			"FONT_MAX" => $arParams["FONT_MAX"],
			"FONT_MIN" => $arParams["FONT_MIN"],
			"COLOR_NEW" => $arParams["COLOR_NEW"],
			"COLOR_OLD" => $arParams["COLOR_OLD"],
			"PERIOD_NEW_TAGS" => $arParams["PERIOD_NEW_TAGS"],
			"SHOW_CHAIN" => "N",
			"COLOR_TYPE" => $arParams["COLOR_TYPE"],
			"WIDTH" => $arParams["WIDTH"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"RESTART" => $arParams["RESTART"],
		);

		if(is_array($arCloudParams["arrFILTER"]))
		{
			foreach($arCloudParams["arrFILTER"] as $strFILTER)
			{
				if($strFILTER=="main")
				{
					$arCloudParams["arrFILTER_main"] = $arParams["arrFILTER_main"];
				}
				elseif($strFILTER=="forum" && IsModuleInstalled("forum"))
				{
					$arCloudParams["arrFILTER_forum"] = $arParams["arrFILTER_forum"];
				}
				elseif(mb_strpos($strFILTER,"iblock_")===0)
				{
					foreach($arParams["arrFILTER_".$strFILTER] as $strIBlock)
						$arCloudParams["arrFILTER_".$strFILTER] = $arParams["arrFILTER_".$strFILTER];
				}
				elseif($strFILTER=="blog")
				{
					$arCloudParams["arrFILTER_blog"] = $arParams["arrFILTER_blog"];
				}
				elseif($strFILTER=="socialnetwork")
				{
					$arCloudParams["arrFILTER_socialnetwork"] = $arParams["arrFILTER_socialnetwork"];
				}
			}
		}
		$APPLICATION->IncludeComponent("bitrix:search.tags.cloud", ".default", $arCloudParams, $component, array("HIDE_ICONS" => "Y"));
	}
	?>
	<form action="" method="get" class="seach-seach">
		<input type="hidden" name="tags" value="<?echo $arResult["REQUEST"]["TAGS"]?>" />
		<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody><tr  class="seach-h">
				<td style="width: 100%;" class="seach-h-h">
					<?if($arParams["USE_SUGGEST"] === "Y"):
						if(mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
						{
							$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
							$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
							$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
						}
						?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:search.suggest.input",
							"",
							array(
								"NAME" => "q",
								"VALUE" => $arResult["REQUEST"]["~QUERY"],
								"INPUT_SIZE" => -1,
								"DROPDOWN_SIZE" => 10,
								"FILTER_MD5" => $arResult["FILTER_MD5"],
							),
							$component, array("HIDE_ICONS" => "Y")
						);?>
					<?else:?>
						<input class="search-query" type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" />
					<?endif;?>
				</td>
				<td>
					&nbsp;
				</td>
				<td>
					<input class="search-button" type="submit" value="<?echo GetMessage("CT_BSP_GO")?>" />
				</td>
			</tr>
		</tbody></table>

		<!--<noindex>
		<div class="search-advanced">
			<div class="search-advanced-result">
				<?if(is_object($arResult["NAV_RESULT"])):?>
					<div class="search-result"><?echo GetMessage("CT_BSP_FOUND")?>: <?echo $arResult["NAV_RESULT"]->SelectedRowsCount()?></div>
				<?endif;?>
				<?
				$arWhere = array();

				if(!empty($arResult["TAGS_CHAIN"]))
				{
					$tags_chain = '';
					foreach($arResult["TAGS_CHAIN"] as $arTag)
					{
						$tags_chain .= ' '.$arTag["TAG_NAME"].' [<a href="'.$arTag["TAG_WITHOUT"].'" class="search-tags-link" rel="nofollow">x</a>]';
					}

					$arWhere[] = GetMessage("CT_BSP_TAGS").' &mdash; '.$tags_chain;
				}

				if($arParams["SHOW_WHERE"])
				{
					$where = GetMessage("CT_BSP_EVERYWHERE");
					foreach($arResult["DROPDOWN"] as $key=>$value)
						if($arResult["REQUEST"]["WHERE"]==$key)
							$where = $value;

					$arWhere[] = GetMessage("CT_BSP_WHERE").' &mdash; '.$where;
				}

				if($arParams["SHOW_WHEN"])
				{
					if($arResult["REQUEST"]["FROM"] && $arResult["REQUEST"]["TO"])
						$when = GetMessage("CT_BSP_DATES_FROM_TO", array("#FROM#" => $arResult["REQUEST"]["FROM"], "#TO#" => $arResult["REQUEST"]["TO"]));
					elseif($arResult["REQUEST"]["FROM"])
						$when = GetMessage("CT_BSP_DATES_FROM", array("#FROM#" => $arResult["REQUEST"]["FROM"]));
					elseif($arResult["REQUEST"]["TO"])
						$when = GetMessage("CT_BSP_DATES_TO", array("#TO#" => $arResult["REQUEST"]["TO"]));
					else
						$when = GetMessage("CT_BSP_DATES_ALL");

					$arWhere[] = GetMessage("CT_BSP_WHEN").' &mdash; '.$when;
				}

				if(count($arWhere))
					echo GetMessage("CT_BSP_WHERE_LABEL"),': ',implode(", ", $arWhere);
				?>
			</div><?//div class="search-advanced-result"?>
			<?if($arParams["SHOW_WHERE"] || $arParams["SHOW_WHEN"]):?>
				<script>
				function switch_search_params()
				{
					var sp = document.getElementById('search_params');
					if(sp.style.display == 'none')
					{
						disable_search_input(sp, false);
						sp.style.display = 'block'
					}
					else
					{
						disable_search_input(sp, true);
						sp.style.display = 'none';
					}
					return false;
				}

				function disable_search_input(obj, flag)
				{
					var n = obj.childNodes.length;
					for(var j=0; j<n; j++)
					{
						var child = obj.childNodes[j];
						if(child.type)
						{
							switch(child.type.toLowerCase())
							{
								case 'select-one':
								case 'file':
								case 'text':
								case 'textarea':
								case 'hidden':
								case 'radio':
								case 'checkbox':
								case 'select-multiple':
									child.disabled = flag;
									break;
								default:
									break;
							}
						}
						disable_search_input(child, flag);
					}
				}
				</script>
				<div class="search-advanced-filter"><a href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADVANCED_SEARCH')?></a></div>
		</div><?//div class="search-advanced"?>
				<div id="search_params" class="search-filter" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"] || $arResult["REQUEST"]["WHERE"]? 'block': 'none'?>">
					<h2><?echo GetMessage('CT_BSP_ADVANCED_SEARCH')?></h2>
					<table class="search-filter" cellspacing="0"><tbody>
						<?if($arParams["SHOW_WHERE"]):?>
						<tr>
							<td class="search-filter-name"><?echo GetMessage("CT_BSP_WHERE")?></td>
							<td class="search-filter-field">
								<select class="select-field" name="where">
									<option value=""><?=GetMessage("CT_BSP_ALL")?></option>
									<?foreach($arResult["DROPDOWN"] as $key=>$value):?>
										<option value="<?=$key?>"<?if($arResult["REQUEST"]["WHERE"]==$key) echo " selected"?>><?=$value?></option>
									<?endforeach?>
								</select>
							</td>
						</tr>
						<?endif;?>
						<?if($arParams["SHOW_WHEN"]):?>
						<tr>
							<td class="search-filter-name"><?echo GetMessage("CT_BSP_WHEN")?></td>
							<td class="search-filter-field">
								<?$APPLICATION->IncludeComponent(
									'bitrix:main.calendar',
									'',
									array(
										'SHOW_INPUT' => 'Y',
										'INPUT_NAME' => 'from',
										'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
										'INPUT_NAME_FINISH' => 'to',
										'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
										'INPUT_ADDITIONAL_ATTR' => 'class="input-field" size="10"',
									),
									null,
									array('HIDE_ICONS' => 'Y')
								);?>
							</td>
						</tr>
						<?endif;?>
						<tr>
							<td class="search-filter-name">&nbsp;</td>
							<td class="search-filter-field"><input class="search-button" value="<?echo GetMessage("CT_BSP_GO")?>" type="submit"></td>
						</tr>
					</tbody></table>
				</div>
			<?else:?>
		</div><?//div class="search-advanced"?>
			<?endif;//if($arParams["SHOW_WHERE"] || $arParams["SHOW_WHEN"])?>
		</noindex>-->
	</form>

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>

	<div class="search-result">
	<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
	<?elseif($arResult["ERROR_CODE"]!=0):?>
		<div class="dont-seach">Пустой поисковый запрос (запрос не содержит букв или цифр).</div>
	<?elseif(count($arResult["SEARCH"])>0):?>
		<?if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<?foreach($arResult["SEARCH"] as $arItem):?>
		<? if ($arItem['PARAM2'] == 5 ){?>
		<? if (isset($arItem['ITEM_ID'])) {
        	 $res = CIBlockElement::GetProperty(5, $arItem['ITEM_ID'], array("sort" => "asc", ), Array("ID"=>"53"));
        	 while ($ob = $res->GetNext()) {
        		 $prop = $ob;
        		 if ($prop['VALUE_ENUM'] == "Да") {
                     $yesParID = $arItem['ITEM_ID'];
        	     };
             }
         }
        if ($arItem['ITEM_ID'] == $yesParID) { ?>
			<div class="search-item" id="search-item-vac">
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
				<?if(
					($arParams["SHOW_ITEM_DATE_CHANGE"] != "N")
					|| ($arParams["SHOW_ITEM_PATH"] == "Y" && $arItem["CHAIN_PATH"])
					|| ($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"]))
				):?>
				<div class="search-item-meta">
					<?if (
						$arParams["SHOW_RATING"] == "Y"
						&& $arItem["RATING_TYPE_ID"] <> ''
						&& $arItem["RATING_ENTITY_ID"] > 0
					):?>
					<div class="search-item-rate">
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:rating.vote", $arParams["RATING_TYPE"],
						Array(
							"ENTITY_TYPE_ID" => $arItem["RATING_TYPE_ID"],
							"ENTITY_ID" => $arItem["RATING_ENTITY_ID"],
							"OWNER_ID" => $arItem["USER_ID"],
							"USER_VOTE" => $arItem["RATING_USER_VOTE_VALUE"],
							"USER_HAS_VOTED" => $arItem["RATING_USER_VOTE_VALUE"] == 0? 'N': 'Y',
							"TOTAL_VOTES" => $arItem["RATING_TOTAL_VOTES"],
							"TOTAL_POSITIVE_VOTES" => $arItem["RATING_TOTAL_POSITIVE_VOTES"],
							"TOTAL_NEGATIVE_VOTES" => $arItem["RATING_TOTAL_NEGATIVE_VOTES"],
							"TOTAL_VALUE" => $arItem["RATING_TOTAL_VALUE"],
							"PATH_TO_USER_PROFILE" => $arParams["~PATH_TO_USER_PROFILE"],
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);?>
					</div>
					<?endif;?>
					<?if($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"])):?>
						<div class="search-item-tags"><label><?echo GetMessage("CT_BSP_ITEM_TAGS")?>: </label><?
						foreach ($arItem["TAGS"] as $tags):
							?><a href="<?=$tags["URL"]?>"><?=$tags["TAG_NAME"]?></a> <?
						endforeach;
						?></div>
					<?endif;?>

					<?if($arParams["SHOW_ITEM_DATE_CHANGE"] != "N"):?>
						<div class="search-item-date"><label><?echo GetMessage("CT_BSP_DATE_CHANGE")?>: </label><span><?echo $arItem["DATE_CHANGE"]?></span></div>
					<?endif;?>
				</div>
				<?endif?>
			</div>
			<?}?>
			<?} else if ($arItem['PARAM2'] == 6) {?>
			<? if (isset($arItem['ITEM_ID'])) {
                	 $res = CIBlockElement::GetProperty(6, $arItem['ITEM_ID'], array("sort" => "asc", ), Array("ID"=>"102"));
                	 while ($ob = $res->GetNext()) {
                		 $prop = $ob;
                		 if ($prop['VALUE_ENUM'] == "Да") {
                             $yesParIDR = $arItem['ITEM_ID'];
                	     };
                     }
                 }
                if ($arItem['ITEM_ID'] == $yesParIDR) { ?>
			    <div class="search-item" id="search-item-resume">
		         <?$GLOBALS['arrFilterR']=Array("ID" => $yesParIDR);?>
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
                		"FILTER_NAME" => "arrFilterR",
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
				<?if(
					($arParams["SHOW_ITEM_DATE_CHANGE"] != "N")
					|| ($arParams["SHOW_ITEM_PATH"] == "Y" && $arItem["CHAIN_PATH"])
					|| ($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"]))
				):?>
				<div class="search-item-meta">
					<?if (
						$arParams["SHOW_RATING"] == "Y"
						&& $arItem["RATING_TYPE_ID"] <> ''
						&& $arItem["RATING_ENTITY_ID"] > 0
					):?>
					<div class="search-item-rate">
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:rating.vote", $arParams["RATING_TYPE"],
						Array(
							"ENTITY_TYPE_ID" => $arItem["RATING_TYPE_ID"],
							"ENTITY_ID" => $arItem["RATING_ENTITY_ID"],
							"OWNER_ID" => $arItem["USER_ID"],
							"USER_VOTE" => $arItem["RATING_USER_VOTE_VALUE"],
							"USER_HAS_VOTED" => $arItem["RATING_USER_VOTE_VALUE"] == 0? 'N': 'Y',
							"TOTAL_VOTES" => $arItem["RATING_TOTAL_VOTES"],
							"TOTAL_POSITIVE_VOTES" => $arItem["RATING_TOTAL_POSITIVE_VOTES"],
							"TOTAL_NEGATIVE_VOTES" => $arItem["RATING_TOTAL_NEGATIVE_VOTES"],
							"TOTAL_VALUE" => $arItem["RATING_TOTAL_VALUE"],
							"PATH_TO_USER_PROFILE" => $arParams["~PATH_TO_USER_PROFILE"],
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);?>
					</div>
					<?endif;?>
					<?if($arParams["SHOW_ITEM_TAGS"] != "N" && !empty($arItem["TAGS"])):?>
						<div class="search-item-tags"><label><?echo GetMessage("CT_BSP_ITEM_TAGS")?>: </label><?
						foreach ($arItem["TAGS"] as $tags):
							?><a href="<?=$tags["URL"]?>"><?=$tags["TAG_NAME"]?></a> <?
						endforeach;
						?></div>
					<?endif;?>

					<?if($arParams["SHOW_ITEM_DATE_CHANGE"] != "N"):?>
						<div class="search-item-date"><label><?echo GetMessage("CT_BSP_DATE_CHANGE")?>: </label><span><?echo $arItem["DATE_CHANGE"]?></span></div>
					<?endif;?>
				</div>
				<?endif?>
			</div>
			<?}?>
			<?}?>
		<?endforeach;?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<?if($arParams["SHOW_ORDER_BY"] != "N"):?>
			<div class="search-sorting"><label><?echo GetMessage("CT_BSP_ORDER")?>:</label>&nbsp;
			<?if($arResult["REQUEST"]["HOW"]=="d"):?>
				<a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></a>&nbsp;<b><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></b>
			<?else:?>
				<b><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></b>&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></a>
			<?endif;?>
			</div>
		<?endif;?>
	<?else:?>
	<div class="dont-seach">По запросу «Слово, которое ввели для поиска» ничего не нашлось</div>
		<?//ShowNote(GetMessage("CT_BSP_NOTHING_TO_FOUND"));?>
		<script>
            let txtSeach = document.querySelector('.search-suggest').value;
            document.querySelector('.dont-seach').innerHTML = "По запросу «"+ txtSeach +"» ничего не нашлось"
        </script>
	<?endif;?>

	</div>
</div>

<script>
let txtSeachNew = document.querySelector('.search-suggest').value;
document.querySelector('.page-left-top-up h1').innerHTML = "Результаты поиска по «"+ txtSeachNew +"»"
</script>


<?if (!$USER->IsAuthorized()) {?>
    <style>
        #search-page-seach .search-suggest::placeholder {
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