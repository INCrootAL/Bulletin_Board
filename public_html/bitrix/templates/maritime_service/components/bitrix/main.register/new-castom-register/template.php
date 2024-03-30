<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<div class="bx-auth-reg">

<?if($USER->IsAuthorized()):?>

<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

<?else:?>
<?
if (!empty($arResult["ERRORS"])):
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));

elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<p class="bx-auth-reg-title-name"><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?endif?>

<?if($arResult["SHOW_SMS_FIELD"] == true):?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform">
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>
<input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
<table>
	<tbody>
		<tr>
			<td><?echo GetMessage("main_register_sms")?></span></td>
			<td><input size="30" type="text" name="SMS_CODE" value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off" /></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td><input type="submit" name="code_submit_button" value="<?echo GetMessage("main_register_sms_send")?>" /></td>
		</tr>
	</tfoot>
</table>
</form>

<script>
new BX.PhoneAuth({
	containerId: 'bx_register_resend',
	errorContainerId: 'bx_register_error',
	interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
	data:
		<?=CUtil::PhpToJSObject([
			'signedData' => $arResult["SIGNED_DATA"],
		])?>,
	onError:
		function(response)
		{
			var errorDiv = BX('bx_register_error');
			var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
			errorNode.innerHTML = '';
			for(var i = 0; i < response.errors.length; i++)
			{
				errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
			}
			errorDiv.style.display = '';
		}
});
</script>

<div id="bx_register_error" style="display:none"><?ShowError("error")?></div>

<div id="bx_register_resend"></div>

<?else:?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>

<table>
	<thead>
		<tr>
		</tr>
	</thead>
	<tbody>
<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
	<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
		<tr>
			<td><?echo GetMessage("main_profile_time_zones_auto")?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><?endif?></td>
			<td>
				<select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
					<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
					<option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
					<option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?echo GetMessage("main_profile_time_zones_zones")?></td>
			<td>
				<select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"'?>>
		<?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
					<option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
		<?endforeach?>
				</select>
			</td>
		</tr>
	<?else:?>
		<tr>
			<td><?=GetMessage("REGISTER_FIELD_".$FIELD)?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><?endif?></td>
			<td><?
	switch ($FIELD)
	{
		case "PASSWORD":
			?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" id="bx-auth-reg-input" class="bx-auth-input" />
			<span class="bx-btn-show-reg-password" id="eye_dop" title="Показать пароль" data-title-show="Показать пароль" data-title-hide="Скрыть пароль"></span>
<?if($arResult["SECURE_AUTH"]):?>
				<!--<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>-->
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
<script type="text/javascript">
//document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>
<?endif?>
<?
			break;
		case "CONFIRM_PASSWORD":
			?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" id="bx-auth-reg-input-dop" class="bx-auth-reg-input-dop" />
			<span class="bx-btn-show-reg-password-dop" id="eye_new_dop" title="Показать пароль" data-title-show="Показать пароль" data-title-hide="Скрыть пароль"></span><?
			break;

		case "PERSONAL_GENDER":
			?><select name="REGISTER[<?=$FIELD?>]">
				<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
				<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
				<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
			</select><?
			break;

		case "PERSONAL_COUNTRY":
		case "WORK_COUNTRY":
			?><select name="REGISTER[<?=$FIELD?>]"><?
			foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
			{
				?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
			<?
			}
			?></select><?
			break;

		case "PERSONAL_PHOTO":
		case "WORK_LOGO":
			?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" /><?
			break;

		case "PERSONAL_NOTES":
		case "WORK_NOTES":
			?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea><?
			break;
		default:
			if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
			?><input 
			<?if($FIELD == 'LOGIN'){?> id="input_login_reg" <?}?>
			<?if($FIELD == 'EMAIL'){?> id="input_email_reg" <?}?>
			size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
				if ($FIELD == "PERSONAL_BIRTHDAY")
					$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'',
						array(
							'SHOW_INPUT' => 'N',
							'FORM_NAME' => 'regform',
							'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
							'SHOW_TIME' => 'N'
						),
						null,
						array("HIDE_ICONS"=>"Y")
					);
				?><?
	}?></td>
		</tr>
	<?endif?>
<?endforeach?>
<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
	<!--<tr><td colspan="2"><?=trim($arParams["USER_PROPERTY_NAME"]) <> '' ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></td></tr>-->
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
	<tr><!--<td><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><?endif;?></td>--><td>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				$arUserField["USER_TYPE"]["USER_TYPE_ID"],
				array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
	<?endforeach;?>
