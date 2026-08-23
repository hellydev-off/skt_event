<?php
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<div class="bx-auth-profile">

<!--    --><?php //ShowError($arResult["strProfileError"]); ?>
	<?php //echo '<pre>'; print_r($arResult["arUser"]); echo '</pre>'; ?>

    <?php
    if ($arResult['DATA_SAVED'] == 'Y')
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?>

        <div class="table-container">

            <form method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
                <?= $arResult["BX_SESSION_CHECK"] ?>
                <input type="hidden" name="lang" value="<?= LANG ?>"/>
                <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>

                <table class="profile-table data-table">
                    <tbody>
                    <tr class="mb-2">
                        <td class="field-name">Сфера деятельности:</td>
                        <td class="field-value">
                            <input class="form-control" type="text" name="WORK_PROFILE" maxlength="255" value="<?=$arResult["arUser"]['WORK_PROFILE']?>"/>
                        </td>
                    </tr> 
                    <tr class="mb-2">
                        <td>Фамилия:<span class="starrequired">*</span></td>
                        <td><input class="form-control" type="text" name="LAST_NAME" maxlength="50" value="<?= $arResult["arUser"]["LAST_NAME"] ?>"/></td>
                    </tr>                   
                    <tr class="mb-2">
                        <td>Имя:<span class="starrequired">*</span></td>
                        <td><input class="form-control" type="text" name="NAME" maxlength="50" value="<?= $arResult["arUser"]["NAME"] ?>"/></td>
                    </tr>
                    <tr class="mb-2">
                        <td>Отчество:</td>
                        <td><input class="form-control" type="text" name="SECOND_NAME" maxlength="50" value="<?= $arResult["arUser"]["SECOND_NAME"] ?>"/></td>
                    </tr>
                    <tr class="mb-2">
                      <td>Телефон</td>
                      <td><input class="form-control" type="text" name="PERSONAL_PHONE" maxlength="50" value="<?php echo $arResult["arUser"]["PERSONAL_PHONE"] ?>"/></td>
                    </tr>
                    <tr class="mb-2">
                      <td><?= GetMessage('EMAIL') ?><?php if ($arResult["EMAIL_REQUIRED"]): ?><span class="starrequired">*</span><?php endif ?></td>
                        <td><input class="form-control" type="text" name="EMAIL" maxlength="50" value="<?php echo $arResult["arUser"]["EMAIL"] ?>"/></td>
                    </tr>

                    <tr class="mb-2">
                        <td><?= GetMessage('LOGIN') ?><span class="starrequired">*</span></td>
                        <td><input class="form-control" type="text" name="LOGIN" maxlength="50" value="<?php echo $arResult["arUser"]["LOGIN"] ?>" disabled/></td>
                    </tr>

<?
	$arOrder=['NAME' => 'ASC'];
	$arFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>67];
	$arSelect=['ID', "IBLOCK_ID", 'NAME'];
	$obElement=\CIBlockElement::GetList($arOrder, $arFilter,$arSelect);
  $regions=array();
	while($arElement=$obElement->GetNext()){
    $arRegion=array();
    $arRegion["ID"]=$arElement['ID'];
    $arRegion["NAME"]=$arElement['NAME'];
    $regions[]=$arRegion;
  }
