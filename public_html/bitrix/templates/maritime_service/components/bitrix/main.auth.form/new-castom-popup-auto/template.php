<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

global $USER;

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\Bitrix\Main\Page\Asset::getInstance()->addCss(
	'/bitrix/css/main/system.auth/flat/style.css'
);

if ($arResult['AUTHORIZED'])
{
	echo Loc::getMessage('MAIN_AUTH_FORM_SUCCESS');
	return;
}
?>

<div class="bx-authform">
    <div class="bx-authform-text-overview"><a class="bx-authform-text-overview-svg"><svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.5 6.75298V10.9752M10.5526 14.1419V14.2474L10.4474 14.247V14.1419H10.5526ZM1 16.6224V4.37798C1 3.19565 1 2.60404 1.2301 2.15245C1.4325 1.75522 1.75522 1.4325 2.15245 1.2301C2.60404 1 3.19565 1 4.37798 1H16.6224C17.8048 1 18.3951 1 18.8467 1.2301C19.2439 1.4325 19.5677 1.75522 19.7701 2.15245C20 2.6036 20 3.19449 20 4.37452V16.626C20 17.806 20 18.3961 19.7701 18.8472C19.5677 19.2444 19.2439 19.5677 18.8467 19.7701C18.3955 20 17.8055 20 16.6255 20H4.37452C3.19449 20 2.6036 20 2.15245 19.7701C1.75522 19.5677 1.4325 19.2444 1.2301 18.8472C1 18.3956 1 17.8048 1 16.6224Z" stroke="#A60303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>
<?if ($arResult['ERRORS']) {?>
		<? foreach ($arResult['ERRORS'] as $error) {?>
		    <script>
		        document.querySelector('#popup_wrapper').classList.add('active');
		        document.querySelector('#popup_auth').classList.add('active');
		    </script>
			<?echo $error;
			
		}?>
	<?} else if($USER->IsAuthorized()) {?>
	    <script>
	        location.reload(true);
	    </script>
	<?} else {?>Авторизируйтесь, чтобы подать заявку<?}?></div>

	<h3 class="bx-title"><?= Loc::getMessage('MAIN_AUTH_FORM_HEADER');?></h3>

	<?if ($arResult['AUTH_SERVICES']):?>
		<?$APPLICATION->IncludeComponent('bitrix:socserv.auth.form',
			'flat',
			array(
				'AUTH_SERVICES' => $arResult['AUTH_SERVICES'],
				'AUTH_URL' => $arResult['CURR_URI']
	   		),
			$component,
			array('HIDE_ICONS' => 'Y')
		);
		?>
		<hr class="bxe-light">
	<?endif?>

	<form name="<?= $arResult['FORM_ID'];?>" method="post" target="_top" action="<?= POST_FORM_ACTION_URI;?>">
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
		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_LOGIN');?></div>
			<div class="bx-authform-input-container">
				<input type="text" name="<?= $arResult['FIELDS']['login'];?>" maxlength="255" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>" />
			</div>
		</div>

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_PASS');?></div>
			<div class="bx-authform-input-container">
				<?if ($arResult['SECURE_AUTH']):?>
				<?endif?>
				<input type="password" id="bx-auto-pass" name="<?= $arResult['FIELDS']['password'];?>" maxlength="255" autocomplete="off" />
				<span class="bx-btn-show-password" id="eye" title="Показать пароль" data-title-show="Показать пароль" data-title-hide="Скрыть пароль"></span>
			</div>
		</div>

		<?if ($arResult['CAPTCHA_CODE']):?>
			<input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" />
			<div class="bx-authform-formgroup-container dbg_captha">
				<div class="bx-authform-label-container">
					<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_CAPTCHA');?>
				</div>
				<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" width="180" height="40" alt="CAPTCHA" /></div>
				<div class="bx-authform-input-container">
					<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
				</div>
			</div>
		<?endif;?>

		<?if ($arResult['STORE_PASSWORD'] == 'Y'):?>
			<div class="bx-authform-formgroup-container">
				<div class="checkbox">
					<label class="bx-filter-param-label">
						<span class="recovery has_popup" onclick="popup_show_recovery(this);" data-popup="recovery">Забыли пароль?</span>
					</label>
				</div>
			</div>
		<?endif?>

		<div class="bx-authform-formgroup-container" id="bx-authform-formgroup-container-submit">
			<input type="submit" class="btn btn-primary" id="button-lk" name="<?= $arResult['FIELDS']['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_SUBMIT');?>" />
			<span class="registration has_popup" onclick="popup_show_registration(this);" data-popup="registration">Зарегистрироваться</span>
		</div>

		<?if ($arResult['AUTH_FORGOT_PASSWORD_URL'] || $arResult['AUTH_REGISTER_URL']):?>
			<hr class="bxe-light">
			<noindex>
			<?if ($arResult['AUTH_FORGOT_PASSWORD_URL']):?>
				<div class="bx-authform-link-container">
					<a href="<?= $arResult['AUTH_FORGOT_PASSWORD_URL'];?>" rel="nofollow">
						<?= Loc::getMessage('MAIN_AUTH_FORM_URL_FORGOT_PASSWORD');?>
					</a>
				</div>
			<?endif;?>
			<?if ($arResult['AUTH_REGISTER_URL']):?>
				<div class="bx-authform-link-container">
					<a href="<?= $arResult['AUTH_REGISTER_URL'];?>" rel="nofollow">
						<?= Loc::getMessage('MAIN_AUTH_FORM_URL_REGISTER_URL');?>
					</a>
				</div>
			<?endif;?>
			</noindex>
		<?endif;?>

	</form>
</div>

<script type="text/javascript">
    document.getElementById('button-lk').onclick = function() {
        let log = document.querySelector('.bx-authform-input-container input[type="text"]');
        let pss = document.querySelector('.bx-authform-input-container input[type="password"]');
        //alert(pss.value);
        if (log.value == "") {
            event.preventDefault();
            log.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)";
            log.style.border = "1px solid rgba(205, 21, 21, 0.78)";
            
        } else {
            log.style.boxShadow = "none"
            log.style.border = "1px solid" 
        }
        
        if (pss.value == "") {
            event.preventDefault();
            pss.style.boxShadow = "0px 2px 9px rgba(205, 21, 21, 0.78)";
            pss.style.border = "1px solid rgba(205, 21, 21, 0.78)";
            
        } else {
            pss.style.boxShadow = "none"
            pss.style.border = "1px solid" 
            
        }
        /*if (log.value != "" && pss.value != "") { 
            location.reload(true);
        }*/
    }

	<?if ($arResult['LAST_LOGIN'] != ''):?>
	try{document.<?= $arResult['FORM_ID'];?>.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
	try{document.<?= $arResult['FORM_ID'];?>.USER_LOGIN.focus();}catch(e){}
	<?endif?>
</script>