<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();?>	
  </div>
	<!-- wrapper-top--> 
  <footer>
	<div class="top-footer">
		<div class="container">
			<div class="footer-soc">
				<div class="footer-soc-title">
					 Присоединяйтесь к нам:
				</div>
				<div class="footer-soc-links">
					<div class="footer-soc-link">
 <a href="https://vk.com/russmn"> <i class="icon-vk"></i>
						<span>Вконтакте</span> </a>
					</div>
					<div class="footer-soc-link">
 <a href="https://t.me/russmn_ru"> <i class="icon-tg"></i>
						<span>Telegram</span> </a>
					</div>
					<div class="footer-soc-link">
 <a href="https://dzen.ru/russmn"> <i class="icon-dzen"></i>
						<span>Дзен</span> </a>
					</div>
					<div class="footer-soc-link">
 <a href="https://rutube.ru/channel/37659846/"> <i class="icon-rutube"></i>
						<span>Rutube</span> </a>
					</div>
				</div>
			</div>
			<div class="footer-main">
 <a href="/" class="footer-logo"><i class="icon-logo"></i></a>
				<div class="footer-btns">
 <a href="https://skt-event.com/lk.php" class="footer-btn">Войти</a>
  <?/*<a href="https://skt-event.com/lk.php" class="footer-btn">Регистрация</a>*/?>
					<a class="footer-btn email" data-type="form-open" ><i class="icon-comment"></i>Написать нам</a>
				</div>
			</div>
		</div>
	</div>
	<div class="bottom-footer">
		<div class="container">
			<div class="footer-copyright">
				 © 2025 ООО "СИМПЛ"<br>
				 Все права защищены
			</div>
			<div class="footer-legal-links">
        <a href="/politika-konfidentsialnosti.php">Политика <br>конфиденциальности</a> 
        <a href="/soglasie-na-obrabotku-personalnykh-dannykh.php">Согласие на&nbsp;обработку <br>персональных данных</a> 
         <?/*<a href="#">Правила обработки <br> персональных данных</a>*/?>
			</div>
		</div>
	</div>
 </footer>
	<div class="main-popup" data-type="main-popup">
 <i class="icon-close" data-type="main-popup-close"></i>
		<div class="main-popup-cont" data-type="main-popup-cont">
		</div>
	</div>
	<div class="overlay" data-type="overlay">
	</div>



	 <!-- Модальное окно с формой -->
<div class="modal" id="feedbackModal" style="    overflow: auto;">
	<?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	".default", 
	array(
		"EMAIL_TO" => "leaxxxjob@yandex.ru",
		"EVENT_MESSAGE_ID" => array(
			0 => "14",
		),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(
		),
		"USE_CAPTCHA" => "Y",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
</div>



</div>


</body>
</html>