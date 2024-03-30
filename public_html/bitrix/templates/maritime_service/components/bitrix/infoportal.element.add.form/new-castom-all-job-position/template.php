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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>

<?if (!empty($arResult["ERRORS"])):?>
	<?=ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif?>

<?
if ($arResult["MESSAGE"] <> ''):?>
    <script>
	    popup_show_job_position("infoAdministrator");
	    document.getElementById("for-form-vac-1").reset();
    </script>
<?endif?>

<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" id="for-form-vac-1" enctype="multipart/form-data">

	<?=bitrix_sessid_post()?>

	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>

	<table class="data-table">
	    <div class="data-table-title-position">
				<div class="data-table-title-position-name">Подать вакансию</div>
		</div>
		<thead>
			<tr>
				<td class="data-table-name2" colspan="2">&nbsp;</td>
			</tr>
		</thead>
		<? $nameProp = 1;
		if (!empty($arResult["PROPERTY_LIST"]) && is_array($arResult["PROPERTY_LIST"])):?>
		<tbody>
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
				<tr class="info_<?=$nameProp++?>"<?if($propertyID == "NAME"){?>style="display:none" <?}?>>
				    <?if($propertyID == "55") {?><td id="title-cont-name">Контактная информация</td><?}?>
					<td class="property_<?=$nameProp++?>"><?if($propertyID == "NAME"){} else { if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?><?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?><?endif?> <?}?> </td>
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
								$APPLICATION->IncludeComponent(
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
								
						<textarea
						<?if($propertyID == 21){?> id="input_value_optional_overview" placeholder="*обязательное поле" <?}?>
						<?if( $propertyID == 16 && $i == 0 ){?> id="salary_ot" placeholder="от" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="15" <?}?>
						<?if( $propertyID == 16 && $i == 1 ){?>id="salary_do"placeholder="до" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="15" <?}?> 
						cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea>
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
								
								<input type="text"
								<?if( $propertyID == 55 ){?>maxlength="63" <?}?>
								<?if($propertyID == 52 || $propertyID == 21 || $propertyID == 22 || $propertyID == 24){?> placeholder="*обязательное поле" <?}?>
								<?if($propertyID == 24){?> id="input_value_optional_email_corp" <?}?>
								<?if($propertyID == 22){?> id="input_value_optional_contacts_face" <?}?>
								<?if($propertyID == 23){?> placeholder="*обязательное поле" id="input_value_optional_number_phone" onkeypress='valid_for_number()' maxlength="12" <?}?>
								<?if($propertyID == 17){?> placeholder="дд.мм.гггг" <?}?>
								<?if($propertyID == "NAME"){?> id="input-title-position" style="display:none" <?}?>
								
								name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=$value?>" /><br /><?
								if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?><?
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'new-castom-calendar',
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
									
									<?if($propertyID == "51"){?>
            							<script>
            							    $(document).ready(function() {
            
                                                // Элемент select, который будет замещаться:
                                                var select = $('select.select_val_old');
                                                //contin this
                                                //var select_two = $('select.selectOld_two');
                                                
                                                var selectBoxContainer = $('<div>', {
                                                    width: select.outerWidth(),
                                                    className: 'tzSelect_val_old',
                                                    html: '<div class="selectBox_val_old"></div>'
                                                });
                                                
                                                var dropDown = $('<ul>', {
                                                    className: 'dropDown_val_old'
                                                });
                                                
                                                var selectBox = selectBoxContainer.find('.selectBox_val_old');
                                                
                                                // Цикл по оригинальному элементу select
                                                
                                                select.find('option').each(function(i) {
                                                var option = $(this);
                                                
                                                if (i == select.attr('selectedIndex')) {
                                                    selectBox.html(option.text());
                                                }
                                                
                                                // Так как используется jQuery 1.4.3, то мы можем получить доступ 
                                                // к атрибутам данных HTML5 с помощью метода data().
                                                
                                                if (option.data('skip')) {
                                                    return true;
                                                }
                                                
                                                // Создаем выпадающий пункт в соответствии
                                                // с иконкой данных и атрибутами HTML5 данных:
                                                
                                                var li = $('<li>', {
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
                                                    
                                                    // Когда происходит событие click, мы также отражаем
                                                    // изменения в оригинальном элементе select:
                                                    select.val(option.val());
                                                    
                                                    return false;
                                                });
                                                
                                                dropDown.append(li);
                                                });
                                                
                                                selectBoxContainer.append(dropDown.hide());
                                                select.hide().after(selectBoxContainer);
                                                
                                                // Привязываем пользовательские события show и hide к элементу dropDown:
                                                
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
                                                
                                                // Если нажать кнопку мыши где-нибудь на странице при открытом элементе dropDown,
                                                // он будет спрятан:
                                                
                                                $(document).click(function() {
                                                    dropDown.trigger('hide');
                                                });
                                            });
            							    
            							</script>
									<?}?>
							<select 
							<?if($propertyID == "19"){?> class="selectOld" <?}?>
							<?if($propertyID == "18"){?> class="selectOld_two" <?}?>
							<?if($propertyID == "15"){?> class="input-tx-position" id="input-tx-position"<?}?>
							<?if($propertyID == "51"){?> class="select_val_old"<?}?>
							name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
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
								<option <?if($propertyID == "19" || $propertyID == "18" || $propertyID == "15" || $propertyID == "51"){?> data-html-text="<?=$arEnum["VALUE"]?>" class="select_option"<?}?> value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
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
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired">*</span>:</td>
					<td><input type="text" name="captcha_word" maxlength="50" value=""/></td>
				</tr>
			<?endif?>
		</tbody>
		<?endif?>
		<tfoot>
			<tr>
				<td colspan="2">
				    <div class="position-politics">
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
                    </div>
					<input id="button" data-popup="infoAdministrator" type="submit" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" />
					<span class="submit-title-name">Срок публикации вакансии — один месяц</span>
					
					<style>
                        ::placeholder {
                            color: rgba(51, 51, 51, 0.50);
                            font-family: Montserrat;
                            font-size: 16px;
                            font-style: normal;
                            font-weight: 400;
                            line-height: normal;
                            letter-spacing: 0.32px;
                        }
                        
                        ::-ms-input-placeholder { /* Edge 12-18 */
                            color: rgba(51, 51, 51, 0.50);
                            font-family: Montserrat;
                            font-size: 16px;
                            font-style: normal;
                            font-weight: 400;
                            line-height: normal;
                            letter-spacing: 0.32px;
                        }
                    </style>
					<script>
					    let inputs_for = document.getElementsByTagName('input');
                        for (let input of inputs_for) {
                            if (input.matches('.mli-field')) {
                                input.onkeypress = 'valid_for_city()'
                                if(input.value == "") {
                                    input.placeholder = 'начните вводить город';
                                } 
                            }
                            if (input.matches('input[name="PROPERTY[17][0][VALUE]"]')){
                                input.onkeypress = 'valid_for_number()'
                                if(input.value == ""){
                                    input.placeholder = 'дд.мм.гггг'
                                } 
                            }
                        }
					
						document.getElementById('button').onclick = function() {
						    
                            let inputs = document.getElementsByTagName('input');
                            for (let input of inputs) {
                                if (input.matches('#input_value_optional_number_phone') || input.matches('.info_11 .mli-field ') || input.matches('#input_value_optional_contacts_face') 
                                || input.matches('#input_value_optional_email_corp') || input.matches('#input_value_optional_overview') || input.matches('input[name="PROPERTY[17][0][VALUE]"]')){
                                    if(input.value == "" || input.value == "введите текст"){
                                        input.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                                        input.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                                        event.preventDefault();
                                    } else {
                                        input.style.boxShadow = "none"
                                        input.style.border = "1px solid" 
                                    }
                                }    
                            }
                                
                            let textarea = document.getElementsByTagName('textarea');
                            for (let textareas of textarea) {
                                if (textareas.matches('#salary_ot') || textareas.matches('#salary_do') || textareas.matches('#input_value_optional_overview')){
                                    if(textareas.value == ""){
                                        textareas.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                                        textareas.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                                        event.preventDefault();
                                    } else {
                                        textareas.style.boxShadow = "none"
                                        textareas.style.border = "1px solid" 
                                    }
                                }    
                            }
                            
                            //Проверяем соглашения с политикой
                            const checkbox = document.getElementById('input_popup_politics');
                            if (checkbox.checked) {
                                checkbox.style.boxShadow = "none"
                                checkbox.style.border = "1px solid" 
                            } else {
                                checkbox.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)";
                                checkbox.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                                event.preventDefault();
                            }
                                
						    if (document.getElementById('input_value_optional_number_phone').value == "" || document.getElementById('input_value_optional_contacts_face').value == "" 
						    || document.getElementById('input_value_optional_email_corp').value == "" || document.getElementById('input_value_optional_overview').value == "" 
						    || document.getElementById('salary_ot').value == "" || document.getElementById('salary_do').value == ""){
                                alert("Перед подачей ваканчии, убедитесь, что вы правильно заполнили все поля анкеты");
						    } else {
    						    var valueOptional = $('.input-tx-position option:selected').text();
                                document.getElementById('input-title-position').value = valueOptional;
						    }
                        }
                        
                        function valid_for_number(){
                            if (event.keyCode != 43 && event.keyCode < 48 || event.keyCode > 57)
                            event.preventDefault();
                        }
                        
                        function valid_for_city(){
                            evt = evt || window.event;
                              var charCode = evt.keyCode || evt.which;
                              var charStr = String.fromCharCode(charCode);
                              return /^[a-zA-Z\s]*$/.test(charStr) || charCode == 8;
                        }
                        
                        $(document).ready(function() {
                            var select = $('select.input-tx-position');
                            
                            var selectBoxContainer = $('<div>', {
                                width: select.outerWidth(),
                                className: 'tzSelect_basic',
                                html: '<div class="selectBox_basic" id="selectBox_basic"></div>'
                            });
                            
                            
                            var dropDown = $('<ul>', {
                                className: 'dropDown_basic'
                            });
                            
                            var selectBox = selectBoxContainer.find('.selectBox_basic');
                            
                            select.find('option').each(function(i) {
                            var option = $(this);
                            
                            if (i == select.attr('selectedIndex')) {
                                selectBox.html(option.text());
                            }
                            
                            if (option.data('skip')) {
                                return true;
                            }
                            
                            var li = $('<li>', {
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
                            
                        });
                        
                        $(document).ready(function() {
                            var select = $('select.selectOld_two');
                            
                            var selectBoxContainer = $('<div>', {
                                width: select.outerWidth(),
                                className: 'tzSelect',
                                html: '<div class="selectBox"></div>'
                            });
                            
                            var dropDown = $('<ul>', {
                                className: 'dropDown'
                            });
                            
                            var selectBox = selectBoxContainer.find('.selectBox');
                            
                            select.find('option').each(function(i) {
                            var option = $(this);
                            
                            if (i == select.attr('selectedIndex')) {
                                selectBox.html(option.text());
                            }
                            
                            if (option.data('skip')) {
                                return true;
                            }
                            
                            var li = $('<li>', {
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
                        });
                        
                        $(document).ready(function() {
                            var select = $('select.selectOld');
                            
                            var selectBoxContainer = $('<div>', {
                                width: select.outerWidth(),
                                className: 'tzSelect',
                                html: '<div class="selectBox"></div>'
                            });
                            
                            var dropDown = $('<ul>', {
                                className: 'dropDown'
                            });
                            
                            var selectBox = selectBoxContainer.find('.selectBox');
                            
                            select.find('option').each(function(i) {
                            var option = $(this);
                            
                            if (i == select.attr('selectedIndex')) {
                                selectBox.html(option.text());
                            }
                            
                            if (option.data('skip')) {
                                return true;
                            }
                            
                            var li = $('<li>', {
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
                        });

                    </script>
					<?if ($arParams["LIST_URL"] <> '' && $arParams["ID"] > 0):?><input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" /><?endif?>
					<?/*<input type="reset" value="<?=GetMessage("IBLOCK_FORM_RESET")?>" />*/?>
				</td>
			</tr>
		</tfoot>
	</table>
	<br />
	<?if ($arParams["LIST_URL"] <> ''):?><a href="<?=$arParams["LIST_URL"]?>"><?=GetMessage("IBLOCK_FORM_BACK")?></a><?endif?>
</form>