<?endif;?>
<?// ******************** /User properties ***************************************************?>
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
    	<style>
            ::placeholder {
                position: absolute;
                left: 23px;
                bottom: 17px;
                color: #333;
                font-family: sans-serif;
                font-size: 16px;
                font-style: normal;
                font-weight: 400;
                line-height: normal;
                letter-spacing: 0.32px;
            }
            
            ::-ms-input-placeholder { /* Edge 12-18 */
                position: absolute;
                left: 23px;
                bottom: 17px;
                color: #333;
                font-family: sans-serif;
                font-size: 16px;
                font-style: normal;
                font-weight: 400;
                line-height: normal;
                letter-spacing: 0.32px;
            }
        </style>
		<td class="captcha_word_inst_name"><?=GetMessage("REGISTER_CAPTCHA_PROMT")?></td>
		<tr class="captcha_word_inst">
			<td></td>
			<td><input type="text" id="input_captcha_word_inst" name="captcha_word" maxlength="50" value="" autocomplete="off" /></td>
			<td>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</td>
			
		</tr>
	<?
}
/* !CAPTCHA */
?>
	</tbody>
	
	<tfoot>
		<tr>
			<td>
            </td>
		</tr>
	</tfoot>
	
	<tfoot>
	    <tr>
	        <td>
                	<?$APPLICATION->IncludeComponent(
                	"bitrix:main.userconsent.request",
                	"new-castom-user-checxbox",
                	Array(
                		"AUTO_SAVE" => "Y",
                		"ID" => "2",
                		"IS_CHECKED" => "N",
                		"IS_LOADED" => "N"
                	)
                    );?>
                </td>
                <td>
                    <?$APPLICATION->IncludeComponent(
                	"bitrix:main.userconsent.request",
                	"new-castom-user-checxbox",
                	Array(
                		"AUTO_SAVE" => "Y",
                		"ID" => "1",
                		"IS_CHECKED" => "N",
                		"IS_LOADED" => "N"
                	)
                    );?>
                </td>
            </td>
        </tr>
    </tfoot>
	
	<tfoot>
		<tr>
			<td></td>
			<td><input id="button" type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
			<a class="auth has_popup" onclick="popup_show(this);" data-popup="auth">Вход</a>
			</td>
		</tr>
	</tfoot>
</table>
</form>

<!--<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>-->

<?endif //$arResult["SHOW_SMS_FIELD"] == true ?>

<!--<p><span class="starrequired">*</span><?//=GetMessage("AUTH_REQ")?></p>-->

<?endif?>
<script>

document.getElementById('button').onclick = function() {
	
	//Проверяем обязательные поля					    
    let inputs = document.getElementsByTagName('input');
    for (let input of inputs) {
        if (input.matches('#input_login_reg') || input.matches('#input_email_reg') || input.matches('#input_captcha_word_inst') 
        || input.matches('#bx-auth-reg-input-dop') || input.matches('#bx-auth-reg-input')) {
            if(input.value == "" || input.value == "введите текст") {
                input.style.filter = "drop-shadow(0px 2px 9px rgba(205, 21, 21, 0.28))"
                input.style.border = "1px solid rgba(205, 21, 21, 0.78)"
                event.preventDefault();
            } else {
                input.style.filter = "none"
                input.style.border = "1px solid" 
            }
        }
    }
    
    //Проверяем соглашения с политикой
    const checkbox = document.getElementById('input_popup_politics');
    if (checkbox.checked) {
        checkbox.style.filter = "none"
        checkbox.style.border = "1px solid" 
    } else {
        checkbox.style.filter = "drop-shadow(0px 2px 9px rgba(205, 21, 21, 0.28))"
        checkbox.style.border = "1px solid rgba(205, 21, 21, 0.78)"
        //event.preventDefault();
    }
    
    if (document.getElementById('input_login_reg').value == "" || document.getElementById('input_email_reg').value == "" || document.getElementById('input_captcha_word_inst').value == ""
    || document.getElementById('bx-auth-reg-input-dop').value == "" || document.getElementById('bx-auth-reg-input').value == "") {
        alert("Перед регистрацие, убедитесь, что вы правильно заполнили все поля!");
	}
	
	
    //Проверяем заполнение под кем регистрируется пользователь    
    let selects = document.getElementsByTagName('select');
    for (let select of selects) {
        if(select.matches('.reg_option_type')){
            if (select.value == ''){
                document.getElementById('reg_option_type_select_box').style.filter = "drop-shadow(0px 2px 9px rgba(205, 21, 21, 0.28))"
                document.getElementById('reg_option_type_select_box').style.border = "1px solid rgba(205, 21, 21, 0.78)"
                event.preventDefault();
            } else {
                document.getElementById('reg_option_type_select_box').style.filter = "none"
                document.getElementById('reg_option_type_select_box').style.border = "1px solid" 
            }
        }
    }
    
}

//Заменяем стандартный список выбора
$(document).ready(function() {

    var select = $('select.reg_option_type');
    
    var selectBoxContainer = $('<div>', {
        width: select.outerWidth(),
        className: 'reg_option_type_select',
        html: '<div class="reg_option_type_select_box" id="reg_option_type_select_box"></div>'
    });
    
    var dropDown = $('<ul>', {
        class: 'reg_option_type_select_dropDown_basic'
    });
    
    var selectBox = selectBoxContainer.find('.reg_option_type_select_box');
    
    select.find('option').each(function(i) {
    var option = $(this);
    
    if (i == select.attr('selectedIndex')) {
        selectBox.html(option.text());
    }
    
    if (option.data('skip')) {
        return true;
    }
    
    if(i == 0){
        var li = $('<li>',)
    }
    
    if(i == 1){
        var li = $('<li>', {
        html: '<span>' +
            "Моряк" + '</span>'
        });
    }
    
    if(i == 2){
        var li = $('<li>', {
        html: '<span>' +
            "Судоходная компания" + '</span>'
        });
    }

                
    
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
</div>