<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?
//echo "<pre>Template arParams: "; print_r($arParams); echo "</pre>";
//echo "<pre>Template arResult: "; print_r($arResult); echo "</pre>";
//exit();
?>

<?if (!empty($arResult["ERRORS"])):?>
	<?=ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif?>
<?if ($arResult["MESSAGE"] <> ''):?>
	<?//=ShowNote($arResult["MESSAGE"])?>
    <script>
        document.getElementById("for-form-vac-3").reset();        
    	popup_show_job_position("infoAdministrator");
	</script>
<?endif?>
<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" id="for-form-vac-3" method="post" enctype="multipart/form-data">

	<?=bitrix_sessid_post()?>

	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
    <div class="data-table-bord-title">Разместить объявление</div>
	<table class="data-table">
		<!--<thead>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		</thead>-->
		<?if (!empty($arResult["PROPERTY_LIST"]) && is_array($arResult["PROPERTY_LIST"])):?>
		<tbody>
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
			    <?if ($propertyID == "58") {?> <tr class="data-table-location-info"> <?} else if ($propertyID =="59") {?> <tr class="data-table-email-info"> <?} else {?>
				<tr><?}?>
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
								
								<?if ($propertyID == 60 || $propertyID == 59 || $propertyID == 61 || $propertyID == 'NAME' || $propertyID == 58) {?> placeholder="*обязательное поле" <?}?>
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
							<select name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
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
								<option data-html-text="<?=$arEnum["VALUE"]?>" value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
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
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired"></span>:</td>
					<td><input type="text" name="captcha_word" maxlength="50" value=""/></td>
				</tr>
			<?endif?>
		</tbody>
		<?endif?>

        <td colspan="1">
    	    <div class="table-block-privat" id="table-block-privat">
    		    <div class="table-block-privat-title" id="table-block-privat-title">Правила размещения объявления</div>
    		    <div class="table-block-privat-all" id="table-block-privat-all">
                    <a class="table-block-privat-all-in">Запрещено добавлять объявления</a></br>
                    <a class="table-block-privat-all-in-tw"> — не относящиеся к морской тематике;</br>
                        — в несоответствующей категории;</br>
                        — одинаковые и очень похожие объявления за день;</br>
                        — содержащие ненормативную лексику;</br>
                        — содержащие преимущественно заглавные буквы;</br>
                        — содержащие более 500 символов.</br></br></br></br>
                    </a>
                    <a class="table-block-privat-all-in-end">Объявления, размещённые с нарушениями, будут удалены, авторы блокироваться.</a>
                </div>
    		</div>
        </td>
        <td colspan="1">
            <div class="table-bord-politics">
    		    <?$APPLICATION->IncludeComponent(
                	"bitrix:main.userconsent.request",
                	"new-castom-user-checxbox-for-bord",
                    	Array(
                    		"AUTO_SAVE" => "Y",
                    		"ID" => "4",
                    		"IS_CHECKED" => "N",
                    		"IS_LOADED" => "N"
                    	)
                );?>
            </div>
        </td>
		<tfoot>
			<tr>
				<td colspan="2">
					<input type="submit" id="button-bord" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" />
					<?if ($arParams["LIST_URL"] <> '' && $arParams["ID"] > 0):?><input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" /><?endif?>
					<?/*<input type="reset" value="<?=GetMessage("IBLOCK_FORM_RESET")?>" />*/?>
				</td>
			</tr>
		</tfoot>
	</table>
	<script>
        // placeholder добавляется в выбор города
        let _inputs_place = document.querySelector('#popup_job_bord .mli-layout input.mli-field');
        if (_inputs_place.value == "") {
            _inputs_place.placeholder = 'начните вводить город';
        } 
            
	
	    // функция отслеживания клика для изменения подтверждения политики и раскрытие блока с правилами 
        $(document).ready(function() {
            let popup_b = document.getElementById('popup_job_bord');
            let up_popup_b = document.getElementById('table-block-privat');
            let up_popup_b_checkBox = document.querySelector('#popup_job_bord #input_popup_politics');
            $('#popup_job_bord #input_popup_politics').live('click', function() {
                  $('#popup_job_bord #input_popup_politics').addClass("active");
            });
            
            $('#popup_job_bord .input_popup_politics.active').live('click', function() {
                  $('#popup_job_bord #input_popup_politics').removeClass("active");
            });
            
    	    $('.table-block-privat-title').live('click', function() {
    	        $('#table-block-privat-all').addClass("active");
    	        up_popup_b.style = "height:337px";
    	        popup_b.style = "height:1190px";
    	        $('#table-block-privat-title').addClass("active");
            });
            
            $('.table-block-privat-title.active').live('click', function() {
    	        $('#table-block-privat-all').removeClass("active");
    	        up_popup_b.style = "height:59px";
    	        popup_b.style = "height:918px";
    	        $('#table-block-privat-title').removeClass("active");
            });
        });
        
        // проверка заполнения полей
        document.getElementById('button-bord').onclick = function() {
            let inputs = document.querySelectorAll('#popup_job_bord input');
            for (let input of inputs) {
                if (input.value == "" || input.value == "введите текст") {
                    input.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                    input.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                    event.preventDefault();
                } else {
                    input.style.boxShadow = "none"
                    input.style.border = "1px solid" 
                }
            }
            
            let textArBord = document.querySelector('#popup_job_bord textarea')
                if (textArBord.value == "" || textArBord.value == "введите текст") {
                    textArBord.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                    textArBord.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                    event.preventDefault();
                } else {
                    textArBord.style.boxShadow = "none"
                    textArBord.style.border = "1px solid" 
                }
            
            let __check = document.querySelector('#popup_job_bord #input_popup_politics');
                if ( __check.checked == false ) {
                    __check.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)"
                    __check.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                    event.preventDefault();
                } else {
                    __check.style.boxShadow = "none"
                    __check.style.border = "1px solid" 
                }
        }
        
        // изменение стандартой панели списка select
        $(document).ready(function() {
            let select = $('select[name="PROPERTY[57]"]');
            
            let selectBoxContainer = $('<div>', {
                width: select.outerWidth(),
                className: 'tzSelect_basic_bord',
                html: '<div class="selectBox_basic_bord" id="selectBox_basic_bord"></div>'
            });
            
            
            let dropDown = $('<ul>', {
                className: 'dropDown_basic_bord'
            });
            
            let selectBox = selectBoxContainer.find('.selectBox_basic_bord');
            
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
            
        });
	</script>
	<br/>
	<?if ($arParams["LIST_URL"] <> ''):?><a href="<?=$arParams["LIST_URL"]?>"><?=GetMessage("IBLOCK_FORM_BACK")?></a><?endif?>
</form>