?>
                    <tr class="mb-2">
                      <td>Регион<span class="starrequired">*</span></td>
                      <td>
                        <select class="form-control form-control-lg" name="UF_REGION" id="PERSONAL_STATE" required>
                              <option value="">Не выбрано</option>
                              <?foreach($regions as $_r){?>
                                <option <?=(($arResult["USER_PROPERTIES"]["DATA"]['UF_REGION']['VALUE']==$_r['ID'])?'selected':'')?> value="<?=$_r['ID']?>"><?=$_r['NAME']?></option>
                              <?}?>
                        </select>
                      </td>
                    </tr>
               
                    <tr class="mb-2">
                        <td>Город<span class="starrequired">*</span></td>
                        <td><input class="form-control" type="text" name="PERSONAL_CITY" maxlength="50" value="<?php echo $arResult["arUser"]["PERSONAL_CITY"] ?>"/></td>
                    </tr>                       
                    
                    <tr class="mb-2">
                        <td>Статус<span class="starrequired">*</span></td>
                        <td>
                          <fieldset class="mt-4 mb-2">
                            <input type="hidden" name="UF_PO" value="<?=(($arResult["USER_PROPERTIES"]["DATA"]['UF_PO']['VALUE']=='1')?'1':'')?>">
                            <input type="hidden" name="UF_FIZ" value="<?=(($arResult["USER_PROPERTIES"]["DATA"]['UF_FIZ']['VALUE']=='1')?'1':'')?>">
                              <div class="mb-2">
                                  <input onchange="$('input[name=UF_PO]').val('1');$('input[name=UF_FIZ]').val('')" type="radio" id="UF_PO1" name="drone" value="UF_PO" <?=(($arResult["USER_PROPERTIES"]["DATA"]['UF_PO']['VALUE']=='1')?'checked':'')?> />
                                  <label for="UF_PO1">Проектная организация</label>
                              </div>

                              <div class="mb-2">
                                  <input onchange="$('input[name=UF_PO]').val('');$('input[name=UF_FIZ]').val('1')" type="radio" id="UF_PO2" name="drone" value="UF_FIZ" <?=(($arResult["USER_PROPERTIES"]["DATA"]['UF_FIZ']['VALUE']=='1')?'checked':'')?> />
                                  <label for="UF_PO2">Физическое лицо</label>
                              </div>
                          </fieldset>                          
                        </td>
                    </tr>       
                    <tr class="mb-2">
                        <td>Ваш менеджер</td>
                        <td><input class="form-control" type="text" name="UF_MANAGER" maxlength="50" value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_MANAGER']['VALUE']?>"/></td>
                    </tr>          
                    <tr class="mb-2">
                        <td></td>
                        <td>
                          <?$_u=$arResult["USER_PROPERTIES"]["DATA"]['UF_FIZ']['VALUE']?>
                        <div style="<?=(($_u=='1')?'display:none':'')?>" id="cont_poektorg">
                          <h4 class="mt-4">Проектная организация</h4>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">Название организации <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="WORK_COMPANY"
                                    name="WORK_COMPANY" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["arUser"]["WORK_COMPANY"]?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">Регион <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="WORK_STATE"
                                    name="WORK_STATE" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["arUser"]["WORK_STATE"]?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">Город <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="WORK_CITY"
                                    name="WORK_CITY" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["arUser"]["WORK_CITY"]?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">Улица, дом, офис <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="WORK_STREET"
                                    name="WORK_STREET" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["arUser"]["WORK_STREET"]?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">Телефон организации <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="WORK_PHONE"
                                    name="WORK_PHONE" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["arUser"]["WORK_PHONE"]?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">Сайт <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="WORK_WWW"
                                    name="WORK_WWW" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["arUser"]["WORK_WWW"]?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">ИНН <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="UF_INN"
                                    name="UF_INN" <?=(($_u=='1')?'':'required')?> value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_INN']['VALUE']?>">
                          </div>

                          <div class="wrap-input100 form-outline mb-2">
                              <span class="label-input">КПП <span class="req">*</span></span>
                              <input class="form-control form-control-lg" type="text" id="UF_KPP"
                                    name="UF_KPP" <?=(($_u=='1')?'':'required')?>  value="<?=$arResult["USER_PROPERTIES"]["DATA"]['UF_KPP']['VALUE']?>">
                          </div>

                          <hr>
                        </div>                          
                        </td>
                    </tr>                    
                    



<?// ******************** /User properties ***************************************************?>
                     <?//var_dump('<pre>',$arResult["USER_PROPERTIES"]["DATA"])?>                         
                                              
                    
                    
                    
                    <?php if ($arResult['CAN_EDIT_PASSWORD']): ?>
                        <tr class="mb-2">
                        <td><?= GetMessage('NEW_PASSWORD_REQ') ?></td>
                        <td><input class="form-control" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="bx-auth-input"/>
                        <p class="text-muted input-info"><?php echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></p>
                        <?php if ($arResult["SECURE_AUTH"]): ?>
                            <span class="bx-auth-secure" id="bx_auth_secure" title="<?php echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
					            <div class="bx-auth-secure-icon"></div>
				            </span>
                            <noscript>
                            <span class="bx-auth-secure" title="<?php echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
                                <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                            </span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = 'inline-block';
                            </script>
                            </td>
                            </tr>
                        <?php endif ?>
                        <tr class="mb-2">
                            <td><?= GetMessage('NEW_PASSWORD_CONFIRM') ?></td>
                            <td><input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off"/></td>
                        </tr>
                        
                    <?php endif ?>

                    </tbody>
                </table>



                <div><input type="submit" class="btn btn-primary" name="save" value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">&nbsp</div>
            </form>

        </div>



</div>
<script>
              $('body').on('change','input[name=drone]',function(e){
              if($(this).val()=='UF_FIZ'){
                $('#cont_poektorg input').attr('required',false);
                $('#cont_poektorg').hide('fast');
              }else{
                $('#cont_poektorg input').attr('required',true);
                $('#cont_poektorg').show('fast');
              }
            });
</script>