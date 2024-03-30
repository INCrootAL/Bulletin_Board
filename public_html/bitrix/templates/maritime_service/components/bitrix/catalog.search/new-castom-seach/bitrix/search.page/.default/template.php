<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}
/** @global CMain $APPLICATION */
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponent $component */
?>
<div class="search-page">
	<form action="" method="get">
		<? if($arParams["USE_SUGGEST"] === "Y"):
			if(mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"]))
			{
				$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
				$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
				$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
			}
			?>
			<?$APPLICATION->IncludeComponent("bitrix:search.suggest.input", "", array(
					"NAME" => "q",
					"VALUE" => $arResult["REQUEST"]["~QUERY"],
					"INPUT_SIZE" => 40,
					"DROPDOWN_SIZE" => 10,
					"FILTER_MD5" => $arResult["FILTER_MD5"],
				),
				$component, array("HIDE_ICONS" => "Y")
			);?>
			<input class="btn btn-primary" type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
		<?else:?>
		
		<style>
                        ::placeholder {
                            margin-left:40px;
                            color: #989898;
                            font-family: Montserrat;
                            font-size: 14px;
                            font-style: normal;
                            font-weight: 400;
                            line-height: normal;
                            letter-spacing: 0.28px;
                        }
                        
                        ::-ms-input-placeholder { /* Edge 12-18 */
                            margin-left:40px;
                            color: #989898;
                            font-family: Montserrat;
                            font-size: 14px;
                            font-style: normal;
                            font-weight: 400;
                            line-height: normal;
                            letter-spacing: 0.28px;
                        }
                    </style>
		
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Введите ключевое слово" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
				<div class="input-group-append">
					<input class="btn btn-primary" type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
				</div>
			</div>
		<?endif;?>
		<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
		<? if($arParams["SHOW_WHEN"]):?>
	<script>
	var switch_search_params = function()
	{
		var sp = document.getElementById('search_params');
		var flag;

		if(sp.style.display == 'none')
		{
			flag = false;
			sp.style.display = 'block'
		}
		else
		{
			flag = true;
			sp.style.display = 'none';
		}

		var from = document.getElementsByName('from');
		for(var i = 0; i < from.length; i++)
			if(from[i].type.toLowerCase() == 'text')
				from[i].disabled = flag

		var to = document.getElementsByName('to');
		for(var i = 0; i < to.length; i++)
			if(to[i].type.toLowerCase() == 'text')
				to[i].disabled = flag

		return false;
	}
	</script>
	<br /><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a>
	<div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
		<?$APPLICATION->IncludeComponent(
			'bitrix:main.calendar',
			'',
			array(
				'SHOW_INPUT' => 'Y',
				'INPUT_NAME' => 'from',
				'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
				'INPUT_NAME_FINISH' => 'to',
				'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
				'INPUT_ADDITIONAL_ATTR' => 'size="10"',
			),
			null,
			array('HIDE_ICONS' => 'Y')
		);?>
	</div>
<?endif?>
</form><br />

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess" style="width: 520px;height: 17px;background: #ECECEC;font-family: Montserrat;font-size: 14px;font-style: normal;font-weight: 600;line-height: normal;letter-spacing: 0.28px;padding: 30px 68px 28px 105px;background: url(/bitrix/templates/maritime_service/images/svg/info_red.svg) 9.4% 50% no-repeat #ECECEC;">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>
</div>

<script>
$(document).ready(function() {
    let block_section_search = document.querySelectorAll(".catalog-section.bx-blue");
    let filterDel = document.querySelector(".bx-filter.bx-blue");
    let buttonsDel = document.querySelector(".row.bx-blue");
    let meaningVal = document.querySelector(".input-group input");
    if (block_section_search.length > 1) {
        for (var i = 0, max = 2; i < max; i++) {
            if (block_section_search[i].dataset.entity != "container-OQ3k9P") {
                //alert(meaningVal.value)
                if(block_section_search[i].style.display != "none"){
                    block_section_search[i].style = "display:none";
                    filterDel.style = "display:none";
                    buttonsDel.style = "display:none";
                }
            }
        }
    } else if (block_section_search.length == 1 && meaningVal.value == ""){
       for (var i = 0, max = 1; i < max; i++) {
            if (block_section_search[i].dataset.entity != "container-OQ3k9P") {
                if(block_section_search[i].style.display == "none"){
                    block_section_search[i].style = "display:block";
                    filterDel.style = "display:block";
                    buttonsDel.style = "display:block";
                }
            }
        } 
    } else if (block_section_search.length == 1 && meaningVal.value != "") {
        for (var i = 0, max = 1; i < max; i++) {
            if (block_section_search[i].dataset.entity != "container-OQ3k9P") {
                if(block_section_search[i].style.display != "none"){
                    block_section_search[i].style = "display:none";
                    filterDel.style = "display:none";
                    buttonsDel.style = "display:none";
                }
            }
        } 
    }
})
</script>