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

use Bitrix\Iblock\SectionPropertyTable;

$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
?>
<div class="bx-filter <?=$templateData["TEMPLATE_CLASS"]?> <?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL") echo "bx-filter-horizontal"?>">
	<div class="bx-filter-section container-fluid">
		<div class="row"><div class="<?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"):?>col-sm-6 col-md-4<?else:?>col-lg-12<?endif?> bx-filter-title"><?//echo GetMessage("CT_BCSF_FILTER_TITLE")?></div></div>
		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
			<?endforeach;?>
			<div class="row">
				<?foreach($arResult["ITEMS"] as $key=>$arItem)//prices
				{
					$key = $arItem["ENCODED_ID"];
					if(isset($arItem["PRICE"])):
						if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
							continue;

						$precision = 0;
						$step_num = 4;
						$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
						$prices = array();
						if (Bitrix\Main\Loader::includeModule("currency"))
						{
							for ($i = 0; $i < $step_num; $i++)
							{
								$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
							}
							$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
						}
						else
						{
							$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
							for ($i = 0; $i < $step_num; $i++)
							{
								$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
							}
							$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
						}
						?>
						<div class="<?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"):?>col-sm-6 col-md-4<?else:?>col-lg-12<?endif?> bx-filter-parameters-box bx-active" <?if($key == 51):?>style="display:none"<?endif?>>
							<span class="bx-filter-container-modef"></span>
							<div class="bx-filter-parameters-box-title" id="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)"><span><?=$arItem["NAME"]?> <i data-role="prop_angle" class="fa fa-angle-<?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>up<?else:?>down<?endif?>"></i></span></div>
							<div class="bx-filter-block" data-role="bx_filter_block">
								<div class="row bx-filter-parameters-box-container">
									<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
										<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
										<div class="bx-filter-input-container">
											<input
												class="min-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
											/>
										</div>
									</div>
									<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
										<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
										<div class="bx-filter-input-container">
											<input
												class="max-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
											/>
										</div>
									</div>

									<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
										<div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
											<?for($i = 0; $i <= $step_num; $i++):?>
											<div class="bx-ui-slider-part p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
											<?endfor;?>

											<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
											<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
											<div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
											<div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
												<a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
												<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?
						$arJsParams = array(
							"leftSlider" => 'left_slider_'.$key,
							"rightSlider" => 'right_slider_'.$key,
							"tracker" => "drag_tracker_".$key,
							"trackerWrap" => "drag_track_".$key,
							"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
							"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
							"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
							"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
							"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
							"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
							"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
							"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
							"precision" => $precision,
							"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
							"colorAvailableActive" => 'colorAvailableActive_'.$key,
							"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
						);
						?>
						<script type="text/javascript">
							BX.ready(function(){
								window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
							});
						</script>
					<?endif;
				}

				//not prices
				foreach($arResult["ITEMS"] as $key=>$arItem)
				{
					if(
						empty($arItem["VALUES"])
						|| isset($arItem["PRICE"])
					)
						continue;

					if (
						$arItem["DISPLAY_TYPE"] === SectionPropertyTable::NUMBERS_WITH_SLIDER
						&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
					)
						continue;
					?>
					<div class="<?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"):?>col-sm-6 col-md-4<?else:?>col-lg-12<?endif?> bx-filter-parameters-box <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>bx-active<?endif?>"<?if($key == 51):?>style="display:none"<?endif?>>
						<span class="bx-filter-container-modef"></span>
						<div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
							<span class="bx-filter-parameters-box-hint <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>bx-active<?else:?><?endif?>"data-role='prop_name_filter'><?=$arItem["NAME"]?>
								<?if ($arItem["FILTER_HINT"] <> ""):?>
									<i id="item_title_hint_<?echo $arItem["ID"]?>" class="fa fa-question-circle"></i>
									<script type="text/javascript">
										new top.BX.CHint({
											parent: top.BX("item_title_hint_<?echo $arItem["ID"]?>"),
											show_timeout: 10,
											hide_timeout: 200,
											dx: 2,
											preventHide: true,
											min_width: 250,
											hint: '<?= CUtil::JSEscape($arItem["FILTER_HINT"])?>'
										});
									</script>
								<?endif?>
								<i data-role="prop_angle" class="fat fa-angle-<?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>up<?else:?>down<?endif?>"></i>
							</span>
						</div>

						<div <?if( $key == 16 || $key == 66 || $key == 67 || $key == 68 || $key == 65){?> id="bx-filter-block_<?=$key?>" <?}?> class="bx-filter-block" data-role="bx_filter_block">
						  <?if($key == "66"){?>
						    <input type="text" id="visual_" value="" class="bx-filter-block-seach" placeholder="Поиск">
						    <div class="result" id="result"></div>
						    <?}?>
							<div class="row bx-filter-parameters-box-container">
							<?
							$arCur = current($arItem["VALUES"]);
							switch ($arItem["DISPLAY_TYPE"])
							{
								case SectionPropertyTable::NUMBERS_WITH_SLIDER://NUMBERS_WITH_SLIDER
									?>
									<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
										<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
										<div class="bx-filter-input-container">
											<input
												class="min-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
											/>
										</div>
									</div>
									<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
										<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
										<div class="bx-filter-input-container">
											<input
												class="max-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
											/>
										</div>
									</div>

									<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
										<div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
											<?
											$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
											$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
											$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
											$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
											$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
											$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
											$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
											?>
											<div class="bx-ui-slider-part p1"><span><?=$value1?></span></div>
											<div class="bx-ui-slider-part p2"><span><?=$value2?></span></div>
											<div class="bx-ui-slider-part p3"><span><?=$value3?></span></div>
											<div class="bx-ui-slider-part p4"><span><?=$value4?></span></div>
											<div class="bx-ui-slider-part p5"><span><?=$value5?></span></div>

											<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
											<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
											<div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
											<div class="bx-ui-slider-range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
												<a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
												<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
											</div>
										</div>
									</div>
									<?
									$arJsParams = array(
										"leftSlider" => 'left_slider_'.$key,
										"rightSlider" => 'right_slider_'.$key,
										"tracker" => "drag_tracker_".$key,
										"trackerWrap" => "drag_track_".$key,
										"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
										"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
										"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
										"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
										"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
										"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
										"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
										"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
										"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
										"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
										"colorAvailableActive" => 'colorAvailableActive_'.$key,
										"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
									);
									?>
									<script type="text/javascript">
										BX.ready(function(){
											window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
										});
									</script>
									<?
									break;
								case SectionPropertyTable::NUMBERS://NUMBERS
									?>
									<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
										<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
										<div class="bx-filter-input-container">
											<input
											<?//this?>
												class="min-price"
												type="text"
												<?if( $key === 16){?> placeholder="от" onkeypress="valid_for_number_fillter()" maxlength="10"<?}?>
												name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												/>
										</div>
									</div>
									<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
										<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
										<div class="bx-filter-input-container">
											<input
												class="max-price"
												type="text"
												<?if( $key === 16){?> placeholder="до" onkeypress="valid_for_number_fillter()" maxlength="10"<?}?>
												name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												/>
										</div>
									</div>
									<?if($key === 16){?>
									<div class="row bx-filter-parameters-box-container-dop-val">
									<div class="col-xs-12-dop-val">
										<div class="bx-filter-select-container-dop-val">
											<div class="bx-filter-select-block-dop-val" >
												<div class="bx-filter-select-text-dop-val" id="bx-filter-select-text-dop-val">Все</div>
												<div class="bx-filter-select-arrow-dop-val"></div>
													<div class="bx-filter-select-popup-dop-val" id="bx-filter-select-popup-dop-val" style="display: none;">
												</div>
											</div>
										</div>
									</div>
								</div>
									<?}?>
									<?
									break;
								case SectionPropertyTable::CHECKBOXES_WITH_PICTURES://CHECKBOXES_WITH_PICTURES
									?>
									<div class="col-xs-12">
										<div class="bx-filter-param-btn-inline">
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
											<input
												style="display: none"
												type="checkbox"
												name="<?=$ar["CONTROL_NAME"]?>"
												id="<?=$ar["CONTROL_ID"]?>"
												value="<?=$ar["HTML_VALUE"]?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
											/>
											<?
											$class = "";
											if ($ar["CHECKED"])
												$class.= " bx-active";
											if ($ar["DISABLED"])
												$class.= " disabled";
											?>
											<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label <?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
												<span class="bx-filter-param-btn bx-color-sl">
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
													<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
													<?endif?>
												</span>
											</label>
										<?endforeach?>
										</div>
									</div>
									<?
									break;
								case SectionPropertyTable::CHECKBOXES_WITH_PICTURES_AND_LABELS://CHECKBOXES_WITH_PICTURES_AND_LABELS
									?>
									<div class="col-xs-12">
										<div class="bx-filter-param-btn-block">
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
											<input
												style="display: none"
												type="checkbox"
												name="<?=$ar["CONTROL_NAME"]?>"
												id="<?=$ar["CONTROL_ID"]?>"
												value="<?=$ar["HTML_VALUE"]?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
											/>
											<?
											$class = "";
											if ($ar["CHECKED"])
												$class.= " bx-active";
											if ($ar["DISABLED"])
												$class.= " disabled";
											?>
											<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
												<span class="bx-filter-param-btn bx-color-sl">
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
														<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
													<?endif?>
												</span>
												<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
												if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
													?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
												endif;?></span>
											</label>
										<?endforeach?>
										</div>
									</div>
									<?
									break;
								case SectionPropertyTable::DROPDOWN://DROPDOWN
									$checkedItemExist = false;
									?>
									<div class="col-xs-12">
										<div class="bx-filter-select-container">
											<div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
												<div class="bx-filter-select-text" data-role="currentOption">
													<?
													foreach ($arItem["VALUES"] as $val => $ar)
													{
														if ($ar["CHECKED"])
														{
															echo $ar["VALUE"];
															$checkedItemExist = true;
														}
													}
													if (!$checkedItemExist)
													{
														echo GetMessage("CT_BCSF_FILTER_ALL");
													}
													?>
												</div>
												<div class="bx-filter-select-arrow"></div>
												<input
													style="display: none"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
													value=""
												/>
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
													<input
														style="display: none"
														type="radio"
														name="<?=$ar["CONTROL_NAME_ALT"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<? echo $ar["HTML_VALUE_ALT"] ?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													/>
												<?endforeach?>
												<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none;">
													<ul>
														<li>
															<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
															</label>
														</li>
													<?
													foreach ($arItem["VALUES"] as $val => $ar):
														$class = "";
														if ($ar["CHECKED"])
															$class.= " selected";
														if ($ar["DISABLED"])
															$class.= " disabled";
													?>
														<li>
															<label for="<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')"><?=$ar["VALUE"]?></label>
														</li>
													<?endforeach?>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<?
									break;
								case SectionPropertyTable::DROPDOWN_WITH_PICTURES_AND_LABELS://DROPDOWN_WITH_PICTURES_AND_LABELS
									?>
									<div class="col-xs-12">
										<div class="bx-filter-select-container">
											<div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
												<div class="bx-filter-select-text fix" data-role="currentOption">
													<?
													$checkedItemExist = false;
													foreach ($arItem["VALUES"] as $val => $ar):
														if ($ar["CHECKED"])
														{
														?>
															<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
															<?endif?>
															<span class="bx-filter-param-text">
																<?=$ar["VALUE"]?>
															</span>
														<?
															$checkedItemExist = true;
														}
													endforeach;
													if (!$checkedItemExist)
													{
														?><span class="bx-filter-btn-color-icon all"></span> <?
														echo GetMessage("CT_BCSF_FILTER_ALL");
													}
													?>
												</div>
												<div class="bx-filter-select-arrow"></div>
												<input
													style="display: none"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
													value=""
												/>
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
													<input
														style="display: none"
														type="radio"
														name="<?=$ar["CONTROL_NAME_ALT"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<?=$ar["HTML_VALUE_ALT"]?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													/>
												<?endforeach?>
												<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none">
													<ul>
														<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
															<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																<span class="bx-filter-btn-color-icon all"></span>
																<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
															</label>
														</li>
													<?
													foreach ($arItem["VALUES"] as $val => $ar):
														$class = "";
														if ($ar["CHECKED"])
															$class.= " selected";
														if ($ar["DISABLED"])
															$class.= " disabled";
													?>
														<li>
															<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
																<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																	<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																<?endif?>
																<span class="bx-filter-param-text">
																	<?=$ar["VALUE"]?>
																</span>
															</label>
														</li>
													<?endforeach?>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<?
									break;
								case SectionPropertyTable::RADIO_BUTTONS://RADIO_BUTTONS
									?>
									<div class="col-xs-12">
										<div class="radio">
											<label class="bx-filter-param-label" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
												<span class="bx-filter-input-checkbox">
													<input
														type="radio"
														value=""
														name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
														id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
														onclick="smartFilter.click(this)"
													/>
													<span class="bx-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
												</span>
											</label>
										</div>
										<?foreach($arItem["VALUES"] as $val => $ar):?>
											<div class="radio">
												<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label" for="<? echo $ar["CONTROL_ID"] ?>">
													<span class="bx-filter-input-checkbox <? echo $ar["DISABLED"] ? 'disabled': '' ?>">
														<input
															type="radio"
															value="<? echo $ar["HTML_VALUE_ALT"] ?>"
															name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
															id="<? echo $ar["CONTROL_ID"] ?>"
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															onclick="smartFilter.click(this)"
														/>
														<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
															?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
														endif;?></span>
													</span>
												</label>
											</div>
										<?endforeach;?>
									</div>
									<?
									break;
								case SectionPropertyTable::CALENDAR://CALENDAR
									?>
									<div class="col-xs-12">
										<div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
											<?$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
													'SHOW_INPUT' => 'Y',
													'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
													'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
													'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
													'SHOW_TIME' => 'N',
													'HIDE_TIMEBAR' => 'Y',
												),
												null,
												array('HIDE_ICONS' => 'Y')
											);?>
										</div></div>
										<div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
											<?$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
													'SHOW_INPUT' => 'Y',
													'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
													'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
													'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
													'SHOW_TIME' => 'N',
													'HIDE_TIMEBAR' => 'Y',
												),
												null,
												array('HIDE_ICONS' => 'Y')
											);?>
										</div></div>
									</div>
									<?
									break;
								default://CHECKBOXES
									?>
									<div class="col-xs-12">
										<?foreach($arItem["VALUES"] as $val => $ar):?>
											<div class="checkbox">
												<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
													<span class="bx-filter-input-checkbox">
														<input
															type="checkbox"
															value="<? echo $ar["HTML_VALUE"] ?>"
															name="<? echo $ar["CONTROL_NAME"] ?>"
															id="<? echo $ar["CONTROL_ID"] ?>"
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															onclick="smartFilter.click(this)"
														/>
														<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
															?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
														endif;?></span>
													</span>
												</label>
											</div>
										<?endforeach;?>
									</div>
							<?
							}
							?>
							</div>
							<div style="clear: both"></div>
						</div>
					</div>
				<?
				}
				?>
			</div><!--//row style="display:none"-->
			<div class="row" >
				<div class="col-xs-12 bx-filter-button-box">
					<div class="bx-filter-block" style="box-shadow: none; background: none;padding: 0;float: right;">
						<div class="bx-filter-parameters-box-container">
							<!--<input
								class="btn btn-themes"
								type="submit"
								id="set_filter"
								name="set_filter"
								value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
							/> -->
							<input
								class="btn btn-link"
								type="submit"
								id="del_filter"
								name="del_filter"
								value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
							/>
							
							<div class="bx-filter-popup-result <?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
								<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.(int)($arResult["ELEMENT_COUNT"] ?? 0).'</span>'));?>
								<span class="arrow"></span>
								<br/>
								<a href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
							</div> 
							
						</div>
					</div>
				</div>
			</div>
			<div class="clb"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
