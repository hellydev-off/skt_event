<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// global $USER;
// $USER->Authorize(1);
// $USER->Update(1,array("GROUP_ID"=>[1]));
// die('ok');
$APPLICATION->SetTitle("Авторизация");
?>
    <style>
        .empty_field {
            border: 2px solid red;
        }
    </style>

    <section class="page-login__content">
        <?php //echo '<pre>'; var_dump($APPLICATION->arAuthResult); echo '</pre>'; ?>
        <!--        --><?php //echo '<pre>'; var_dump($_POST); echo '</pre>'; ?>

        <!-- <div class="auth_promo">
            <div class="auth__promo-content"></div>
        </div> -->


        <div class="auth_login">
            <div class="formbg">
                <?php if (isset($_GET['change_password']) and $_GET['change_password'] == 'yes') {
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.auth.changepasswd",
                        "",
                        array(
                            "AUTH_AUTH_URL" => "/",
                            "AUTH_REGISTER_URL" => "",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO"
                        )
                    );
                } else { ?>

                    <?= $APPLICATION->arAuthResult['MESSAGE'] ?>

                    <h1>Личный кабинет</h1>
<br>
                    <form id="authform">
                        <div class="form-outline mb-2">
                            <input type="text" id="email_formLogin" class="form-control form-control-lg" placeholder="Email"
                                   name="LOGIN"/>
                        </div>

                        <div class="form-outline mb-2">
                            <input type="password" id="password" class="form-control form-control-lg" placeholder="Пароль"
                                   name="PASSW"/>
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </div>

                        <div class="text-center pt-1 pb-1">
                            <input type="submit" name="go" class="btn btn-primary btn-block btn-lg mb-3" value="Войти">
                        </div>
                    </form>

                    <p class='auth_btn text-muted' id='forget_open'>Забыли пароль?</p>

                    <div class="d-flex align-items-center justify-content-center mt-5 pb-4">
                        <p class="mb-0 me-2 auth-info">Нет аккаунта?</p>
                        <button type="button" id='registration_open' class="auth_btn btn btn-outline-secondary btn-lg">
                            Зарегистрироваться
                        </button>
                    </div>

                    <script>
                        const togglePassword = document.querySelector("#togglePassword");
                        const password = document.querySelector("#password");

                        togglePassword.addEventListener("click", function () {
                            // toggle the type attribute
                            const type = password.getAttribute("type") === "password" ? "text" : "password";
                            password.setAttribute("type", type);

                            // toggle the icon
                            this.classList.toggle("bi-eye");
                        });

                        // prevent form submit
                        const form = document.querySelector("form");
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                        });
                    </script>
                <?php } ?>
            </div>

      
        </div>
        <div class="popup popup-registration">
            <div class="popup__bgd"></div>
            <div class="popup__content">
                <div class="popup__close">
                    <i class='bx bx-menu'></i>
                </div>

                <div class="formbg">
                    <div class="popup__title">
                        <h2>Регистрация</h2>
                    </div>

                    <form id="patient_registation" method="post" enctype="multipart/form-data">



