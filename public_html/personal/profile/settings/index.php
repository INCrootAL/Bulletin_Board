<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки аккаунта");
?>
<?
global $USER;
use Bitrix\Main\Page\Asset; 
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style.css');
$rsUser = CUser::GetByID($USER->GetID()); 
$arUserT = $rsUser->Fetch();
?>
<?
//Проверка зарегестрирванного пользователя
$by = $USER->GetID();
$rsUserNa = CUser::GetByID($by);
$arUserNa = $rsUserNa->Fetch();
$arUserNa["UF_TYPE"];
?>

<div class="_lk-panel">
    <div class="lk-panel-info-left">
        <div class="lk-panel-info-left-logo-comp" <?if (!isset($arUserT['WORK_LOGO'])){?> style="background: #D9D9D9;"<?}?>>
            <?echo CFile::ShowImage($arUserT['WORK_LOGO'], 98, 98, 'border=0', '', true); ?>
        </div>
        <div class="lk-panel-info-left-name-comp"><?echo $arUserT['WORK_COMPANY']?></div>
        <div class="lk-panel-info-menu">
            <a class="lk-panel-info-menu-items"href="/personal/profile/"<?if($APPLICATION->GetCurPage() == '/personal/profile/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?></a>Личный кабинет</a>
            <?if ($arUserNa["UF_TYPE"] == 2) {?><a class="lk-panel-info-menu-items"href="/personal/profile/vac/"<?if($APPLICATION->GetCurPage() == '/personal/profile/vac/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?>>Вакансии</a><?}?>
            <a class="lk-panel-info-menu-items"href="/personal/profile/wishlist/"<?if($APPLICATION->GetCurPage() == '/personal/profile/wishlist/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?>>Избранное</a>
            <a class="lk-panel-info-menu-items"href="/personal/profile/settings/"<?if($APPLICATION->GetCurPage() == '/personal/profile/settings/'){?> style="color:#035AA6;border-radius: 10px;border: 1px solid #035AA6;"<?}?>>Настройки аккаунта</a>
        </div>
    </div>
    <div class="lk-panel-info-right">
        <div class="lk-panel-info-right-title">
            <?$APPLICATION->IncludeComponent(
                    	"bitrix:breadcrumb",
                    	"",
                    	Array(
                    		"PATH" => "",
                    		"SITE_ID" => "s1",
                    		"START_FROM" => "0"
                    	)
                    );?>
            <span class="lk-panel-info-right-title-t">Настройки аккаунта</span>
        </div>
        <div class="lk-panel-info-right-about-us">
            <?$APPLICATION->IncludeComponent(
            	"bitrix:main.profile",
            	"new-castom-prof-lk",
            	Array(
            		"CHECK_RIGHTS" => "N",
            		"SEND_INFO" => "N",
            		"SET_TITLE" => "Y",
            		"USER_PROPERTY" => array(),
            		"USER_PROPERTY_NAME" => ""
            	)
            );?>
        </div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>