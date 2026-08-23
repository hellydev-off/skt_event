<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("main");?>

<section class="header-offset main-section">
		<div class="container">
			<h1 class="main-section-title">Спортивное <span>метание ножа</span></h1>
			<div class="main-top-wrap">
				<div class="main-top-left">
					<div class="main-top-desc">
						 Спортивное метание ножа&nbsp;- уникальный и&nbsp;увлекательный вид&nbsp;спорта!
					</div>
					<div class="main-top-soc">
						<div class="main-top-soc-capture">
							 Присоединяйтесь к&nbsp;нам:
						</div>
 <a target="_blank" href="https://vk.com/russmn" class="main-top-soc-btn"> <i class="icon-vk"></i> </a> 
 <a target="_blank" href="https://t.me/russmn_ru" class="main-top-soc-btn"> <i class="icon-tg"></i> </a> 
 <a target="_blank" href="https://dzen.ru/russmn" class="main-top-soc-btn"> <i class="icon-dzen"></i> </a> 
 <a target="_blank" href="https://rutube.ru/channel/37659846/" class="main-top-soc-btn"> <i class="icon-rutube"></i> </a>
					</div>
				</div>
				<div class="main-top-right">
 <img alt="Спортивное метание ножа" src="/local/templates/2/img/main-top.png">
				</div>
			</div>
		</div>
 </section> 
 <section class="main-statistics">
		<div class="container">
			<div class="title-cont">
				<h2 class="title-cont-txt"> <span class="title-cont-txt-top">статистика</span> <span class="title-cont-txt-bottom">пользователей</span></h2>
				<div class="title-cont-txt over">
 <span class="title-cont-txt-top">статистика</span> <span class="title-cont-txt-bottom">пользователей</span>
				</div>
			</div>
			<div class="main-stat-wrap">
				<div class="main-stat-item">
					<div class="main-stat-item-nmbr">
						 01
					</div>
					<div class="main-stat-value">
						 <?=count(Aiplk::getUserSportsmeny())?>
					</div>
					<div class="main-stat-capture">
						 спортсменов
					</div>
				</div>
				<div class="main-stat-item">
					<div class="main-stat-item-nmbr">
						 02
					</div>
					<div class="main-stat-value">
						 <?=count(Aiplk::getUserSudi())?>
					</div>
					<div class="main-stat-capture">
						 судей
					</div>
				</div>
				<div class="main-stat-item">
					<div class="main-stat-item-nmbr">
						 03
					</div>
					<div class="main-stat-value">
						 <?=count(Aiplk::getUserTrenery())?>
					</div>
					<div class="main-stat-capture">
						 тренеров
					</div>
				</div>
			</div>
			<div class="main-stat-btns">
<?/* <a href="https://skt-event.com/lk.php" class="main-stat-btn main-stat-join">присоединиться <i class="icon-right-arr"></i></a>*/?>
 <a href="https://skt-event.com/lk.php" class="main-stat-btn main-stat-enter">войти <i class="icon-right-arr"></i></a>
			</div>
		</div>
 </section> 
 <section class="main-calendar">
		<div class="container">
			<div class="title-cont title-cont-calendar">
				<h2 class="title-cont-txt title-cont-txt-calendar"> <span class="title-cont-txt-top">календарь</span> <span class="title-cont-txt-bottom">мероприятий</span></h2>
				<div class="title-cont-txt title-cont-txt-calendar over">
 <span class="title-cont-txt-top">календарь</span> <span class="title-cont-txt-bottom">мероприятий</span>
				</div>
			</div>
					
<?$APPLICATION->IncludeComponent(
	"aip:meropr",
	"", 
	array())
?>			
		</div>
 </section> 
 
 <section class="main-video">
            <div class="main-video-cont">
                <video loop id="mainVideo" poster="<?=SITE_TEMPLATE_PATH?>/img/video-1.png">
                    <source src="<?=SITE_TEMPLATE_PATH?>/video/test_video.mp4" type="video/mp4">
                </video>
                <div class="main-video-play" data-type="main-video-play"><i class="icon-play"></i></div>
            </div>
        </section>
 
 <section class="main-rating">
		<div class="container">
			<div class="title-cont title-cont-rating">
				<h2 class="title-cont-txt title-cont-txt-rating"> <span class="title-cont-txt-top">Топ-10 рейтинг</span> <span class="title-cont-txt-bottom title-cont-txt-bottom-rating">спортсменов</span></h2>
				<div class="title-cont-txt title-cont-txt-rating over">
 <span class="title-cont-txt-top">Топ-10 рейтинг</span> <span class="title-cont-txt-bottom title-cont-txt-bottom-rating">спортсменов</span>
				</div>
			</div>
			
<?$APPLICATION->IncludeComponent(
	"aip:top10", 
	"", 
	array())
?>			

		</div>
 </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>