<!--                        <hr>-->

                        <!-- <h4 class="mt-4">Контактное лицо</h4> -->

                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Фамилия <span class="req">*</span></span>
                            <input class="form-control form-control-lg" type="text" id="LAST_NAME" name="USER[LAST_NAME]"
                                   required>
                        </div>

                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Имя <span class="req">*</span></span>
                            <input class="form-control form-control-lg" type="text" id="NAME" name="USER[NAME]"
                                   required>
                        </div>

                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Отчество</span>
                            <input class="form-control form-control-lg" type="text" id="SECOND_NAME" name="USER[SECOND_NAME]">
                        </div>                        
                        
                        <div class="wrap-input100 form-outline mb-2 aip_line">
                            <span class="label-input">Пол</span>
                            <select required class="form-control form-control-lg" id="PERSONAL_GENDER" name="USER[PERSONAL_GENDER]">
                            <option value="">Не выбрано</option>
                              <option value="M">Мужской</option><option value="F">Женский</option></select>
                            </select>
                        </div>

                        <div class="wrap-input100 form-outline mb-2 aip_line">
                            <span class="label-input">Дата рождения</span>
                            <input required class="form-control form-control-lg" type="date" id="PERSONAL_BIRTHDAY" name="USER[PERSONAL_BIRTHDAY]">
                        </div>

                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Email <span class="req">*</span></span>
                            <input class="form-control form-control-lg" type="text" id="EMAIL" name="USER[EMAIL]"
                                   required>
                        </div>

                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Телефон <span class="req">*</span></span>
                            <input class="form-control form-control-lg" type="text" id="PHONE_NUMBER"
                                   name="USER[PHONE_NUMBER]" required>
                        </div>

                        <?//$regions=Aiplk::getRegions()?>
                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Регион <span class="req">*</span></span>

                            <select class="form-control form-control-lg inp_tags" name="USER[UF_REGION]" id="PERSONAL_STATE" required>
                                <?/*foreach ($regions as $_r) { ?>
                                    <option value="<?= $_r['UF_XML_ID'] ?>"><?= $_r['NAME'] ?></option>
                                <?}*/?>
                            </select>                            
                        </div>

 <?/*                       <hr>

                        <fieldset class="mt-4 mb-2">
                            <legend>Укажите ваш статус: <span class="req">*</span></legend>
                            <label>
                            <input <?=((CSite::InGroup(array(9)))?'checked':'')?> type="checkbox" name="user_status[]" value="9">
                            <span>Организатор</span>
                          </label><br>
                          <label>
                            <input <?=((CSite::InGroup(array(7)))?'checked':'')?> type="checkbox" name="user_status[]" value="7">
                            <span>Судья</span>
                          </label><br>
                          <label>
                            <input <?=((CSite::InGroup(array(8)))?'checked':'')?> type="checkbox" name="user_status[]" value="8">
                            <span>Спортсмен</span>
                          </label><br>                           
                          <label>
                            <input <?=((CSite::InGroup(array(10)))?'checked':'')?> type="checkbox" name="user_status[]" value="10">
                            <span>Тренер</span>
                          </label> 
                        </fieldset>


*/?>
                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Пароль <span class="req">*</span></span>
                            <input class="form-control form-control-lg" type="password" id="NEW_PASSWORD"
                                   name="NEW_PASSWORD" required>
                        </div>

                        <div class="wrap-input100 form-outline mb-2">
                            <span class="label-input">Подтверждение пароля <span class="req">*</span></span>
                            <input class="form-control form-control-lg" type="password" id="NEW_PASSWORD_CONFIRM"
                                   name="NEW_PASSWORD_CONFIRM" required>
                        </div>                        
                        
                        <div class="wrap-input100 form-outline mb-2">
                            <label>
                              <input checked type="checkbox" id="NEW_AGREE" name="NEW_AGREE" required>
                              <span style="width:40px" class="custom-checkbox"></span>
                              <span>Нажимая кнопку «Зарегистрироваться», даю согласие с политикой конфиденциальности и обработкой персональных данных <span class="req">*</span></span>
                            </label>
                        </div>


                        <div class="wrap-input100 phone_code_check mt-4" style='display:none'>
                            <div class="wrap-input100" style="margin-right: 6px;">
                                <input class="form-control form-control-lg" type="text" id="SMS_CODE" name="SMS_CODE"
                                       placeholder="код">
                            </div>

                            <div class="wrap-input100 mt-2">
                                <input type="submit" name="go" value="Подтвердить код и зарегистрироваться"
                                       class="questionnaire_btn btn btn-primary btn-lg">
                            </div>

                        </div>

                        <div class="button-group-block d-grid gap-2 d-md-block mt-4">
                            <div class="wrap-input100 email_code_send mt-2 mx-auto">
                                <button id="email_code_send_btn" class="questionnaire_btn btn btn-primary btn-lg">
                                    Получить код на email
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        <div class="popup popup-forget">
            <div class="popup__bgd"></div>
            <div class="popup__content">
                <div class="popup__close">
                    <i class='bx bx-menu'></i>
                </div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:system.auth.forgotpasswd",
                    ".default",
                    array()
                ); ?>
            </div>
        </div>

        <div class="popup popup-registration-success">
            <div class="popup__bgd"></div>
            <div class="popup__content">
                <div class="popup__close">
                    <i class='bx bx-menu'></i>
                </div>
                <h2>Вы зарегистрированы</h2>
                <p>Можете войти под своими учетными данными</p>
                <div class="popup__body">
                    <button type="button" class="btn btn-primary btn-lg">Закрыть</button>
                </div>
            </div>
        </div>

        <div class="popup popup-recovery">
            <div class="popup__bgd"></div>
            <div class="popup__content">
                <div class="popup__close">
                    <i class='bx bx-menu'></i>
                </div>
                <h2>Пароль отправлен на почту</h2>
                <p>На вашу почту была отправлена инструкция для восстановления пароля.</p>
                <div class="popup__body">
                    <button type="button" class="btn btn-primary btn-lg">Закрыть</button>
                </div>
            </div>
        </div>
