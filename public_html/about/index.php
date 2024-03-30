<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О нас");
?>

<div class="about-us-section">
    <div class="about-us-section-top">
        <div class="about-us-section-top-left">
            <div class="_top-left">Компания крюнгового сервиса, основанная в 2015 году.</div>
            <div class="_top-left_2">Наша деятельность охватывает несколько направлений, включая трудоустройство моряков, снабжение судоходных компаний, подбор персонала для судоходных компаний и консультирование.</div>
            <div class="about-us-section-top-left-title">Maritime service</div>
            <div class="">Мы вступили на этот рынок из-за перенасыщения вакансиями и неэффективности крюинга в Астрахани, стремясь улучшить этот сервис и стать ведущей компанией в России.</div>
        </div>
        <div class="about-us-section-top-right-img">
            <a class=""><img src="/bitrix/templates/maritime_service/images/img-about/1.png" alt="img"></a>
        </div>
    </div>
    <div class="about-us-section-midlle">
        <div class="about-us-section-midlle-left-title">
            <span class="_midlle-left">Бэкграунд</span>
            <span class="_midlle-left_2">В переводе: фон, задний план. В нашем случае: наше прошлое за плечами</span>
        </div>
        <div class="splash"></div>
        <div class="about-us-section-midlle-left-info">
            <div class="about-us-section-midlle-left-info-left">
                <div class="_left-info">История основания нашей компании началась с желания объединить профессионалов, которые имеют обширный опыт работы в море.</div>
                <a class="_left-info-2"><img src="/bitrix/templates/maritime_service/images/img-about/2.png" alt="img"></a>
            </div>
            <div class="about-us-section-midlle-left-info-right">
                <div class="_left-info-3">Рынок перенасыщен вакансиями, но все это не грамотно реализовано. Мы же понимаем, чего не хватает судовладельцам и рабочему персоналу, так как сами были на их месте. Поэтому наши основные преимущества заключаются в удобстве услуг, что позволяет нам предоставлять качественное обслуживание.</div>
                <div class="_left-info-4">Мы готовы к сотрудничеству и предлагаем нашим клиентам и партнёрам широкий спектр услуг. Для связи с нами и получения более подробной информации вы можете посетить разделы сайта или связаться с нами по телефону или по электронной почте.</div>
            </div>
        </div>
    </div>
    <div class="about-us-section-midlle-too">
        <div class="about-us-section-midlle-too-title">Наша деятельность</div>
        <div class="about-us-section-midlle-too-bottom">
             <div class="_too-bottom_1"><span>Подбор персонала для судоходных компаний</span><a class=" "><img src="/bitrix/templates/maritime_service/images/img-about/3.png" alt="img"></a></div>
             <div class="_too-bottom_2"><span>Трудоустройство моряков</span><a class=" "><img src="/bitrix/templates/maritime_service/images/img-about/4.png" alt="img"></a></div>
             <div class="_too-bottom_3"><span>Консультирование</span><a class=" "><img src="/bitrix/templates/maritime_service/images/img-about/5.png" alt="img"></a></div>
        </div>
    </div>
    
    <div class="about-us-section-bottom-title-info">
        <div class="about-us-section-bottom-title-info-h2"><h2 class=txt-cl>Наша основная цель</h2> — соблюдение равновесия и движение к реализации наших целей. У нас всегда есть желание двигаться дальше и развиваться в своём направлении.
        </div>
    </div>
    
    <div class="about-us-section-bottom-contacts-info">
        <h2 class="">Контактная информация</h2>
        <div class="about-us-section-bottom-contacts-info-additionally">
            <div class="about-us-section-bottom-contacts-info-additionally-left">
                <div class="about-us-section-bottom-contacts-info-additionally-left-left">
                    <div class="_additionally-left-left_1">Адрес компании<a class="about-us-item">ул. Генерала Армии Епишева, 20д</a></div>
                    <div class="_additionally-left-left_2">Часы работы филиала<a class="about-us-item">пн-чт 10:00–18:00; пт 10:00–17:00</a></div>
                </div>
                <div class="about-us-section-bottom-contacts-info-additionally-left-right">
                    <div class="_additionally-left-right_1">Контактный номер<a class="about-us-item">+7 999 645-28-09, <a>+7 8512 69-15-88</a></a></div>
                    <div class="_additionally-left-right_2">Электронная почта<a class="about-us-item"></a></div>
                </div>
            </div>
            <div class="about-us-section-bottom-contacts-info-additionally-right">
                <?$APPLICATION->IncludeComponent(
                	"bitrix:map.yandex.view",
                	"",
                	Array(
                		"API_KEY" => "",
                		"CONTROLS" => array(),
                		"INIT_MAP_TYPE" => "PUBLIC",
                		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:46.335732622286194;s:10:\"yandex_lon\";d:48.01696003296569;s:12:\"yandex_scale\";i:17;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:48.01735907245698;s:3:\"LAT\";d:46.33581153781181;s:4:\"TEXT\";s:0:\"\";}}}",
                		"MAP_HEIGHT" => "209",
                		"MAP_ID" => "",
                		"MAP_WIDTH" => "456",
                		"OPTIONS" => array("ENABLE_SCROLL_ZOOM","ENABLE_DBLCLICK_ZOOM","ENABLE_DRAGGING")
                	)
                );?>
            </div>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>