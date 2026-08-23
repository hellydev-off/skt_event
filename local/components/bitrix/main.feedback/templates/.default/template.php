<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>

		<div class="modal-content">
 <button class="close-btn" id="closeModalBtn"><i class="icon-close"></i></button>
			<h2 class="modal-title">Обратная связь</h2>
<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
<input type="hidden" name="submit" value="Y">
				<div class="form-group">
 <label for="name" class="required">ФИО</label> <input type="text" id="name" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" placeholder="Введите ваше ФИО">
					<div class="error-message" id="nameError">
						 Поле ФИО обязательно для заполнения
					</div>
				</div>
				<div class="form-group">
 <label for="phone" class="required">Номер телефона</label> <input type="tel" id="phone" name="TEL" value="<?=$arResult["TEL"]?>" placeholder="Введите ваш номер телефона">
					<div class="error-message" id="phoneError">
						 Поле номера телефона обязательно для заполнения
					</div>
				</div>
				<div class="form-group">
 <label for="email" class="required">E-mail</label> <input type="email" id="email" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" placeholder="Введите ваш e-mail">
					<div class="error-message" id="emailError">
						 Поле e-mail обязательно для заполнения
					</div>
				</div>
				<div class="form-group">
 <label for="message">Сообщение</label> <textarea id="message" name="MESSAGE" rows="4" placeholder="Введите ваше сообщение"><?=($arResult["MESSAGE"] ?? '')?></textarea>
				</div>


	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="form-group mf-captcha">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
		<input type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">

 <button type="submit" class="submit-btn" id="submitBtn">Отправить</button>
				
 
 <?if(!empty($arResult["ERROR_MESSAGE"]))
{
  echo '<div style="display:flex" class="success-message" id="successMessage">';
  foreach($arResult["ERROR_MESSAGE"] as $v)
		echo($v);
  echo '</div>';
}
if(!empty($arResult["OK_MESSAGE"]))
{
	?>
  <div style="display:flex" class="success-message" id="successMessage">
  <?=$arResult["OK_MESSAGE"]?>
  <script>
          setTimeout(() => {
            closeModal();
        }, 3000);
</script>
  </div>
  
  <?
}

?>
				</div>
			</form>
		</div>