<script>
//seach for block resume
    document.getElementById('visual_').onkeyup = function () {
        let val = this.value.trim();
        let elasticItems = document.querySelectorAll('#bx-filter-block_66 .bx-filter-input-checkbox');
        if (val != '') {
            elasticItems.forEach(function (elem) {
                if (elem.innerText.search((RegExp(val,"gi"))) == -1) {
                    elem.classList.add('hide');
                }
                else {
                    elem.classList.remove('hide');
                }
            });
        } else {
              elasticItems.forEach(function (elem) {
                    elem.classList.remove('hide');
                
              });
        }
    }
</script>
<script>
//++examination filter
    var allInputsCheck = document.getElementsByTagName("input");
    for (let i = 0, max = allInputsCheck.length; i < max; i++){
        if (allInputsCheck[i].type === 'checkbox') {
            if(allInputsCheck[i].checked === true) {
                allInputsCheck[i].classList.add('active');
            }
        }    
    };
    
    let allInputsCheckInfoFilter = $('.bx-filter-input-checkbox input');
    let allInputsCheckSpan = $('.bx-filter-input-checkbox span');
    let selectTopList = $('.bx-filter-section.container-fluid');
    let delselectTopListSeach = document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list');
    
    for (let itt = 0, max = allInputsCheckInfoFilter.length; itt < max; itt++) {
        if (allInputsCheckInfoFilter[itt].checked === true) {
            let fillter_by_list = $('<ul>', {
                class: 'bx-filter-by-list'
            });
            let li = $('<li>', {
                html: '<span title='+ allInputsCheckInfoFilter[itt].name +'>' + allInputsCheckSpan[itt].textContent + '</span>' + '<div class="close_fill_all"><svg name="' + allInputsCheckInfoFilter[itt].name + '" xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 12 11" fill="none">'
+ '<path d="M10.9999 10.4999L6 5.5M6 5.5L1 0.5M6 5.5L11 0.5M6 5.5L1 10.5"' + 'stroke="#989898"' + 'stroke-linecap="round"' + 'stroke-linejoin="round"/></svg></div>'
            });
            selectTopList.append(fillter_by_list);
            fillter_by_list.append(li);
        }
    }
    /*
    if (document.getElementById("arrFilter_16_MIN").value != "" || document.getElementById("arrFilter_16_MAX").value != ""){
        if (Number(document.getElementById("arrFilter_16_MIN").value) <= Number(document.getElementById("arrFilter_16_MAX").value)) {
            let selectTopList = $('.bx-filter-section.container-fluid');
            let sumPriceFilter = Number(document.getElementById("arrFilter_16_MIN").value) + Number(document.getElementById("arrFilter_16_MAX").value);
            let fillter_by_list = $('<ul>', {
                class: 'bx-filter-by-list-solid'
            });
            let lit = $('<li>', {
            html: '<span title='+ sumPriceFilter +'>от: ' + document.getElementById("arrFilter_16_MIN").value + '  до: ' + document.getElementById("arrFilter_16_MAX").value + '  Валюта: '+ document.getElementById("bx-filter-select-text-dop-val").textContent + '<i class="close_fill"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 12 11" fill="none">'
    + '<path d="M10.9999 10.4999L6 5.5M6 5.5L1 0.5M6 5.5L11 0.5M6 5.5L1 10.5"' + 'stroke="#989898"' + 'stroke-linecap="round"' + 'stroke-linejoin="round"/></svg></i> </span>'
            });
            selectTopList.append(fillter_by_list);
            fillter_by_list.append(lit);
        } else {
            let selectTopList = $('.bx-filter-section.container-fluid');
            document.getElementById("arrFilter_16_MAX").value = document.getElementById("arrFilter_16_MIN").value;
            let sumPriceFilter = Number(document.getElementById("arrFilter_16_MIN").value) + Number(document.getElementById("arrFilter_16_MAX").value);
            let fillter_by_list = $('<ul>', {
                class: 'bx-filter-by-list-solid'
            });
            let lit = $('<li>', {
            html: '<span title='+ sumPriceFilter +'>от: ' + document.getElementById("arrFilter_16_MIN").value + '  до: ' + document.getElementById("arrFilter_16_MAX").value + '  Валюта: '+ document.getElementById("bx-filter-select-text-dop-val").textContent + '<i class="close_fill"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 12 11" fill="none">'
    + '<path d="M10.9999 10.4999L6 5.5M6 5.5L1 0.5M6 5.5L11 0.5M6 5.5L1 10.5"' + 'stroke="#989898"' + 'stroke-linecap="round"' + 'stroke-linejoin="round"/></svg></i> </span>'
            });
            selectTopList.append(fillter_by_list);
            fillter_by_list.append(lit);    
        }
    }
    */
