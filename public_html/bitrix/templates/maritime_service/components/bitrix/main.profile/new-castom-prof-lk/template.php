<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
//echo "<pre>"; print_r($arResult); echo "</pre>";
//exit();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

use Bitrix\Main\Page\Asset; 
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style.css');
?>
<?=ShowError($arResult["strProfileError"]);?>

<?
//Проверка зарегестрирванного пользователя
$by = $USER->GetID();
$rsUserNa = CUser::GetByID($by);
$arUserNa = $rsUserNa->Fetch();
$arUserNa["UF_TYPE"];
?>

<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
<?=$arResult["BX_SESSION_CHECK"]?>
<input type="hidden" name="lang" value="<?=LANG?>" />
<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />

<div class="content-form profile-form-tit">Мои данные</div>

<div class="content-form profile-form">
	<div class="fields">
	    <?if ($arUserNa["UF_TYPE"] == 2) {?>
	    <div class="table-info-1">
    		<div class="field field-name">
    			<label class="field-title">Название компании</label>
    			<div class="form-input"><input type="text" name="WORK_COMPANY" maxlength="50" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" /></div>
    		</div>
    		<div class="field field-street">	
    			<label class="field-title">Адрес</label>
    			<div class="form-input"><input type="text" name="WORK_STREET" maxlength="50" value="<?=$arResult["arUser"]["WORK_STREET"]?>" /></div>
    		</div>
		</div>
		<div class="table-info-2">
    		<div class="field field-contacts">	
    			<label class="field-title">Контактное лицо</label>
    			<div class="form-input"><input type="text" name="UF_CONTACTS_USER" maxlength="50" value="<?=$arResult["arUser"]["UF_CONTACTS_USER"][0]?>" /></div>
    		</div>
    		<div class="field field-phone">	
    			<label class="field-title">Номер телефона</label>
    			<div class="form-input"><input type="text" name="WORK_PHONE" maxlength="50" value="<?=$arResult["arUser"]["WORK_PHONE"]?>" /></div>
    		</div>
		</div>
			<?}?>
		<div class="table-info-3">
    		<div class="field field-email">	
    			<label class="field-title">Почта</label>
    			<div class="form-input"><div class="form-input-email"><?=$arResult["arUser"]["EMAIL"]?></div></div>
    		</div>
    		<?if ($arUserNa["UF_TYPE"] == 2) {?>
    		<div class="field field-www">	
    			<label class="field-title">Веб сайт</label>
    			<div class="form-input"><input type="text" name="WORK_WWW" maxlength="50" value="<?=$arResult["arUser"]["WORK_WWW"]?>" /></div>
    		</div> 
    		<?} else {?>
    		<div class="field field-www">	
    			<label class="field-title">ФИО</label>
    		<?
    		//Сравнение публикаций по автору, если совпадает текущий пользователь с автором, то записывается ID публикации
            $arFilter = Array("IBLOCK_ID"=> "6" , "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50));
            while($ob = $res->GetNextElement()) {
            	$arFields = $ob->GetFields();
            	if ($by == $arFields['CREATED_BY']) {
            	    $parID = $arFields['ID'];
            	}
            }
            // Если есть ID публикации то записывается и вводится публикация
            if (isset($parID)) {
        		$res = CIBlockElement::GetProperty(6, $parID, array("sort" => "asc", "ID" => "63" ), Array("ID"=>"63"));
            	while ($ob = $res->GetNext()) {
            		$prop = $ob;
            	};
            }?>
    			<div class="form-input"><div class="form-input-login-lk"><?if (isset($prop)) { echo $prop['VALUE']; } else { echo "Заполните в резюме";}?></div></div>
    		</div> 
    		<?}?>
		</div>
	</div>
</div>
<div class="content-form profile-form">
	<div class="legend"></div>
	<div class="field field-login-login">	
    		<label class="field-title">Логин</label>
    		<div class="form-input"><div class="form-input-login-lk"><?=$arResult["arUser"]["LOGIN"]?></div></div>
    	</div>
	<div class="fields-pass">
		<div class="field field-password_new">	
			<label class="field-title"><?=GetMessage('NEW_PASSWORD_REQ')?></label>
			<div class="form-input">
			    <input id="form-input-password-new-lk" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" />
			    <span class="bx-form-input-password-new-lk" id="eye-new-lk" title="Показать пароль" data-title-show="Показать пароль" data-title-hide="Скрыть пароль"></span>
			</div>
			
		</div>
		<div class="field field-password_confirm">	
			<label class="field-title"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
			<div class="form-input">
			    <input id="form-input-password-new-confirm-lk" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
			    <span class="bx-form-input-password-new-confirm-lk" id="eye-confirm-lk" title="Показать пароль" data-title-show="Показать пароль" data-title-hide="Скрыть пароль"></span>
			</div>
		</div>
	</div>
	<?if ($arUserNa["UF_TYPE"] == 2) {?>
    	<div class="field field-prof">	
    		<label class="field-title">О компании</label>
    		<div class="form-input"><input type="text" name="WORK_PROFILE" maxlength="50" value="<?=$arResult["arUser"]["WORK_PROFILE"]?>" /></div>
    	</div>
    	<div class="field field-logo">
    	    <input id="form-input-file-lk" type="file" name="WORK_LOGO" maxlength="50" value="" />
    		<span class="field-logo-title-name" id="field-logo-title-name">Выберите файл</span>
    		<span class="field-logo-title-name-lg" id="field-logo-title-name-lg"></span>
    		<span class="field-logo-title-name-warning">Максимум 10 мб</span>
    	</div>
	<?}?>
</div>

<script>
    document.addEventListener("click", function(e) {
        $(document).ready(function() {
                if (event.target.className == "bx-form-input-password-new-lk"){
                    let pass = document.getElementById('form-input-password-new-lk');
                    pass.setAttribute('type', 'text');
                    document.getElementById("eye-new-lk").classList.add("active");
                } else if (event.target.className == "bx-form-input-password-new-lk active") {
                    let pass = document.getElementById('form-input-password-new-lk');
                    pass.setAttribute('type', 'password');
                    document.getElementById("eye-new-lk").classList.remove("active");
                };
                if (event.target.className == "bx-form-input-password-new-confirm-lk"){
                    let pass = document.getElementById('form-input-password-new-confirm-lk');
                    pass.setAttribute('type', 'text');
                    document.getElementById("eye-confirm-lk").classList.add("active");
                } else if (event.target.className == "bx-form-input-password-new-confirm-lk active") {
                    let pass = document.getElementById('form-input-password-new-confirm-lk');
                    pass.setAttribute('type', 'password');
                    document.getElementById("eye-confirm-lk").classList.remove("active");
                };
        })
    });
    
    $(".field-logo-title-name").click(function(){
        $("input[type='file'").trigger('click');
    });
    
    document.getElementById('form-input-file-lk').addEventListener('change', function(){
        if (this.value) {
            document.getElementById('field-logo-title-name').classList.add('active');
            document.getElementById('field-logo-title-name-lg').classList.add('active');
        } else {}
    });
    
    setTimeout(function(){
    	document.getElementById('warning-info-lk').style.display = 'none';
    }, 1500);
    
</script>

<div class="content-form profile-form">
	<div class="button"><input name="save" value="Сохранить данные"class="input-submit" type="submit"/>
	</div>
</div>

	<?if ($arResult['DATA_SAVED'] == 'Y') {?>
        <div class="warning-info-lk" id="warning-info-lk">
        <p>
            <font class="notetext"><svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 6.75298V10.9752M10.5526 14.1419V14.2474L10.4474 14.247V14.1419H10.5526ZM1 16.6224V4.37798C1 3.19565 1 2.60404 1.2301 2.15245C1.4325 1.75522 1.75522 1.4325 2.15245 1.2301C2.60404 1 3.19565 1 4.37798 1H16.6224C17.8048 1 18.3951 1 18.8467 1.2301C19.2439 1.4325 19.5677 1.75522 19.7701 2.15245C20 2.6036 20 3.19449 20 4.37452V16.626C20 17.806 20 18.3961 19.7701 18.8472C19.5677 19.2444 19.2439 19.5677 18.8467 19.7701C18.3955 20 17.8055 20 16.6255 20H4.37452C3.19449 20 2.6036 20 2.15245 19.7701C1.75522 19.5677 1.4325 19.2444 1.2301 18.8472C1 18.3956 1 17.8048 1 16.6224Z" stroke="#A60303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>Изменения сохранены!</font>
        </p>
        </div>	
    <?}?>

</form>