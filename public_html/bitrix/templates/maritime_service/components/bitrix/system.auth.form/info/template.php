<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $USER;
use Bitrix\Main\Page\Asset;?>
<?$by = $USER->GetID();
$rsUser = CUser::GetByID($by);
$arUser = $rsUser->Fetch();
$arUser["UF_TYPE"];?>
<!--<p class="cart"> -->

<?
if ($arResult["FORM_TYPE"] == "login"):
?>
<?
	if($arResult["NEW_USER_REGISTRATION"] == "Y")
	{
?>
	<a class="registration has_popup" onclick="popup_show_registration(this);" data-popup="registration"><?=GetMessage("AUTH_REGISTER")?></a>
<?
	}
?>
    <a class="auth has_popup" onclick="popup_show(this);" data-popup="auth"><?=GetMessage("AUTH_LOGIN")?></a>
<?
else:
?>
<?//Проверка зарегестрирванного пользователя
    $by = $USER->GetID();
    $rsUserNa = CUser::GetByID($by);
    $arUserNa = $rsUserNa->Fetch();
    $arUserNa["UF_TYPE"];
    $arUserNa["UF_AD_APP"];
?>
<?if (($arUserNa["UF_AD_APP"] != "4")) {?>
	<a class="lk-info-head-title">Личный кабинет</a>
	<div class="lk-info-head-svg" id="lk-info-head-svg">
	    <div class="lk-info-head-sel-info" data-type="<?=$arUserNa["UF_TYPE"]?>">
	        <a class="lk-info-head-sel-info-item" href="/personal/profile/">Личный кабинет</a>
	        <?if ($arUserNa["UF_TYPE"] == 2) {?><a class="lk-info-head-sel-info-item"href="/personal/profile/vac/">Вакансии</a> <?}?>
	        <a class="lk-info-head-sel-info-item"href="/personal/profile/wishlist/">Избранное</a>
	        <a class="lk-info-head-sel-info-item"href="/personal/profile/settings/">Настройка аккаунта</a>
	        <a class="lk-info-head-sel-info-item" href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), Array("logout", "sessid"))?>"><?=GetMessage("AUTH_LOGOUT")?></a>
	    </div>    
    </div>
<?} else {?>
    <a class="auth has_popup" style="margin-left: 137px;" href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), Array("logout", "sessid"))?>"><?=GetMessage("AUTH_LOGOUT")?></a>
<?}?>
<?
endif;
?>
<?if ($arUserNa["UF_AD_APP"] != "4" && $USER->IsAuthorized()) {?>

<script>
//Открытие дисплея
$(document).ready(function() {
    let lk = this.querySelector(".lk-info-head-sel-info");
    let idPanel = $("#lk-info-head-svg");
    let verHead = document.getElementById("lk-info-head-svg");
    //Проверка на активности класса
    document.addEventListener("click", function(e) {
        if (verHead.className == 'lk-info-head-svg active') {
            if (event.target.className != "lk-info-head-svg" && lk.style.display == "grid" && event.target.className != "lk-info-head-sel-info" && event.target.className != "lk-info-head-sel-info-item") {
                lk.style = "display:none";
            }
        }    
    });
    //Проверка на клик по иконке
    $('.lk-info-head-svg').live('click', function() {
        let type = $(".lk-info-head-sel-info").data('type');
        idPanel.addClass("active");
        if ( type == 1) {
            lk.style = "display:grid; height: 148px;";
        } else {
            lk.style = "display:grid;";
        }
    });
});
</script>
<?}?>

</p>