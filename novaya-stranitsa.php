<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<a class="footer-btn email" data-type="form-open" ><i class="icon-comment"></i>Написать нам</a>
	 <!-- Модальное окно с формой -->
	<div class="modal" id="feedbackModal">
	
	
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
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
	
	

	</div>
	
	
	
	<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>