//--end examination filter
    
    function valid_for_number_fillter(){
        /*
        $(document).ready(function() {
            var minPriceFillter = $('.min-price');
            var maxPriceFillter = $('.max-price');
            if (minPriceFillter.val() > maxPriceFillter.val()){
                if(event.keyCode)
                //maxPriceFillter.val() = minPriceFillter.val()
                //alert("Ошибка!");
            }
                //alert(minPriceFillter.val());
    });
    */
        
        if (event.keyCode != 43 && event.keyCode < 48 || event.keyCode > 57){
            event.preventDefault();
        }
    };
    
    
    document.addEventListener("click", function(e) {
        $(document).ready(function() {
            var valy = document.getElementById("bx-filter-select-popup-dop-val")
            var topvay = document.getElementById("bx-filter-select-text-dop-val")
            
            if (event.target.className === "bx-filter-select-text-dop-val" || event.target.className === "fat dop" ){
                topvay.classList.add("active");
                valy.classList.add("active");
            } else if(event.target.className === "bx-filter-select-text-dop-val active" || event.target.className === "fat dop active"){
                topvay.classList.remove("active");
                valy.classList.remove("active");
            }
            /*
            var select = $('.bx-filter-select-popup ul li label');
            var selectForNew = $('.bx-filter-select-popup-dop-val');
            
            var dropDown = $('<ul>', {
                    className: 'bx-filter-select-popup-list'
                });
        
            select.each(function(i) {
                selectForNew.append(dropDown);
                var li = $('<li>', {
                    html: select[i] 
                });
            
                li.click(function() {
                    
                    $('#bx-filter-select-text-dop-val').html(li.text());
                    for (const lit of document.querySelectorAll('li')) {
                        if (lit.matches('.active')) {
                            lit.classList.remove('active')
                        }
                    }
                    
                    li.addClass('active')
                    topvay.classList.remove("active");
                    valy.classList.remove("active");
                    var nameTXT = $('#bx-filter-select-text-dop-val').innerHTML;
                    
                    return false;
                });
            dropDown.append(li);
            });
            */
        });
    });
    
    document.addEventListener("click", function(e) {
        $(document).ready(function() {
            var allInputsCheck = $('.bx-filter-input-checkbox input');
            var allInputsCheckSpan = $('.bx-filter-input-checkbox span');
            var selectTopList = $('.bx-filter-section.container-fluid');
            var selectTopListSeach = document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list li span');
            let delselectTopListSeach = document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list');
            
            let arrFillter = new Array;
            
            for (var it = 0, max = selectTopListSeach.length; it < max; it++) {
                arrFillter.push(selectTopListSeach[it].textContent);   
            }
                
            for (var i = 0, max = allInputsCheck.length; i < max; i++) {
                if (event.target.className == "active" || event.target.className == "bx-filter-param-text" && event.target.type == 'checkbox') {
                    if (allInputsCheck[i].checked == true) {
                        if(arrFillter.every(element => element !== allInputsCheckSpan[i].textContent)){
                            let fillter_by_list = $('<ul>', {
                                className: 'bx-filter-by-list'
                            });
                            let li = $('<li>', {
                                html: '<span title='+ allInputsCheck[i].name +'>' + allInputsCheckSpan[i].textContent + '</span>' + '<div class="close_fill_all"><svg name="' + allInputsCheck[i].name + '" xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 12 11" fill="none">'
+ '<path d="M10.9999 10.4999L6 5.5M6 5.5L1 0.5M6 5.5L11 0.5M6 5.5L1 10.5"' + 'stroke="#989898"' + 'stroke-linecap="round"' + 'stroke-linejoin="round"/></svg></div>'
                            });
                            selectTopList.append(fillter_by_list);
                            fillter_by_list.append(li);
                        } else {
                            //seachFFillterList();  
                        }
                    } 
                }
                if (event.target.className == "" || event.target.className == "bx-filter-param-text" && event.target.type == 'checkbox') {
                    if (allInputsCheck[i].checked == false) {
                        for (var it2 = 0, max = selectTopListSeach.length; it2 < max; it2++) {
                            if (selectTopListSeach[it2].textContent == allInputsCheckSpan[i].textContent) {
                                delselectTopListSeach[it2].remove();
                            } else {
                                for (var itr = 0, max = selectTopListSeach.length; itr < max; itr++) {
                                    if(event.target.name == selectTopListSeach[itr].title){
                                        delselectTopListSeach[itr].remove();
                                    }
                                }
                            }
                        }    
                    }
                }
            }
            
            if (event.target.matches('.bx-filter-by-list svg')) {
                let allInputsCheck = $('.bx-filter-input-checkbox input');
                let allInputsCheck1 = $('.bx-filter-input-checkbox input');
                let allInputsCheckSpan = $('.bx-filter-input-checkbox span');
                let selectTopListSeach = document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list li span');
                let delselectTopListSeach = document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list');
                let detectionClose = document.querySelectorAll('.close_fill_all')
                
                if(delselectTopListSeach.length != 1) {
                    for( let i = 0; i < delselectTopListSeach.length; i++ ) {
                        if(event.target.getAttribute('name') == selectTopListSeach[i].title) {
                            for (var it = 0, max = allInputsCheck.length; it < max; it++) {
                                if (allInputsCheck[it].checked == true && event.target.getAttribute('name') == allInputsCheck[it].getAttribute("name")) {
                                        allInputsCheck[it].checked = false;
                                        allInputsCheck[it].classList.remove("active");
                                        smartFilter.click(allInputsCheck[it]);
                                    }
                            }
                            delselectTopListSeach[i].remove();
                        }
                    } 
                } else {
                    for( let i = 0; i < delselectTopListSeach.length; i++ ){
                        delselectTopListSeach[i].remove();
                    }
                    for (var it = 0, max = allInputsCheck.length; it < max; it++) {
                        if (allInputsCheck[it].checked == true && event.target.getAttribute('name') == allInputsCheck[it].getAttribute("name")) {
                            smartFilter.click(allInputsCheck[it])
                            allInputsCheck[it].checked = false;
                            allInputsCheck[it].classList.remove("active");
                            //allInputsCheck[it].smartFilter.click(this)
                        }
                    }
                }
            }
        })    
    })
    
    /*
    $(document).ready(function() {
        document.addEventListener("click", function(e) {
            if (event.target.matches('.min-price')) {
                var ver_input_sol = '.min-price'
                repeat_focus(ver_input_sol);
            }
            if (event.target.matches('.max-price')) {
                var ver_input_sol = '.max-price'
                repeat_focus(ver_input_sol);
            }
            if (event.target.matches('.bx-filter-by-list-solid svg')){
                for( let i = 0; i < document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list-solid').length; i++ ) {
                    document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list-solid')[i].outerHTML = "";
                }
                document.getElementById("arrFilter_16_MIN").value = "";
                document.getElementById("arrFilter_16_MAX").value = "";
            }
        })
    })
    
    function repeat_focus(ver_input_sol) {
        $(ver_input_sol).focusout(function(){
            let selectTopListSeach = document.querySelectorAll('.bx-filter-section.container-fluid .bx-filter-by-list-solid');
            let maxPriceFillter = document.getElementById("arrFilter_16_MAX")
            let minPriceFillter = document.getElementById("arrFilter_16_MIN")
            let valForFillter = document.getElementById("bx-filter-select-text-dop-val")
            let selectTopList = $('.bx-filter-section.container-fluid');
            let sumPriceFilter = Number(maxPriceFillter.value) + Number(minPriceFillter.value);
            let fillter_by_list = $('<ul>', {
                    className: 'bx-filter-by-list-solid'
                });

            if (selectTopListSeach.length != 0) {
                if(sumPriceFilter != ""){
                    for( let i = 0; i < selectTopListSeach.length; i++ ){
                      selectTopListSeach[i].outerHTML = "";
                    }
                    if (Number(minPriceFillter.value) > Number(maxPriceFillter.value) && maxPriceFillter.value != ""){
                        maxPriceFillter.value = minPriceFillter.value
                    }
                    let lit = $('<li>', {
                        html: '<span title='+ sumPriceFilter +'>от: ' + minPriceFillter.value + '  до: ' + maxPriceFillter.value + '  Валюта: '+ valForFillter.textContent + '<i class="close_fill"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 12 11" fill="none">'
+ '<path d="M10.9999 10.4999L6 5.5M6 5.5L1 0.5M6 5.5L11 0.5M6 5.5L1 10.5"' + 'stroke="#989898"' + 'stroke-linecap="round"' + 'stroke-linejoin="round"/></svg></i> </span>'
                    });
                    selectTopList.append(fillter_by_list);
                    fillter_by_list.append(lit);
                } else {
                    for( let i = 0; i < selectTopListSeach.length; i++ ){
                      selectTopListSeach[i].outerHTML = "";
                    }
                }
                
            } else {
                if (sumPriceFilter != "" ) {
                    if (Number(minPriceFillter.value) > Number(maxPriceFillter.value) && maxPriceFillter.value != ""){
                        maxPriceFillter.value = minPriceFillter.value
                    }
                    let lit = $('<li>', {
                        html: '<span title='+ sumPriceFilter +'>от: ' + minPriceFillter.value + '  до: ' + maxPriceFillter.value + '  Валюта: '+ valForFillter.textContent + '<i class="close_fill"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 12 11" fill="none">'
+ '<path d="M10.9999 10.4999L6 5.5M6 5.5L1 0.5M6 5.5L11 0.5M6 5.5L1 10.5"' + 'stroke="#989898"' + 'stroke-linecap="round"' + 'stroke-linejoin="round"/></svg></i> </span>'
                    });
                    selectTopList.append(fillter_by_list);
                    fillter_by_list.append(lit);
                }
            }
        })
    }
    */
</script>