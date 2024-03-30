<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?
//echo "<pre>Template arParams: "; print_r($arParams); echo "</pre>";
//echo "<pre>Template arResult: "; print_r($arResult); echo "</pre>";
//exit();
use Bitrix\Main\Page\Asset; 
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style.css'); 
?>
<?$byNew = $USER->GetID()?>

<?if (!empty($arResult["ERRORS"])):?>
	<?=ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif?>

<?if ($arResult["MESSAGE"] <> ''):?>
	<script>
	    popup_show_job_position("infoAdministrator");
	    document.getElementById("for-form-vac-2").reset();
    </script>
<?endif?>
<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" id="for-form-vac-2" method="post" enctype="multipart/form-data">

	<?=bitrix_sessid_post()?>
	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
    <div class="in-type" data-ser="<?=$byNew?>" style="display:none"></div>

    <table class="data-table-top-all">
        <tbody class="data-table-resume-title">
            <tr class="data-table-resume-title-txt-one">
	            <td class="data-table-resume-title-txt">Оставить резюме</td>
	        </tr>
	        <tr class="data-table-resume-title-txt-two" style="display:none">
	            <td class="data-table-resume-title-txt-2">Оставить резюме</td>
	            <td class="data-table-resume-title-txt-2-1">Общие документы</td>
            </tr>
        </tbody>
        <tbody class="data-table-resume-title-right">
            <tr>
    	        <td class="data-table-resume-title-right-1">1</td>
    	        <td class="data-table-resume-title-right-11">—</td>
    	        <td class="data-table-resume-title-right-2">2</td>
	        </tr>
        </tbody>
    </table>

	<table class="data-table">
	    
	    <? //Первая панель ?>
		<?if (!empty($arResult["PROPERTY_LIST"]) && is_array($arResult["PROPERTY_LIST"])):?>
		<tbody class="data-table-panel-1">
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
			    <?if ($propertyID == "63" || $propertyID == "64" || $propertyID == "65" || $propertyID == "66" || $propertyID == "67" || $propertyID == "68" || $propertyID == "69" || $propertyID == "70" || $propertyID == "71" || $propertyID == "72" || $propertyID == "73") {?>
			    <?if ($propertyID == "65") {?> <tr class="data-table-resume-location-info"> <?} else if ($propertyID =="59") {?> <tr class="data-table-resume-email-info"> <?} else if ($propertyID =="67") {?> <tr class="data-table-resume-job-aboard-info"> <?} else if ($propertyID =="68") {?> <tr class="data-table-resume-job-endlish-info"> <?} else if ($propertyID =="69") {?> <tr class="data-table-resume-job-about-info"> <?} else if ($propertyID =="71") {?> <tr class="data-table-resume-job-about-info-number-p"> <?} else if ($propertyID =="73") {?> <tr class="data-table-resume-job-about-info-n-p-r"> <?} else if ($propertyID =="66") {?> <tr class="data-table-resume-job-about-proff-info"> <?}  else {?>
				<tr><?}?>
				    <?if ($propertyID =="70"){?> <td class="data-table-resume-title-txt-contancts">Контактная информация</td><?}?>
					<td><?if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?><?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?><span class="starrequired"></span><?endif?></td>
					<td>
						<?
						//echo "<pre>"; print_r($arResult["PROPERTY_LIST_FULL"]); echo "</pre>";
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || !empty($arResult["ERRORS"])) && !empty($arResult["ELEMENT_PROPERTIES"][$propertyID]) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];

						switch ($INPUT_TYPE):
							case "USER_TYPE":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
										$description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
										$description = "";
									}
									else
									{
										$value = "";
										$description = "";
									}
									echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
										array(
											$arResult["PROPERTY_LIST_FULL"][$propertyID],
											array(
												"VALUE" => $value,
												"DESCRIPTION" => $description,
											),
											array(
												"VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
												"DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
												"FORM_NAME"=>"iblock_add",
											),
										));
								?><br /><?
								}
							break;
							case "TAGS":
								$APPLICATION->IncludeComponent (
									"bitrix:search.tags.input",
									"",
									array(
										"VALUE" => $arResult["ELEMENT"][$propertyID],
										"NAME" => "PROPERTY[".$propertyID."][0]",
										"TEXT" => 'size="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"].'"',
									), null, array("HIDE_ICONS"=>"Y")
								);
								break;
							case "HTML":
								$LHE = new CLightHTMLEditor;
								$LHE->Show(array(
									'id' => preg_replace("/[^a-z0-9]/i", '', "PROPERTY[".$propertyID."][0]"),
									'width' => '100%',
									'height' => '200px',
									'inputName' => "PROPERTY[".$propertyID."][0]",
									'content' => $arResult["ELEMENT"][$propertyID],
									'bUseFileDialogs' => false,
									'bFloatingToolbar' => false,
									'bArisingToolbar' => false,
									'toolbarConfig' => array(
										'Bold', 'Italic', 'Underline', 'RemoveFormat',
										'CreateLink', 'DeleteLink', 'Image', 'Video',
										'BackColor', 'ForeColor',
										'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
										'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
										'StyleList', 'HeaderList',
										'FontList', 'FontSizeList',
									),
								));
								break;
							case "T":
								for ($i = 0; $i<$inputNum; $i++)
								{

									if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
									}
									else
									{
										$value = "";
									}
								?>
						<textarea <?if ( $propertyID == 69 ) {?> minlength="1" maxlength="1000" <?}?> cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea>
								<?
								}
							break;

							case "S":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
								
								<input
								
								<?if ($propertyID == 63 || $propertyID == 70 || $propertyID == 71 || $propertyID == 'NAME' || $propertyID == 58) {?> placeholder="*обязательное поле" <?}?>
						    	<?if ($propertyID == 'NAME') {?> minlength="1" maxlength="56" <?}?>
						    	<?if ($propertyID == 71) {?> minlength="1" maxlength="13" <?}?>
						    	<?if ($propertyID == 70 || $propertyID == 72 || $propertyID == 73) {?> minlength="1" maxlength="56" <?}?>
						    	<?if ($propertyID == 69) {?> minlength="1" maxlength="2000" <?}?>
								type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=$value?>" /><br />
								<?
								if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?><?
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'FORM_NAME' => 'iblock_add',
											'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
											'INPUT_VALUE' => $value,
										),
										null,
										array('HIDE_ICONS' => 'Y')
									);
									?><br /><small><?=GetMessage("IBLOCK_FORM_DATE_FORMAT")?><?=FORMAT_DATETIME?></small><?
								endif
								?><br /><?
								}
							break;

							case "F":
								for ($i = 0; $i<$inputNum; $i++)
								{
									$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									?>
						<input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
						<input type="file" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" /><br />
									<?

									if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value]))
									{
										?>
					<input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label><br />
										<?

										if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"])
										{
											?>
					<img src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" /><br />
											<?
										}
										else
										{
											?>
					<?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?><br />
					<?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> b<br />
					[<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]<br />
											<?
										}
									}
								}

							break;
							case "L":

								if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
								else
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

								switch ($type):
									case "checkbox":
									case "radio":

										//echo "<pre>"; print_r($arResult["PROPERTY_LIST_FULL"][$propertyID]); echo "</pre>";
										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
											{
												if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID]))
												{
													foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum)
													{
														if ($arElEnum["VALUE"] == $key) {$checked = true; break;}
													}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}

											?>
							<input type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> /><label for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label><br />
											<?
										}
									break;

									case "dropdown":
									case "multiselect":
									?>
							<select onclick="" name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
									<?
										if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
										else $sKey = "ELEMENT";

										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
											{
												foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum)
												{
													if ($key == $arElEnum["VALUE"]) {$checked = true; break;}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}
											?>
								<option data-html-text="<?=$arEnum["VALUE"]?>" id="<?=$key?>" value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
											<?
										}
									?>
							</select>
									<?
									break;

								endswitch;
							break;
						endswitch;?>
						<?if ($propertyID =="68"){?>
						    <div class="data-table-resume-photo-block">
    				            <span class="data-table-resume-photo-block-n-n">Фотография</span>
                                            <?$APPLICATION->IncludeComponent("bitrix:main.file.input", "new_drag_n_drop1",
                                           array(
                                              "INPUT_NAME"=>"NEW_FILE_UPLOAD",
                                              "MULTIPLE"=>"N",
                                              "MODULE_ID"=>"main",
                                              "MAX_FILE_SIZE"=>"1048576",
                                              "ALLOW_UPLOAD"=>"I", 
                                              "ALLOW_UPLOAD_EXT"=>"",
                                        	  "INPUT_CAPTION" => "Добавить фото",
                                        	  "INPUT_VALUE" => $_POST['NEW_FILE_UPLOAD']
                                           ),
                                           false
                                        );?>
                                <div class="data-table-resume-photo-title-name-inf" id="data-table-resume-photo-title-name-inf">*Не больше 10 мб</div>
						    </div>
					    <?}?>
					</td>
				</tr>
				<?}?>
			<?endforeach;?>
			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?></td>
					<td>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</td>
				</tr>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired"></span>:</td>
					<td><input type="text" name="captcha_word" maxlength="50" value=""/></td>
				</tr>
			<?endif?>
			
		</tbody>
		<tbody class="contin-1">
    	    <tr>
    	        <td>
                   <div class="table-continue-for-two" id="table-continue-for-two">Следующий пункт</div>
               </td>
           </tr>
		</tbody>
		
		<?// Вторая панель?>
		
		<?if (!empty($arResult["PROPERTY_LIST"]) && is_array($arResult["PROPERTY_LIST"])):?>
		
		<tbody class="data-table-contin" id="data-table-contin" style="display:none">
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
			
			<?//Отбор только нужных даны для второй страницы?>
			<?if ($propertyID == "74" || $propertyID == "75" || $propertyID == "76" || $propertyID == "77" || $propertyID == "78" || $propertyID == "79" || $propertyID == "80" || $propertyID == "81" || $propertyID == "82" || $propertyID == "83" || $propertyID == "84" || $propertyID == "85" || $propertyID == "86" || $propertyID == "87" || $propertyID == "88" || $propertyID == "89" || $propertyID == "90" || $propertyID == "91" || $propertyID == "92" || $propertyID == "93" || $propertyID == "94" || $propertyID == "95" || $propertyID == "96" || $propertyID == "97" || $propertyID == "98" || $propertyID == "99" || $propertyID == "100" || $propertyID == "101" || $propertyID == "NAME") {?>
			

				<tr class="data-table-contin-<?=$propertyID?>">
					<td><?if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?><?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?><span class="starrequired"></span><?endif?></td>
					<td>
						<?
						//echo "<pre>"; print_r($arResult["PROPERTY_LIST_FULL"]); echo "</pre>";
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || !empty($arResult["ERRORS"])) && !empty($arResult["ELEMENT_PROPERTIES"][$propertyID]) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];

						switch ($INPUT_TYPE):
							case "USER_TYPE":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
										$description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
										$description = "";
									}
									else
									{
										$value = "";
										$description = "";
									}
									echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
										array(
											$arResult["PROPERTY_LIST_FULL"][$propertyID],
											array(
												"VALUE" => $value,
												"DESCRIPTION" => $description,
											),
											array(
												"VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
												"DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
												"FORM_NAME"=>"iblock_add",
											),
										));
								?><br /><?
								}
							break;
							case "TAGS":
								$APPLICATION->IncludeComponent (
									"bitrix:search.tags.input",
									"",
									array(
										"VALUE" => $arResult["ELEMENT"][$propertyID],
										"NAME" => "PROPERTY[".$propertyID."][0]",
										"TEXT" => 'size="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"].'"',
									), null, array("HIDE_ICONS"=>"Y")
								);
								break;
							case "HTML":
								$LHE = new CLightHTMLEditor;
								$LHE->Show(array(
									'id' => preg_replace("/[^a-z0-9]/i", '', "PROPERTY[".$propertyID."][0]"),
									'width' => '100%',
									'height' => '200px',
									'inputName' => "PROPERTY[".$propertyID."][0]",
									'content' => $arResult["ELEMENT"][$propertyID],
									'bUseFileDialogs' => false,
									'bFloatingToolbar' => false,
									'bArisingToolbar' => false,
									'toolbarConfig' => array(
										'Bold', 'Italic', 'Underline', 'RemoveFormat',
										'CreateLink', 'DeleteLink', 'Image', 'Video',
										'BackColor', 'ForeColor',
										'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
										'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
										'StyleList', 'HeaderList',
										'FontList', 'FontSizeList',
									),
								));
								break;
							case "T":
								for ($i = 0; $i<$inputNum; $i++)
								{

									if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
									}
									else
									{
										$value = "";
									}
								?>
						<textarea <?if ( $propertyID == 61 ) {?> placeholder="*обязательное поле" <?}?> cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea>
								<?
								}
							break;

							case "S":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
								
								<input
								
								<?if ($propertyID == 75 || $propertyID == 76 || $propertyID == 77 || $propertyID == 78 || $propertyID == 79) {?> placeholder="*обязательное поле" <?}?>
						    	<?if ($propertyID == 'NAME') {?> minlength="1" maxlength="56" <?}?>
						    	<?if ($propertyID == 60) {?> minlength="1" maxlength="13" <?}?>
						    	<?if ($propertyID == 59) {?> minlength="1" maxlength="56" <?}?>
						    	<?if ($propertyID == 61) {?> minlength="1" maxlength="2000" <?}?>
								type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=$value?>" /><br />
								<?
								if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?><?
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'FORM_NAME' => 'iblock_add',
											'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
											'INPUT_VALUE' => $value,
										),
										null,
										array('HIDE_ICONS' => 'Y')
									);
									?><br /><small><?=GetMessage("IBLOCK_FORM_DATE_FORMAT")?><?=FORMAT_DATETIME?></small><?
								endif
								?><br /><?
								}
							break;

							case "F":
								for ($i = 0; $i<$inputNum; $i++)
								{
									$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									?>
						<input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
						<input type="file" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" /><br />
									<?

									if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value]))
									{
										?>
					<input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label><br />
										<?

										if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"])
										{
											?>
					<img src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" /><br />
											<?
										}
										else
										{
											?>
					<?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?><br />
					<?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> b<br />
					[<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]<br />
											<?
										}
									}
								}

							break;
							case "L":

								if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
								else
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

								switch ($type):
									case "checkbox":
									case "radio":

										//echo "<pre>"; print_r($arResult["PROPERTY_LIST_FULL"][$propertyID]); echo "</pre>";
										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
											{
												if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID]))
												{
													foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum)
													{
														if ($arElEnum["VALUE"] == $key) {$checked = true; break;}
													}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}

											?>
							<input type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> /><label for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label><br />
											<?
										}
									break;

									case "dropdown":
									case "multiselect":
									?>
							<select class="add-select-resume"  name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
									<?
										if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
										else $sKey = "ELEMENT";

										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || !empty($arResult["ERRORS"]))
											{
												foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum)
												{
													if ($key == $arElEnum["VALUE"]) {$checked = true; break;}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}
											?>
								<option data-html-text="<?=$arEnum["VALUE"]?>" id="<?=$key?>" value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
											<?
										}
									?>
							</select>
									<?
									break;

								endswitch;
							break;
						endswitch;?>
					</td>
				</tr>
				<?if ($propertyID == 79) {?> 
    				<tr class="data-table-contin-button-doc"><td class="data-table-contin-button-doc-txt" id="data-table-contin-button-doc-txt" style="padding-right: 5%!important;">Добавить документ</td></tr>
    				<tr class="data-table-contin-line"><td></td></tr> <?}?>
				<?}?>
				<?if ($propertyID == 84) {?> 
    				<tr class="data-table-contin-button-dip"><td class="data-table-contin-button-dip-txt" id="data-table-contin-button-dip-txt" style="padding-right: 2%!important;">Добавить диплом</td></tr>
    				<tr class="data-table-contin-line"><td></td></tr> 
    			<?}?>
    			<?if ($propertyID == 89) {?> 
    				<tr class="data-table-contin-button-ser"><td class="data-table-contin-button-ser-txt" id="data-table-contin-button-ser-txt" style="padding-right: 5%!important;">Добавить сертификат</td></tr>
    				<tr class="data-table-contin-line"><td></td></tr> 
    			<?}?>
    			<?if ($propertyID == 101) {?> 
    				<tr class="data-table-contin-button-opt"><td class="data-table-contin-button-opt-txt" id="data-table-contin-button-opt-txt" style="padding-right: 5%!important;">Добавить опыт работы</td></tr> 
    			<?}?>
			<?endforeach;?>
			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?></td>
					<td>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</td>
				</tr>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired"></span>:</td>
					<td><input type="text" name="captcha_word" maxlength="50" value=""/></td>
				</tr>
			<?endif?>
		</tbody>
		<?endif?>
		<tfoot class="dop-panel-query" style="display:none">
			<tr>
			    <td><div class="position-politics-off">
    				    <?$APPLICATION->IncludeComponent(
                        	"bitrix:main.userconsent.request",
                        	"new-castom-user-checxbox",
                            	Array(
                            		"AUTO_SAVE" => "Y",
                            		"ID" => "3",
                            		"IS_CHECKED" => "N",
                            		"IS_LOADED" => "N"
                            	)
                        );?>
                    </div></td>
				<td colspan="2" class="data-table-butt-resume">
				    <div class="table-continue-for-two-one" id="table-continue-for-one">Предыдущий пункт</div>
					<input type="submit" id="button-bord-resum" name="iblock_submit" value="Оставить резюме" />
					<?if ($arParams["LIST_URL"] <> '' && $arParams["ID"] > 0):?><input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" /><?endif?>
					<?/*<input type="reset" value="<?=GetMessage("IBLOCK_FORM_RESET")?>" />*/?>
				</td>
				<td class="data-table-bottom-war-info">Срок публикации резюме — один месяц</td>
			</tr>
		</tfoot>
		<?endif?>
	</table>
	
