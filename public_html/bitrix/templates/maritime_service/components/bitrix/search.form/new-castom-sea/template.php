<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);?>
<div class="search-form">
<form action="<?=$arResult["FORM_ACTION"]?>">
	<table class="se-main" border="0" cellspacing="0" cellpadding="2" align="center">
		<tr class="se-main-in">
			<td align="center"><?if($arParams["USE_SUGGEST"] === "Y"):?><?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => "",
					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
				),
				$component, array("HIDE_ICONS" => "Y")
			);?><?else:?><input type="text" name="q" value="" size="15" maxlength="50" /><?endif;?></td>
		</tr>
		<tr class="se-main-bu">
			<td  align="right"><input name="s" type="submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" /></td>
		</tr>
	</table>
</form>
</div>

<script>
    document.querySelector(".se-main-in input").placeholder = "Введите ключевое слово"
</script>

<style>
.se-main tbody {
    display: flex;
}
.se-main-in {
    margin-top: 0;
    width: 100%;
}
.se-main {
    margin: 0;
    width: 100%;
}
.se-main-in input[type="text"]:hover {
    border: 1px solid #035AA6;
}
.se-main-in input[type="text"]:focus {
    border: 1px solid #035AA6;
}
.se-main-in input[type="text"]:focus{
    background-color: ;
    outline: none;
    border: 1px solid #035AA6;
    input: focus,;
}
.se-main-bu {
    margin-top: 0;
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
}
.se-main-in input[type="text"] {
    position: relative;
    border: 1px solid #fff;
    border-radius: 14px;
    z-index: 10;
    background: url(/bitrix/templates/maritime_service/images/svg/magnifier.svg) 1.9% 50% no-repeat;
    background-color: #fff;
    box-shadow: none;
    font-family: Montserrat;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    letter-spacing: 0.32px;
    height: 47px;
    flex-shrink: 0;
    padding: 0px 0px 0px 63px;
    word-break: break-word;
    cursor: pointer;
    width: 1109px;
}
.apply_job_seach {
    margin-top: 47px;
}
.se-main-bu input[type="submit"] {
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
    min-width: 174px;
    min-height: 49px;
    font-weight: 600;
    line-height: normal;
    background: #035AA6;
    border: 0px solid #035AA6;
    position: relative;
    left: -12px;
    z-index: 1;
    cursor: pointer;
    color: #FFF;
    font-family: Montserrat;
    font-size: 14px;
    font-style: normal;
    letter-spacing: 0.28px;
}
</style>