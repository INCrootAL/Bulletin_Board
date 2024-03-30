<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>
<div class="main-err-404">
    <div class="main-err-404-title"><span>Ошибка 404</span></div>
    <div class="main-err-404-middle">Кажется что-то пошло не так! Страница, которую вы запрашиваете не существует. Возможно она устарела, была удалена, или был введен не верный адрес в адресной строке.</div>
    <a class="main-err-404-button" href="/">Перейти на главную</a>
</div>
<style>
#page-body .page-left-top {
    height: 150%!important;
}

.main-err-404 {
    position: relative;
    z-index: 10;
    margin-top: 200px;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    width: 781px;
    letter-spacing: 0.32px;
}

.main-err-404-title {
    font-size: 85px;
    font-weight: 600;
}

.main-err-404-middle {
    margin-top: 50px;
    line-height: 25px;
    font-size: 15px;
}

a.main-err-404-button {
    margin-top: 50px;
    color: #fff;
    display: inline-flex;
    height: 46px;
    padding: 0px 29px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    border-radius: 14px;
    background: #035AA6;
    margin-left: 30px;
    font-family: 'Montserrat', sans-serif;
    box-shadow: 0 2px 16px rgba(0,0,0,.08);
    cursor: pointer;
    font-weight: 400;
    text-decoration: none;
}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>