<?/*
        <div class="popup popup-consent">
            <div class="popup__bgd"></div>
            <div class="popup__content">
                <h2>Соглашение на обработку персональных данных</h2>
                <div class="popup__body">
                    <form id="consent">
                        <div class="content">
                            <div class="document-block">
                                <embed src="/privacy.pdf#toolbar=1&zoom=200,250,100&view=fitH,100"
                                       width="100%" height="600" type="application/pdf">
                            </div>
                        </div>

                        <div class="agree-block mt-4">
                            <input type="checkbox" id="check" required value="1">
                            <label for="check">Я принимаю пользовательское соглашение и даю своё согласие на обработку
                                моих персональных данных <span class="req">*</span></label>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Принять и продолжить</button>
                    </form>
                </div>
            </div>
        </div>
        */?>

        <script>
            $("#phone_formLogin").mask("+7 999 999-99-99");
            $("#PHONE_NUMBER").mask("+7 999 999-99-99");
        </script>

        <script>
            $('#show_phone_auth').click(function (e) {
                e.preventDefault();
                $("#authform").hide();
                $("#phone_authform").show();
            });

            $('#show_login_auth').click(function (e) {
                e.preventDefault();
                $("#authform").show();
                $("#phone_authform").hide();
            });

            $('#registration_open').click(function (e) {
                e.preventDefault();
                $(".popup.popup-registration").addClass("popup_open");
            });

            $('#forget_open').click(function (e) {
                e.preventDefault();
                $(".popup.popup-forget").addClass("popup_open");
            });

            $("#UF_STATUS").change(function () {
                $(".popup.popup-registration .certificate_div").show();
            });


            // Закрытие окон
            $('.popup.popup-registration .popup__bgd, .popup.popup-registration .popup__close').on('click', function () {
                $('.popup.popup-registration').removeClass('popup_open');
            });

            $('.popup.popup-forget .popup__bgd, .popup.popup-forget .popup__close').on('click', function () {
                $('.popup.popup-forget').removeClass('popup_open');
            });

            $('.popup.popup-registration-success .popup__bgd, .popup-registration-success .popup__close, .popup-registration-success .popup__body').on('click', function () {
                $('.popup.popup-registration-success').removeClass('popup_open');
            });

            $('.popup.popup-recovery .popup__bgd, .popup-recovery .popup__close, .popup-recovery .popup__body').on('click', function () {
                $('.popup.popup-recovery').removeClass('popup_open');
            });


            $('#phone_code_send_btn').click(function (e) {
                e.preventDefault();
                $('.errortext').remove();
                $("#EMAIL").removeClass('empty_field');
                $("#PHONE_NUMBER").removeClass('empty_field');
                var formData = new FormData(document.forms.patient_registation);
                $.ajax({
                    type: 'POST',
                    url: "<?=SITE_TEMPLATE_PATH?>/ajax/sendSmsForPatientRegistration.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (val) {
                         //console.log(val);
                        var jsonData = $.parseJSON(val);
                        if (jsonData.phone_number) {
                            $(".popup.popup-registration .phone_code_send").hide();
                            $(".popup.popup-registration .phone_code_check").show();
                            $(".popup.popup-registration #ili").hide();
                        } else {
                            $('.popup.popup-registration .phone_code_send').before('<label class="error errortext">' + jsonData.error + '</label>');
                            $("#PHONE_NUMBER").addClass('empty_field');
                        }
                    }
                });
            });
            $('#phone_or_email_btn').on('click', function (e) {
                e.preventDefault();
                $('.errortext').remove();
                $('.phone_code_send').toggle();
                $('.email_code_send').toggle();
                $('.phone_div').toggle();
                $('.email_div').toggle();
                let $req = $(this).attr('data-reg');
                if ($req == 'phone') {
                    $(this).attr('data-reg', 'email');
                    $('#EMAIL').prop('required', true);
                    $('#PHONE_NUMBER').prop('required', false);
                    $(this).text('Регистрация по номеру телефона');
                }
                if ($req == 'email') {
                    $(this).attr('data-reg', 'phone');
                    $('#PHONE_NUMBER').prop('required', true);
                    $('#EMAIL').prop('required', false);
                    $(this).text('Получить код на email');
                }
            });
            $('body').on('focus', '.l_err', function () {
                $(this).removeClass('l_err')
            })
            $('body').on('click','#email_code_send_btn',function (e){
              if(!$('form#patient_registation')[0].checkValidity()){
                $('form#patient_registation input').each(function(){
                  if($(this).prop('required')==true&&$(this).val()==''){
                    $(this).addClass('l_err');
                    //console.log('err',this);
                  }
                });
                // e.preventDefault();
                // return false;
              }                
              $('.errortext').remove();
              $("#EMAIL").removeClass('empty_field');
              $("#PHONE_NUMBER").removeClass('empty_field');
              // $('.popup.popup-registration .phone_code_send').after('<label class="error errortext">Код подтверждение отправлен на вашу почту, проверьте ее и введите код в поле</label>');
              var formData = new FormData(document.forms.patient_registation);
              $.ajax({
                  type: 'POST',
                  url: "<?=SITE_TEMPLATE_PATH?>/ajax/sendEmailForPatientRegistration.php",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (val) {
                      console.log(val);
                      var jsonData = $.parseJSON(val);
                      if (jsonData.mail_number) {
                          $(".popup.popup-registration .email_code_send").hide();
                          $(".popup.popup-registration #ili").hide();
                          $(".popup.popup-registration .phone_code_check").show();
                          $('.popup.popup-registration .phone_code_send').before('<label class="error errortext">Код подтверждение отправлен на вашу почту, проверьте ее и введите код в поле</label>');
                      } else {
                          $('.popup.popup-registration .phone_code_send').before('<label class="error errortext">' + jsonData.error + '</label>');
                          //$("#EMAIL").addClass('empty_field');
                      }
                  }
              });
              e.preventDefault();
              return false;
            });
            $('form#patient_registation').submit(function (e) {
                if (!$(this)[0].checkValidity()) return false;
                e.preventDefault();
                $('.errortext').remove();
                var formData = new FormData(document.forms.patient_registation);
                $.ajax({
                    type: 'POST',
                    url: "<?=SITE_TEMPLATE_PATH?>/ajax/patientRegistration.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (val) {
                        // console.log(val);
                        var jsonData = $.parseJSON(val);
                        if (jsonData.status == 0) {
                            $('.popup.popup-registration #SMS_CODE').after('<label class="error errortext">' + jsonData.error + '</label>');

                        } else {
                            $(".popup.popup-registration .phone_code_send").show();
                            $(".popup.popup-registration .phone_code_check").hide();
                            $('.popup.popup-registration').removeClass('popup_open');
                            $('.popup.popup-registration-success').addClass('popup_open');
                            //location.assign("/");
                        }
                    }
                });
            });

            $('#get_login_sms').click(function (e) {
                e.preventDefault();
                $('.errortext').remove();
                var formData = new FormData(document.forms.phone_authform);
                $.ajax({
                    type: 'POST',
                    url: "<?=SITE_TEMPLATE_PATH?>/ajax/sendSmsForPatientLogin.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (val) {
                        // console.log(val);
                        var jsonData = $.parseJSON(val);
                        if (jsonData.status == 0) {
                            $('#phone_authform .page-login__number').after('<label class="error errortext" style="color: red">' + jsonData.error + '</label>');

                        } else {
                            $("#phone_authform .phone_code_send").hide();
                            $("#phone_authform .phone_code_check").show();
                        }
                    }
                });
            });

            $('#phone_authform').submit(function (e) {
                e.preventDefault();
                $('.errortext').remove();
                var formData = new FormData(document.forms.phone_authform);
                $.ajax({
                    type: 'POST',
                    url: "<?=SITE_TEMPLATE_PATH?>/ajax/phoneLogin.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (val) {
                        // console.log(val);
                        var jsonData = $.parseJSON(val);
                        if (jsonData.status == 0) {
                            $('#phone_authform .phone_code_check input[name="SMS_CODE"]').after('<label class="error errortext" style="color: red">' + jsonData.error + '</label>');

                        } else {
                            location.assign("/lk.php");
                        }
                    }
                });
            });

            $('form#authform').submit(function (e) {
                e.preventDefault();
                $('.errortext').remove();
                var vars = $(this).serialize();
                console.log(vars);
                $.ajax({
                    url: "<?=SITE_TEMPLATE_PATH?>/ajax/login.php",
                    data: vars,
                    success: function (val) {
                        console.log(val);
                        var jsonData = $.parseJSON(val);
                        if (jsonData.status == 0) {
                            $('#authform').after('<label class="error errortext">' + jsonData.msg + '</label>');
                            //setTimeout(function() { $('.errortext').remove() }, 2000);

                        } else {
                            if (jsonData.status == 1) {
                                //location.assign("/");
                                $(location).attr('href', '/lk.php');
                            } else {
                                $(".popup.popup-consent").addClass("popup_open");
                            }

                        }
                    }
                });
            });
            $("#consent").submit(function () {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "<?=SITE_TEMPLATE_PATH?>/ajax/consent.php",
                    success: function (data) {
                        $(".popup.popup-consent").removeClass("popup_open");
                        location.assign("/");
                    },
                    error: function (xhr, str) {
                        alert('Возникла ошибка: ' + xhr.responseCode);
                    }
                });
            });
$(document).ready(function(){
  //select2
  $('#patient_registation .inp_tags').select2({
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_gorod.php',
      dataType: 'json',
      delay: 250
    }
  });
});
        </script>
    </section>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>