<?
$byNew = $USER->GetID();
$rsUserNew = CUser::GetByID($byNew);
$arUserNew = $rsUserNew->Fetch();
$arUserNew["UF_AD_APP"];
if ($arUserNew["UF_AD_APP"] != "4") {?>
	<script>
	    // функция отслеживания клика для изменения подтверждения политики и раскрытие блока с правилами 
        $(document).ready(function() {
            $('#popup_job_resume #input_popup_politics').live('click', function() {
                  $('#popup_job_resume #input_popup_politics').addClass("active");
            });
            
            $('#popup_job_resume .input_popup_politics.active').live('click', function() {
                  $('#popup_job_resume #input_popup_politics').removeClass("active");
            });
        })
	
        // placeholder добавляется в выбор города
        let inputs_place = document.querySelector('#popup_job_resume .mli-layout input.mli-field');
        if (inputs_place.value == "") {
            inputs_place.placeholder = 'начните вводить город';
        }
        
        // placeholder добавляется for date
        let inputsAll = document.querySelectorAll('#popup_job_resume input');
        for (let inputAll of inputsAll) {
            if (inputAll.name == "PROPERTY[78][0][VALUE]" || inputAll.name == "PROPERTY[79][0][VALUE]" || inputAll.name == "PROPERTY[83][0][VALUE]" || inputAll.name == "PROPERTY[84][0][VALUE]" || inputAll.name == "PROPERTY[64][0][VALUE]"
            ||  inputAll.name == "PROPERTY[88][0][VALUE]" || inputAll.name == "PROPERTY[89][0][VALUE]" || inputAll.name == "PROPERTY[100][0][VALUE]" || inputAll.name == "PROPERTY[101][0][VALUE]") {
                inputAll.placeholder = 'дд.мм.гггг';
                inputAll.setAttribute('maxlength','10');
                inputAll.addEventListener('keydown', function (e) {
                    this.value = this.value.replace(/^\.|[^\d\.]/g,'')
                });
            }
        }
        
        function valDate() {
            this.value = this.value.replace(/[^0-9]/g,'')
        }
        
        
        let _edid_for_on_main_panel = document.getElementById("popup_job_resume");
        let _edid_for_on_main_over = document.querySelector('.overlay');
        let warring = false;
        let vs, vs1, vs2;

        // Кнопка перехода на первую панель
        document.getElementById('table-continue-for-one').onclick = function() {
        let par_is_two = _edid_for_on_main_panel.offsetHeight;
        let par_is_two_2 = Number(_edid_for_on_main_over.style.height.replace('%', ''))
        let par_is_two_3 = Number(_edid_for_on_main_panel.style.marginTop.replace('px', ''));
            if (par_is_two == 2872 && par_is_two_2 == 380) {
                warring = false;
                document.querySelector('.dop-panel-query').style = "display:none";
                document.querySelector('.contin-1').style = "display:table-row-group";
                panelOne.style = "";
                panelTwo.style = "display:none";
                leftCountInfo.style = ""
                rightCountInfo.style = ""
                titleOne.style = ""
                titleTwo.style = "display:none"
                document.getElementById("popup_job_resume").style ="";
                document.querySelector('#popup_wrapper .overlay').style = "";
            } else {
                warring = true;
                vs = par_is_two;
                vs1 = par_is_two_2;
                vs2 = par_is_two_3;
                document.querySelector('.dop-panel-query').style = "display:none";
                document.querySelector('.contin-1').style = "display:table-row-group";
                panelOne.style = "";
                panelTwo.style = "display:none";
                leftCountInfo.style = ""
                rightCountInfo.style = ""
                titleOne.style = ""
                titleTwo.style = "display:none"
                document.getElementById("popup_job_resume").style ="";
                document.querySelector('#popup_wrapper .overlay').style = "";
            }
        }
        
        
        let panelOne = document.querySelector('#popup_job_resume .data-table .data-table-panel-1');
        let panelTwo = document.querySelector('#popup_job_resume .data-table .data-table-contin');
        let leftCountInfo = document.querySelector('.data-table-resume-title-right-1');
        let rightCountInfo = document.querySelector('.data-table-resume-title-right-2');
        let titleOne = document.querySelector('.data-table-resume-title-txt-one');
        let titleTwo = document.querySelector('.data-table-resume-title-txt-two');
        
        // функция перехода по клику для заполнение второй страницы
        document.getElementById('table-continue-for-two').onclick = function() {
            let counter = 0;
            let inputs = document.querySelectorAll('#popup_job_resume .data-table .data-table-panel-1 input');
            for (let input of inputs) {
                if (input.name != "PROPERTY[72][0]") {
                    if (input.name != "PROPERTY[73][0]") {
                        if (input.value == "" || input.value == "введите текст") {
                            input.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)";
                            input.style.border = "1px solid rgba(205, 21, 21, 0.78)";
                            //counter += 1;
                        } else {
                            input.style.boxShadow = "none";
                            input.style.border = "1px solid";
                        }
                    }
                }
            }
            
            if (counter == "1" || counter == "0") {
                if (warring == false) {
                    document.querySelector('.dop-panel-query').style = "display:table-footer-group";
                    document.querySelector('.contin-1').style = "display:none";
                    panelOne.style = "display:none";
                    panelTwo.style = "display:block";
                    leftCountInfo.style = "background:unset; color: #035AA6; border: 1px solid #035AA6;width: 30px;"
                    rightCountInfo.style = "background:#035AA6; color: #FFF; border: 1px solid #035AA6;"
                    titleOne.style = "display:none"
                    titleTwo.style = "display:grid"
                    document.getElementById("popup_job_resume").style ="height:2872px;margin-top: 2210px;";
                    document.querySelector('#popup_wrapper .overlay').style = "height: 380%;";
                    document.querySelector('#popup_wrapper #popup_job_resume .content').style = "padding: 0 63px;";
                } else {
                    document.querySelector('.dop-panel-query').style = "display:table-footer-group";
                    document.querySelector('.contin-1').style = "display:none";
                    panelOne.style = "display:none";
                    panelTwo.style = "display:block";
                    leftCountInfo.style = "background:unset; color: #035AA6; border: 1px solid #035AA6;width: 30px;"
                    rightCountInfo.style = "background:#035AA6; color: #FFF; border: 1px solid #035AA6;"
                    titleOne.style = "display:none"
                    titleTwo.style = "display:grid"
                    _edid_for_on_main_panel.style.height = vs+'px';
                    _edid_for_on_main_panel.style.marginTop = vs2+'px';
                    _edid_for_on_main_over.style.height = vs1+'%';
                    document.querySelector('#popup_wrapper #popup_job_resume .content').style = "padding: 0 63px;";
                }
            }
        }
        
        
        // Загрузка фотографии
        /*$(".data-table-resume-photo-title-name").click(function() {
            if(!(document.getElementById('data-table-resume-photo').value)) {
                $("input[type='file'").trigger('click');
            }
        });*/
        
        //Проверка загруженности фотографии
        /*
        $('#file-placeholder-tbody').bind('DOMNodeInserted DOMNodeRemoved', function(event) {
            if (event.type == 'DOMNodeInserted') {
                document.getElementById('data-table-resume-photo-title-name').classList.add('active');
                document.getElementById('data-table-resume-photo-title-name-lg').classList.add('active');
            } else {
                document.getElementById('data-table-resume-photo-title-name').classList.remove('active');
                document.getElementById('data-table-resume-photo-title-name-lg').classList.remove('active');
            }
        });
        */
        // изменение стандартой панели списка select (первая панель)
        $(document).ready(function() {
            
            let selectss = document.querySelectorAll('#popup_job_resume .data-table .data-table-panel-1 select');
            
            for (let selects of selectss) {
                let select = $('select[name="'+selects.name+'"]');
            
                let selectBoxContainer = $('<div>', {
                    width: select.outerWidth(),
                    className: 'tzSelect_basic_resum',
                    html: '<div class="selectBox_basic_resum" id="selectBox_basic_resum"></div>'
                });
                
                let dropDown = $('<ul>', {
                    className: 'dropDown_basic_resum'
                });
                
                let selectBox = selectBoxContainer.find('.selectBox_basic_resum');
                
                select.find('option').each(function(i) {
                    let option = $(this);
                    
                    if (i == select.attr('selectedIndex')) {
                        selectBox.html(option.text());
                    }
                    
                    if (option.data('skip')) {
                        return true;
                    }
                    
                    let li = $('<li>', {
                        html: '<span>' +
                        option.data('html-text') + '</span>'
                    });
                    
                    li.click(function() {
                    
                        selectBox.html(option.text());
                        dropDown.trigger('hide');
                        
                        for (const lit of document.querySelectorAll('li')) {
                            if (lit.matches('.active')) {
                                lit.classList.remove('active')
                            }
                        }
                        
                        li.addClass('active')
                        select.val(option.val());
                        
                        return false;
                    });
                    
                    dropDown.append(li);
                });
                
                selectBoxContainer.append(dropDown.hide());
                select.hide().after(selectBoxContainer);
                
                dropDown.bind('show', function() {
                
                    if (dropDown.is(':animated')) {
                        return false;
                    }
                    
                    selectBox.addClass('expanded');
                    dropDown.slideDown();
                
                }).bind('hide', function() {
                
                    if (dropDown.is(':animated')) {
                        return false;
                    }
                    
                    selectBox.removeClass('expanded');
                    dropDown.slideUp();
                
                }).bind('toggle', function() {
                    if (selectBox.hasClass('expanded')) {
                        dropDown.trigger('hide');
                    } else dropDown.trigger('show');
                });
                
                selectBox.click(function() {
                    dropDown.trigger('toggle');
                    return false;
                });
                
                $(document).click(function() {
                    dropDown.trigger('hide');
                });
                
                if (selects.name == "PROPERTY[66]") {
                    document.querySelector(".dropDown_basic_resum").style = "width: 269px;height: 491px;overflow: scroll;transition: none; display:none"
                } else if (selects.name == "PROPERTY[67]"){
                    document.querySelectorAll(".dropDown_basic_resum")[1].style = "width: 269px;height: 82px;transition: none; display:none"
                }
            }
        });
        
        
        // изменение стандартой панели списка select (вторая панель)
        $(document).ready(function() {
            
            let selectss = document.querySelectorAll('#popup_job_resume .data-table-contin select');
            
            for (let selects of selectss) {
                let select = $('select[name="'+selects.name+'"]');
            
                let selectBoxContainer = $('<div>', {
                    width: select.outerWidth(),
                    className: 'tzSelect_basic_resum_contin',
                    html: '<div class="selectBox_basic_resum_contin" id="selectBox_basic_resum_contin"></div>'
                });
                
                let dropDown = $('<ul>', {
                    className: 'dropDown_basic_resum_contin'
                });
                
                let selectBox = selectBoxContainer.find('.selectBox_basic_resum_contin');
                
                select.find('option').each(function(i) {
                    let option = $(this);
                    
                    if (i == select.attr('selectedIndex')) {
                        selectBox.html(option.text());
                    }
                    
                    if (option.data('skip')) {
                        return true;
                    }
                    
                    let li = $('<li>', {
                        html: '<span>' +
                        option.data('html-text') + '</span>'
                    });
                    
                    li.click(function() {
                    
                        selectBox.html(option.text());
                        dropDown.trigger('hide');
                        
                        for (const lit of document.querySelectorAll('li')) {
                            if (lit.matches('.active')) {
                                lit.classList.remove('active')
                            }
                        }
                        
                        li.addClass('active')
                        select.val(option.val());
                        
                        return false;
                    });
                    
                    dropDown.append(li);
                });
                
                selectBoxContainer.append(dropDown.hide());
                select.hide().after(selectBoxContainer);
                
                dropDown.bind('show', function() {
                
                    if (dropDown.is(':animated')) {
                        return false;
                    }
                    
                    selectBox.addClass('expanded');
                    dropDown.slideDown();
                
                }).bind('hide', function() {
                
                    if (dropDown.is(':animated')) {
                        return false;
                    }
                    
                    selectBox.removeClass('expanded');
                    dropDown.slideUp();
                
                }).bind('toggle', function() {
                    if (selectBox.hasClass('expanded')) {
                        dropDown.trigger('hide');
                    } else dropDown.trigger('show');
                });
                
                selectBox.click(function() {
                    dropDown.trigger('toggle');
                    return false;
                });
                
                $(document).click(function() {
                    dropDown.trigger('hide');
                });
                let newInfo = document.querySelectorAll(".data-table-contin-91 .dropDown_basic_resum_contin");
                for (let newNinfo of newInfo) {
                    //console.log(newNinfo,newInfo)
                    newNinfo.style = "overflow: scroll;"
                }
                if (selects.name == "PROPERTY[80][]") {
                    document.querySelectorAll(".dropDown_basic_resum_contin")[1].style = "overflow: scroll;display:none"
                } else if (selects.name == "PROPERTY[85]") {
                    document.querySelectorAll(".dropDown_basic_resum_contin")[2].style = "overflow: scroll;display:none"
                } else if (selects.name == "PROPERTY[91]") { 
                    document.querySelectorAll(".dropDown_basic_resum_contin")[3].style = "overflow: scroll;display:none"
                }
            }
        });
        
        function general_all_adm() {
            
            let usID = $('.form .in-type').data("ser");
            let usPhoto = document.querySelector('.file-placeholder-tbody tr').id.slice(6);
            
            if (usPhoto != "" && usID !="") {
                var usIDJS = usID;
                var usPhotoJS = usPhoto;
                editPhoto(usIDJS, usPhotoJS);
            }
        };
        
        // проверка заполнения полей перед отправкой
        let warningError = 0;
        document.getElementById('button-bord-resum').onclick = function() {
            let inputs = document.querySelectorAll('#popup_job_resume .data-table-contin input');
            let couner_q = 0;
            let __check = document.querySelector('#popup_job_resume #input_popup_politics');
            
            if (document.querySelector('.data-table-contin-NAME td input').value == "") {
                let valueOptional = $('.data-table-resume-job-about-proff-info option:selected').text();
                document.querySelector('.data-table-contin-NAME td input').value = valueOptional;
            }
            
            if (__check.checked == false) {
                __check.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                __check.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                event.preventDefault();
            } else {
                __check.style.boxShadow = "none"
                __check.style.border = "1px solid" 
            }
            

            //Проверка на заполненность не обязательных параметров, но для отображения на детальной информации
            if (warningError > 7) {
                if (document.querySelector('textarea[name="PROPERTY[69][0]').value == "") {
                   document.querySelector('textarea[name="PROPERTY[69][0]').value = "—"
                }
                if (document.querySelector('input[name="PROPERTY[72][0]"]').value == "") {
                   document.querySelector('input[name="PROPERTY[72][0]"]').value = "—"
                }
                if (document.querySelector('input[name="PROPERTY[73][0]"]').value == "") {
                   document.querySelector('input[name="PROPERTY[73][0]').value = "—"
                }
                
                let verInputval = document.querySelectorAll('.data-table-contin tr input');
                
                for (let newVerInputval of verInputval) {
                    if (newVerInputval.name != "PROPERTY[NAME][0]" && newVerInputval.name != "PROPERTY[75][0]" && newVerInputval.name != "PROPERTY[76][0]" && newVerInputval.name != "PROPERTY[77][0]" && newVerInputval.name != "PROPERTY[78][0][VALUE]" && newVerInputval.name != "PROPERTY[79][0][VALUE]" && newVerInputval.placeholder != "дд.мм.гггг") {
                        if (newVerInputval.value == "") {
                            newVerInputval.value = "—";
                        }
                    } else if (newVerInputval.placeholder == "дд.мм.гггг" && newVerInputval.name != "PROPERTY[78][0][VALUE]" && newVerInputval.name != "PROPERTY[79][0][VALUE]") {
                        if (newVerInputval.value == "") {
                            newVerInputval.value = "01.01.0001";
                        }
                    }
                }
                
                let verSelectVal = document.querySelectorAll('.add-select-resume');
                let verSelectValProff = document.querySelector('.data-table-resume-job-about-proff-info .selectBox_basic_resum');
                for (let NewVerSelectVal of verSelectVal) {
                    if (NewVerSelectVal.value == "" && NewVerSelectVal.name == "PROPERTY[80][]") {
                        let verSelectOption = document.querySelectorAll('select[name="PROPERTY[80][]"] option');
                        for (let nverSelectOption of verSelectOption) {
                            if (nverSelectOption.innerText == verSelectValProff.innerText) {
                                NewVerSelectVal.value = nverSelectOption.id;
                            }
                        }
                    } else if (NewVerSelectVal.value == "" && NewVerSelectVal.name == "PROPERTY[91][]") {
                        let verSelectOption = document.querySelectorAll('select[name="PROPERTY[91][]"] option');
                        for (let nverSelectOption of verSelectOption) {
                            if (nverSelectOption.innerText == verSelectValProff.innerText) {
                                NewVerSelectVal.value = nverSelectOption.id;
                            }
                        }
                    } else if (NewVerSelectVal.value == "" && NewVerSelectVal.name == "PROPERTY[85][]") {
                        NewVerSelectVal.value = "133";
                    }
                }
                //Функция изменения фото профиля
                general_all_adm();
            }
            
            //console.log(document.querySelector('.data-table-resume-photo-block input').value)
            
            // проверка даты начала и окончания
            let __checkDate = document.querySelector('input[name="PROPERTY[78][0][VALUE]"]');
            let __checkDateArray = __checkDate.value;
            //new Date(__checkDateArray);
            
            let __checkDate2 = document.querySelector('input[name="PROPERTY[79][0][VALUE]"]');
            let __checkDateArray2 = __checkDate2.value;
            new Date(__checkDateArray2);
            
            if (new Date(__checkDateArray) > new Date(__checkDateArray2)) {
                alert("Дата начала не должна быть больше даты окончания!")
            }
            
            let strSel = $('.data-table-contin-74 .selectBox_basic_resum_contin').text();
            if (strSel == "") {
                document.querySelector('.data-table-contin-74 .selectBox_basic_resum_contin').style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)";
                document.querySelector('.data-table-contin-74 .selectBox_basic_resum_contin').style.border = "1px solid rgba(205, 21, 21, 0.78)";
                scrollTopPanel();
                event.preventDefault();
                warningError -= 1;
            } else {
                document.querySelector('.data-table-contin-74 .selectBox_basic_resum_contin').style.boxShadow = "none"
                document.querySelector('.data-table-contin-74 .selectBox_basic_resum_contin').style.border = "1px solid"
                warningError += 1;
            }
            
            for (let input of inputs) {
                couner_q += 1;
                if (couner_q < 7) {
                    if (input.value == "" || input.value == "введите текст") {
                        input.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                        input.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                        scrollTopPanel();
                        warningError -= 1;
                        event.preventDefault();
                    } else {
                        input.style.boxShadow = "none"
                        input.style.border = "1px solid"
                        warningError += 1;
                    }
                }
            }
            
            let newParamDateVerOT = document.querySelectorAll('.data-table-contin-78 input');
            let newParamDateVerDO = document.querySelectorAll('.data-table-contin-79 input');
            //alert(warningError)
        }
        
        // Смещение к началу страницы 
        function scrollTopPanel() {
            document.querySelector('.data-table-top-all').scrollIntoView ({ 
                block: 'nearest', 
                behavior: 'smooth', 
            });
        } 
        
        // функция добавления документа
        document.getElementById('data-table-contin-button-doc-txt').onclick = function() {   
            let _inputsPanelOne = document.querySelectorAll('#popup_job_resume .data-table-contin tr');
            let _line = document.querySelector('.data-table-contin-line');
            let _popup_main_panel = document.getElementById("popup_job_resume");
            let _popup_main_over = document.querySelector('.overlay');
            let couner_q = 0;
            
            if ( document.querySelectorAll('.data-table-contin-74').length < 8) {
                document.querySelector('.data-table-contin-button-doc').before(_line.cloneNode(true));
                for (let input of _inputsPanelOne) {
                    couner_q += 1;
                    if (couner_q < 8 && 1 < couner_q) {
                        document.querySelector('.data-table-contin-button-doc').before(input.cloneNode(true));
                        input.value = "";
                        let InputClassN = '.'+input.className+' input';
                        let SelectClassN = '.'+input.className+' select';
                        let _inputsPanelOneNew = document.querySelectorAll(InputClassN);
                        let _selectPanelOneNew = document.querySelectorAll(SelectClassN);
                        let couner_n = -1;
                        for (let NewSel of _selectPanelOneNew) {
                            couner_n += 1;
                            if ( couner_n > 0 && NewSel.name == "PROPERTY[74][]") {
                                let NewinputNameNewEdit = NewSel.name.replace('[]', '')
                                NewSel.name = NewinputNameNewEdit + "[" + couner_n + "]";
                            }
                        }
                        let queryIMGCal = document.querySelectorAll('.'+input.className+' img');
                        let couner_d = -1;
                        for (let Newinput of _inputsPanelOneNew) {
                            couner_d += 1;
                            if (couner_d > 0) {
                                //Newinput.value = "";
                                if (Newinput.name == "PROPERTY[78][0][VALUE]" || Newinput.name == "PROPERTY[79][0][VALUE]") {
                                    let inputNameNewEdit = Newinput.name.replace('[0][VALUE]', '')
                                    let se = Newinput.name;
                                    let seachQUE = queryIMGCal[couner_d].outerHTML;
                                    Newinput.name = inputNameNewEdit + "[" + couner_d + "][VALUE]";
                                    let newstr = seachQUE.replace(se, Newinput.name);
                                    queryIMGCal[couner_d].outerHTML = newstr;
                                } else {
                                    let inputNameNewEdit = Newinput.name.replace('[0]', '')
                                    Newinput.name = inputNameNewEdit + "[" + couner_d + "]";
                                }
                                let nn_couner = _inputsPanelOneNew.length - couner_d;
                                if (nn_couner == 1) {
                                    Newinput.value = "";
                                }
                            }
                        }
                        if (input.className == "data-table-contin-74") {
                            let delClassN = document.querySelectorAll('.'+input.className+' .tzSelect_basic_resum_contin')
                            let delClassNOne = document.querySelectorAll('.'+input.className+' select')
                            let t = 0;
                            for (let newDelClassN of delClassN) {
                                let newstrpar = delClassN.length - t;
                                t += 1;
                                if ( newstrpar == 1) {
                                    if (newDelClassN.innerHTML != "") {
                                        newDelClassN.remove();
                                        let w = 0;
                                        for (let newdelClassNOne of delClassNOne) {
                                            let newstrparS = delClassNOne.length - w;
                                            w += 1;
                                            if (newdelClassNOne.name != "PROPERTY[74][]" && newstrparS == 1) {
                                                $(document).ready(function() {
                                                    let selectss = document.querySelectorAll('#popup_job_resume .data-table-contin select[name="'+newdelClassNOne.name+'"]');
                                                    
                                                    for (let selects of selectss) {
                                                        let select = $('select[name="'+selects.name+'"]');
                                                    
                                                        let selectBoxContainer = $('<div>', {
                                                            width: select.outerWidth(),
                                                            className: 'tzSelect_basic_resum_contin',
                                                            html: '<div class="selectBox_basic_resum_contin" id="selectBox_basic_resum_contin"></div>'
                                                        });
                                                        
                                                        let dropDown = $('<ul>', {
                                                            className: 'dropDown_basic_resum_contin'
                                                        });
                                                        
                                                        let selectBox = selectBoxContainer.find('.selectBox_basic_resum_contin');
                                                        
                                                        select.find('option').each(function(i) {
                                                            let option = $(this);
                                                            
                                                            if (i == select.attr('selectedIndex')) {
                                                                selectBox.html(option.text());
                                                            }
                                                            
                                                            if (option.data('skip')) {
                                                                return true;
                                                            }
                                                            
                                                            let li = $('<li>', {
                                                                html: '<span>' +
                                                                option.data('html-text') + '</span>'
                                                            });
                                                            
                                                            li.click(function() {
                                                            
                                                                selectBox.html(option.text());
                                                                dropDown.trigger('hide');
                                                                
                                                                for (const lit of document.querySelectorAll('li')) {
                                                                    if (lit.matches('.active')) {
                                                                        lit.classList.remove('active')
                                                                    }
                                                                }
                                                                
                                                                li.addClass('active')
                                                                select.val(option.val());
                                                                
                                                                return false;
                                                            });
                                                            
                                                            dropDown.append(li);
                                                        });
                                                        
                                                        selectBoxContainer.append(dropDown.hide());
                                                        select.hide().after(selectBoxContainer);
                                                        
                                                        dropDown.bind('show', function() {
                                                        
                                                            if (dropDown.is(':animated')) {
                                                                return false;
                                                            }
                                                            
                                                            selectBox.addClass('expanded');
                                                            dropDown.slideDown();
                                                        
                                                        }).bind('hide', function() {
                                                        
                                                            if (dropDown.is(':animated')) {
                                                                return false;
                                                            }
                                                            
                                                            selectBox.removeClass('expanded');
                                                            dropDown.slideUp();
                                                        
                                                        }).bind('toggle', function() {
                                                            if (selectBox.hasClass('expanded')) {
                                                                dropDown.trigger('hide');
                                                            } else dropDown.trigger('show');
                                                        });
                                                        
                                                        selectBox.click(function() {
                                                            dropDown.trigger('toggle');
                                                            return false;
                                                        });
                                                        
                                                        $(document).click(function() {
                                                            dropDown.trigger('hide');
                                                        });
                                                        if (selects.name == "PROPERTY[80]") {
                                                            document.querySelectorAll(".dropDown_basic_resum_contin")[1].style = "overflow: scroll;display:none"
                                                        } else if (selects.name == "PROPERTY[85]") {
                                                            document.querySelectorAll(".dropDown_basic_resum_contin")[2].style = "overflow: scroll;display:none"
                                                        } else if (selects.name == "PROPERTY[91]") { 
                                                            document.querySelectorAll(".dropDown_basic_resum_contin")[3].style = "overflow: scroll;display:none"
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                let _popup_main_over_plus = Number(_popup_main_over.style.height.replace('%', '')) + 60;
                let _popup_main_panel_plus = _popup_main_panel.offsetHeight + 469;
                let _popup_main_panel_plus_marg = Number(_popup_main_panel.style.marginTop.replace('px', '')) + 420;
                _popup_main_panel.style.marginTop = _popup_main_panel_plus_marg + 'px';
                _popup_main_panel.style.height = _popup_main_panel_plus + 'px';
                _popup_main_over.style.height = _popup_main_over_plus + "%";
            }
        }
        
        
        // функция добавления диплома
        document.getElementById('data-table-contin-button-dip-txt').onclick = function() {   
            let _inputsPanelOne = document.querySelectorAll('#popup_job_resume .data-table-contin tr');
            let _line = document.querySelector('.data-table-contin-line');
            let _popup_main_panel = document.getElementById("popup_job_resume");
            let _popup_main_over = document.querySelector('.overlay');
            let couner_q = 0;
            
            if (document.querySelectorAll('.data-table-contin-80').length < 8) {
                document.querySelector('.data-table-contin-button-dip').before(_line.cloneNode(true));
                for (let input of _inputsPanelOne) {
                    if (input.className == 'data-table-contin-80' || input.className == 'data-table-contin-81' || input.className == 'data-table-contin-82' || input.className == 'data-table-contin-83' || input.className == 'data-table-contin-84') {    
                        couner_q += 1;
                        if (couner_q < 6) {
                            document.querySelector('.data-table-contin-button-dip').before(input.cloneNode(true));
                            let InputClassN = '.'+input.className+' input';
                            let SelectClassN = '.'+input.className+' select';
                            let _inputsPanelOneNew = document.querySelectorAll(InputClassN);
                            let _selectPanelOneNew = document.querySelectorAll(SelectClassN);
                            let couner_n = -1;
                            for (let NewSel of _selectPanelOneNew) {
                                couner_n += 1;
                                if ( couner_n > 0 && NewSel.name == "PROPERTY[80][]") {
                                    let NewinputNameNewEdit = NewSel.name.replace('[]', '')
                                    NewSel.name = NewinputNameNewEdit + "[" + couner_n + "]";
                                }
                            }
                            let queryIMGCal = document.querySelectorAll('.'+input.className+' img');
                            let couner_d = -1;
                            for (let Newinput of _inputsPanelOneNew) {
                                couner_d += 1;
                                if (couner_d > 0) {
                                    if (Newinput.name == "PROPERTY[83][0][VALUE]" || Newinput.name == "PROPERTY[84][0][VALUE]") {
                                        let inputNameNewEdit = Newinput.name.replace('[0][VALUE]', '')
                                        let se = Newinput.name;
                                        let seachQUE = queryIMGCal[couner_d].outerHTML;
                                        Newinput.name = inputNameNewEdit + "[" + couner_d + "][VALUE]";
                                        let newstr = seachQUE.replace(se, Newinput.name);
                                        queryIMGCal[couner_d].outerHTML = newstr;
                                    } else {
                                        let inputNameNewEdit = Newinput.name.replace('[0]', '')
                                        Newinput.name = inputNameNewEdit + "[" + couner_d + "]";
                                    }
                                }
                                let nn_couner = _inputsPanelOneNew.length - couner_d;
                                if (nn_couner == 1) {
                                    Newinput.value = "";
                                }
                            }
                            if (input.className == "data-table-contin-80") {
                                let delClassN = document.querySelectorAll('.'+input.className+' .tzSelect_basic_resum_contin')
                                let delClassNOne = document.querySelectorAll('.'+input.className+' select')
                                let t = 0;
                                for (let newDelClassN of delClassN) {
                                    let newstrpar = delClassN.length - t;
                                    t += 1;
                                    if ( newstrpar == 1) {
                                        if (newDelClassN.innerHTML != "") {
                                            newDelClassN.remove();
                                            let w = 0;
                                            for (let newdelClassNOne of delClassNOne) {
                                                let newstrparS = delClassNOne.length - w;
                                                w += 1;
                                                if (newdelClassNOne.name != "PROPERTY[80][]" && newstrparS == 1) {
                                                    $(document).ready(function() {
                                                        let selectss = document.querySelectorAll('#popup_job_resume .data-table-contin select[name="'+newdelClassNOne.name+'"]');
                                                        
                                                        for (let selects of selectss) {
                                                            let select = $('select[name="'+selects.name+'"]');
                                                        
                                                            let selectBoxContainer = $('<div>', {
                                                                width: select.outerWidth(),
                                                                className: 'tzSelect_basic_resum_contin',
                                                                html: '<div class="selectBox_basic_resum_contin" id="selectBox_basic_resum_contin"></div>'
                                                            });
                                                            
                                                            let dropDown = $('<ul>', {
                                                                className: 'dropDown_basic_resum_contin'
                                                            });
                                                            
                                                            let selectBox = selectBoxContainer.find('.selectBox_basic_resum_contin');
                                                            
                                                            select.find('option').each(function(i) {
                                                                let option = $(this);
                                                                
                                                                if (i == select.attr('selectedIndex')) {
                                                                    selectBox.html(option.text());
                                                                }
                                                                
                                                                if (option.data('skip')) {
                                                                    return true;
                                                                }
                                                                
                                                                let li = $('<li>', {
                                                                    html: '<span>' +
                                                                    option.data('html-text') + '</span>'
                                                                });
                                                                
                                                                li.click(function() {
                                                                
                                                                    selectBox.html(option.text());
                                                                    dropDown.trigger('hide');
                                                                    
                                                                    for (const lit of document.querySelectorAll('li')) {
                                                                        if (lit.matches('.active')) {
                                                                            lit.classList.remove('active')
                                                                        }
                                                                    }
                                                                    
                                                                    li.addClass('active')
                                                                    select.val(option.val());
                                                                    
                                                                    return false;
                                                                });
                                                                
                                                                dropDown.append(li);
                                                            });
                                                            
                                                            selectBoxContainer.append(dropDown.hide());
                                                            select.hide().after(selectBoxContainer);
                                                            
                                                            dropDown.bind('show', function() {
                                                            
                                                                if (dropDown.is(':animated')) {
                                                                    return false;
                                                                }
                                                                
                                                                selectBox.addClass('expanded');
                                                                dropDown.slideDown();
                                                            
                                                            }).bind('hide', function() {
                                                            
                                                                if (dropDown.is(':animated')) {
                                                                    return false;
                                                                }
                                                                
                                                                selectBox.removeClass('expanded');
                                                                dropDown.slideUp();
                                                            
                                                            }).bind('toggle', function() {
                                                                if (selectBox.hasClass('expanded')) {
                                                                    dropDown.trigger('hide');
                                                                } else dropDown.trigger('show');
                                                            });
                                                            
                                                            selectBox.click(function() {
                                                                dropDown.trigger('toggle');
                                                                return false;
                                                            });
                                                            
                                                            $(document).click(function() {
                                                                dropDown.trigger('hide');
                                                            });
                                                            let newInfo = document.querySelectorAll(".data-table-contin-80 .dropDown_basic_resum_contin");
                                                            for (let newNinfo of newInfo) {
                                                                //console.log(newNinfo,newInfo)
                                                                newNinfo.style = "overflow: scroll;display:none"
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                let _popup_main_over_plus = Number(_popup_main_over.style.height.replace('%', '')) + 60;
                let _popup_main_panel_plus = _popup_main_panel.offsetHeight + 469;
                let _popup_main_panel_plus_marg = Number(_popup_main_panel.style.marginTop.replace('px', '')) + 420;
                _popup_main_panel.style.marginTop = _popup_main_panel_plus_marg + 'px';
                _popup_main_panel.style.height = _popup_main_panel_plus + 'px';
                _popup_main_over.style.height = _popup_main_over_plus + "%";
            }
        }
        
        //функция добавления сертификата
        document.getElementById('data-table-contin-button-ser-txt').onclick = function() {   
            let _inputsPanelOne = document.querySelectorAll('#popup_job_resume .data-table-contin tr');
            let _line = document.querySelector('.data-table-contin-line');
            let _popup_main_panel = document.getElementById("popup_job_resume");
            let _popup_main_over = document.querySelector('.overlay');
            let couner_q = 0;
            
            if (document.querySelectorAll('.data-table-contin-85').length < 8) {
                document.querySelector('.data-table-contin-button-ser').before(_line.cloneNode(true));
                for (let input of _inputsPanelOne) {
                    if (input.className == 'data-table-contin-85' || input.className == 'data-table-contin-86' || input.className == 'data-table-contin-87' || input.className == 'data-table-contin-88' || input.className == 'data-table-contin-89') {
                        couner_q += 1;
                        if (couner_q < 6) {
                            document.querySelector('.data-table-contin-button-ser').before(input.cloneNode(true));
                            let InputClassN = '.'+input.className+' input';
                            let SelectClassN = '.'+input.className+' select';
                            let _inputsPanelOneNew = document.querySelectorAll(InputClassN);
                            let _selectPanelOneNew = document.querySelectorAll(SelectClassN);
                            let couner_n = -1;
                            for (let NewSel of _selectPanelOneNew) {
                                couner_n += 1;
                                if ( couner_n > 0 && NewSel.name == "PROPERTY[85][]") {
                                    let NewinputNameNewEdit = NewSel.name.replace('[]', '')
                                    NewSel.name = NewinputNameNewEdit + "[" + couner_n + "]";
                                }
                            }
                            let queryIMGCal = document.querySelectorAll('.'+input.className+' img');
                            let couner_d = -1;
                            for (let Newinput of _inputsPanelOneNew) {
                                couner_d += 1;
                                if (couner_d > 0) {
                                    if (Newinput.name == "PROPERTY[88][0][VALUE]" || Newinput.name == "PROPERTY[89][0][VALUE]") {
                                        let inputNameNewEdit = Newinput.name.replace('[0][VALUE]', '')
                                        let se = Newinput.name;
                                        let seachQUE = queryIMGCal[couner_d].outerHTML;
                                        Newinput.name = inputNameNewEdit + "[" + couner_d + "][VALUE]";
                                        let newstr = seachQUE.replace(se, Newinput.name);
                                        queryIMGCal[couner_d].outerHTML = newstr;
                                    } else {
                                        let inputNameNewEdit = Newinput.name.replace('[0]', '')
                                        Newinput.name = inputNameNewEdit + "[" + couner_d + "]";
                                    }
                                    let nn_couner = _inputsPanelOneNew.length - couner_d;
                                    if (nn_couner == 1) {
                                        Newinput.value = "";
                                    }
                                }
                            }
                            if (input.className == "data-table-contin-85") {
                                let delClassN = document.querySelectorAll('.'+input.className+' .tzSelect_basic_resum_contin')
                                let delClassNOne = document.querySelectorAll('.'+input.className+' select')
                                let t = 0;
                                for (let newDelClassN of delClassN) {
                                    let newstrpar = delClassN.length - t;
                                    t += 1;
                                    if ( newstrpar == 1) {
                                        if (newDelClassN.innerHTML != "") {
                                            newDelClassN.remove();
                                            let w = 0;
                                            for (let newdelClassNOne of delClassNOne) {
                                                let newstrparS = delClassNOne.length - w;
                                                w += 1;
                                                if (newdelClassNOne.name != "PROPERTY[85][]" && newstrparS == 1) {
                                                    $(document).ready(function() {
                                                        let selectss = document.querySelectorAll('#popup_job_resume .data-table-contin select[name="'+newdelClassNOne.name+'"]');
                                                        
                                                        for (let selects of selectss) {
                                                            let select = $('select[name="'+selects.name+'"]');
                                                        
                                                            let selectBoxContainer = $('<div>', {
                                                                width: select.outerWidth(),
                                                                className: 'tzSelect_basic_resum_contin',
                                                                html: '<div class="selectBox_basic_resum_contin" id="selectBox_basic_resum_contin"></div>'
                                                            });
                                                            
                                                            let dropDown = $('<ul>', {
                                                                className: 'dropDown_basic_resum_contin'
                                                            });
                                                            
                                                            let selectBox = selectBoxContainer.find('.selectBox_basic_resum_contin');
                                                            
                                                            select.find('option').each(function(i) {
                                                                let option = $(this);
                                                                
                                                                if (i == select.attr('selectedIndex')) {
                                                                    selectBox.html(option.text());
                                                                }
                                                                
                                                                if (option.data('skip')) {
                                                                    return true;
                                                                }
                                                                
                                                                let li = $('<li>', {
                                                                    html: '<span>' +
                                                                    option.data('html-text') + '</span>'
                                                                });
                                                                
                                                                li.click(function() {
                                                                
                                                                    selectBox.html(option.text());
                                                                    dropDown.trigger('hide');
                                                                    
                                                                    for (const lit of document.querySelectorAll('li')) {
                                                                        if (lit.matches('.active')) {
                                                                            lit.classList.remove('active')
                                                                        }
                                                                    }
                                                                    
                                                                    li.addClass('active')
                                                                    select.val(option.val());
                                                                    
                                                                    return false;
                                                                });
                                                                
                                                                dropDown.append(li);
                                                            });
                                                            
                                                            selectBoxContainer.append(dropDown.hide());
                                                            select.hide().after(selectBoxContainer);
                                                            
                                                            dropDown.bind('show', function() {
                                                            
                                                                if (dropDown.is(':animated')) {
                                                                    return false;
                                                                }
                                                                
                                                                selectBox.addClass('expanded');
                                                                dropDown.slideDown();
                                                            
                                                            }).bind('hide', function() {
                                                            
                                                                if (dropDown.is(':animated')) {
                                                                    return false;
                                                                }
                                                                
                                                                selectBox.removeClass('expanded');
                                                                dropDown.slideUp();
                                                            
                                                            }).bind('toggle', function() {
                                                                if (selectBox.hasClass('expanded')) {
                                                                    dropDown.trigger('hide');
                                                                } else dropDown.trigger('show');
                                                            });
                                                            
                                                            selectBox.click(function() {
                                                                dropDown.trigger('toggle');
                                                                return false;
                                                            });
                                                            
                                                            $(document).click(function() {
                                                                dropDown.trigger('hide');
                                                            });
                                                            let newInfo = document.querySelectorAll(".data-table-contin-85 .dropDown_basic_resum_contin");
                                                            for (let newNinfo of newInfo) {
                                                                //console.log(newNinfo,newInfo)
                                                                newNinfo.style = "overflow: scroll;display:none"
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                let _popup_main_over_plus = Number(_popup_main_over.style.height.replace('%', '')) + 60;
                let _popup_main_panel_plus = _popup_main_panel.offsetHeight + 469;
                let _popup_main_panel_plus_marg = Number(_popup_main_panel.style.marginTop.replace('px', '')) + 420;
                _popup_main_panel.style.marginTop = _popup_main_panel_plus_marg + 'px';
                _popup_main_panel.style.height = _popup_main_panel_plus + 'px';
                _popup_main_over.style.height = _popup_main_over_plus + "%";
            }
        }
        
        //функция добавления опыта работы
        document.getElementById('data-table-contin-button-opt-txt').onclick = function() {   
            let _inputsPanelOne = document.querySelectorAll('#popup_job_resume .data-table-contin tr');
            let _line = document.querySelector('.data-table-contin-line');
            let _popup_main_panel = document.getElementById("popup_job_resume");
            let _popup_main_over = document.querySelector('.overlay');
            let couner_q = 0;
            
            if (document.querySelectorAll('.data-table-contin-91').length < 8) {
                document.querySelector('.data-table-contin-button-opt').before(_line.cloneNode(true));
                for (let input of _inputsPanelOne) {
                    if (input.className == 'data-table-contin-91' || input.className == 'data-table-contin-92' || input.className == 'data-table-contin-93' || input.className == 'data-table-contin-94' || input.className == 'data-table-contin-95'
                    || input.className == 'data-table-contin-96' || input.className == 'data-table-contin-97' || input.className == 'data-table-contin-98' || input.className == 'data-table-contin-99' || input.className == 'data-table-contin-100' || input.className == 'data-table-contin-101') {
                        couner_q += 1;
                        if ( couner_q < 12) {
                            document.querySelector('.data-table-contin-button-opt').before(input.cloneNode(true));
                            let InputClassN = '.'+input.className+' input';
                            let SelectClassN = '.'+input.className+' select';
                            let _inputsPanelOneNew = document.querySelectorAll(InputClassN);
                            let _selectPanelOneNew = document.querySelectorAll(SelectClassN);
                            let couner_n = -1;
                            for (let NewSel of _selectPanelOneNew) {
                                couner_n += 1;
                                if ( couner_n > 0 && NewSel.name == "PROPERTY[91][]") {
                                    let NewinputNameNewEdit = NewSel.name.replace('[]', '')
                                    NewSel.name = NewinputNameNewEdit + "[" + couner_n + "]";
                                }
                            }
                            let queryIMGCal = document.querySelectorAll('.'+input.className+' img');
                            let couner_d = -1;
                            for (let Newinput of _inputsPanelOneNew) {
                                couner_d += 1;
                                if (couner_d > 0) {
                                    if (Newinput.name == "PROPERTY[100][0][VALUE]" || Newinput.name == "PROPERTY[101][0][VALUE]") {
                                        let inputNameNewEdit = Newinput.name.replace('[0][VALUE]', '')
                                        let se = Newinput.name;
                                        let seachQUE = queryIMGCal[couner_d].outerHTML;
                                        Newinput.name = inputNameNewEdit + "[" + couner_d + "][VALUE]";
                                        let newstr = seachQUE.replace(se, Newinput.name);
                                        queryIMGCal[couner_d].outerHTML = newstr;
                                    } else {
                                        let inputNameNewEdit = Newinput.name.replace('[0]', '')
                                        Newinput.name = inputNameNewEdit + "[" + couner_d + "]";
                                    }
                                    let nn_couner = _inputsPanelOneNew.length - couner_d;
                                    if (nn_couner == 1) {
                                        Newinput.value = "";
                                    }
                                }
                            }
                            if (input.className == "data-table-contin-91") {
                                let delClassN = document.querySelectorAll('.'+input.className+' .tzSelect_basic_resum_contin')
                                let delClassNOne = document.querySelectorAll('.'+input.className+' select')
                                let t = 0;
                                for (let newDelClassN of delClassN) {
                                    let newstrpar = delClassN.length - t;
                                    t += 1;
                                    if ( newstrpar == 1) {
                                        if (newDelClassN.innerHTML != "") {
                                            newDelClassN.remove();
                                            let w = 0;
                                            //console.log(w,newstrparS)
                                            for (let newdelClassNOne of delClassNOne) {
                                                let newstrparS = delClassNOne.length - w;
                                                w += 1;
                                                if (newdelClassNOne.name != "PROPERTY[91][]" && newstrparS == 1) {
                                                    //console.log(newstrparS)
                                                    $(document).ready(function() {
                                                        let selectss = document.querySelectorAll('#popup_job_resume .data-table-contin select[name="'+newdelClassNOne.name+'"]');
                                                        //console.log(selectss)
                                                        let z = 0;
                                                        for (let selects of selectss) {
                                                            let newstrparSsS = selectss.length - z;
                                                            z += 1;
                                                            if (newstrparSsS == 1) {
                                                            let select = $('select[name="'+selects.name+'"]');
                                                        
                                                            let selectBoxContainer = $('<div>', {
                                                                width: select.outerWidth(),
                                                                className: 'tzSelect_basic_resum_contin',
                                                                html: '<div class="selectBox_basic_resum_contin" id="selectBox_basic_resum_contin"></div>'
                                                            });
                                                            
                                                            let dropDown = $('<ul>', {
                                                                className: 'dropDown_basic_resum_contin'
                                                            });
                                                            
                                                            let selectBox = selectBoxContainer.find('.selectBox_basic_resum_contin');
                                                            
                                                            select.find('option').each(function(i) {
                                                                let option = $(this);
                                                                
                                                                if (i == select.attr('selectedIndex')) {
                                                                    selectBox.html(option.text());
                                                                }
                                                                
                                                                if (option.data('skip')) {
                                                                    return true;
                                                                }
                                                                
                                                                let li = $('<li>', {
                                                                    html: '<span>' +
                                                                    option.data('html-text') + '</span>'
                                                                });
                                                                
                                                                li.click(function() {
                                                                
                                                                    selectBox.html(option.text());
                                                                    dropDown.trigger('hide');
                                                                    
                                                                    for (const lit of document.querySelectorAll('li')) {
                                                                        if (lit.matches('.active')) {
                                                                            lit.classList.remove('active')
                                                                        }
                                                                    }
                                                                    
                                                                    li.addClass('active')
                                                                    select.val(option.val());
                                                                    
                                                                    return false;
                                                                });
                                                                
                                                                dropDown.append(li);
                                                            });
                                                            
                                                            selectBoxContainer.append(dropDown.hide());
                                                            select.hide().after(selectBoxContainer);
                                                            
                                                            dropDown.bind('show', function() {
                                                            
                                                                if (dropDown.is(':animated')) {
                                                                    return false;
                                                                }
                                                                
                                                                selectBox.addClass('expanded');
                                                                dropDown.slideDown();
                                                            
                                                            }).bind('hide', function() {
                                                            
                                                                if (dropDown.is(':animated')) {
                                                                    return false;
                                                                }
                                                                
                                                                selectBox.removeClass('expanded');
                                                                dropDown.slideUp();
                                                            
                                                            }).bind('toggle', function() {
                                                                if (selectBox.hasClass('expanded')) {
                                                                    dropDown.trigger('hide');
                                                                } else dropDown.trigger('show');
                                                            });
                                                            
                                                            selectBox.click(function() {
                                                                dropDown.trigger('toggle');
                                                                return false;
                                                            });
                                                            
                                                            $(document).click(function() {
                                                                dropDown.trigger('hide');
                                                            });
                                                            let newInfo = document.querySelectorAll(".data-table-contin-91 .dropDown_basic_resum_contin");
                                                            for (let newNinfo of newInfo) {
                                                                newNinfo.style = "overflow: scroll;display:none"
                                                            }
                                                        }
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                let _popup_main_over_plus = Number(_popup_main_over.style.height.replace('%', '')) + 80;
                let _popup_main_panel_plus = _popup_main_panel.offsetHeight + 760;
                let _popup_main_panel_plus_marg = Number(_popup_main_panel.style.marginTop.replace('px', '')) + 740;
                _popup_main_panel.style.marginTop = _popup_main_panel_plus_marg + 'px';
                _popup_main_panel.style.height = _popup_main_panel_plus + 'px';
                _popup_main_over.style.height = _popup_main_over_plus + "%";
            }
        }
	</script>
<?}?>
	<br/>
	<?if ($arParams["LIST_URL"] <> ''):?><a href="<?=$arParams["LIST_URL"]?>"><?=GetMessage("IBLOCK_FORM_BACK")?></a><?endif?>
</form>