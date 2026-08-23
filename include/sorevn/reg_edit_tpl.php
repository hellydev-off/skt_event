<?php
//if(Aiplk::getStartPage()=='org' or (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($id)))$ed=true;else $ed=false;
if(!CSite::InGroup(array(1,11,12)))die('Нет доступа...');
if(!Aiplk::isEditable($id))$ed=false;
if(Aiplk::getStartPage()=='lk_region' or Aiplk::getStartPage()=='lk_ross')$ed=true;

$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
$curUserRegion=Aiplk::getRegionSprNew($curUser['UF_REGION_SPR']);

$aGruppa=Aiplk::getVozrastGuppa();
$aSorevn=Aiplk::getSorevn($id);
$aDisc=Aiplk::getDisciplina();
if($id_sportsmen){
  $aSportsmen=Aiplk::getSportsmen($id_sportsmen);
  $aUserSportsmen=Aiplk::getUser($aSportsmen['PROPERTIES']['SPORTSMEN']['VALUE']);
}else $aSportsmen=false;
?>
<a href="#" class="lnk2" onclick="reg_update_data();return false">Назад</a>
<h2 style="margin: 15px 0;"><?=$aSorevn['NAME']?></h2>
<form id="reg_edit_form">

  <?/*<div>Возрастная группа: <span id="reg_vgr"><?=$aGruppa[$_REQUEST['flt_gr']]['NAME']?></span></div>*/?>
  <div>Возрастная группа: <span id="reg_vgr">
  <?=(($aSportsmen)?$aGruppa[$aSportsmen['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']]['NAME']:$aGruppa[$_REQUEST['flt_gr']]['NAME'])?>
  </span></div>

  <input type="hidden" name="ID_SOREVN" value="<?=$id?>">
  <input type="hidden" name="id_sportsmen" value="<?=$id_sportsmen?>">
  <input type="hidden" name="TITLE_SOREVN" value="<?=$aSorevn['NAME']?>">
  <input type="hidden" name="VGRUPPA" value="<?=(($aSportsmen)?$aGruppa[$aSportsmen['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']]['UF_XML_ID']:$aGruppa[$_REQUEST['flt_gr']]['UF_XML_ID'])?>">
  <br>
  <div class="wrap-input100 form-outline mb-2">
    <span class="label-input">Спортсмен</span>
    <select required class="inp_tags_sportsmen form-control form-control-lg" data-f="SPORTSMEN" name="reg[USER_SPORTSMEN]">
      <option value="<?=(($aSportsmen)?$aSportsmen['PROPERTIES']['SPORTSMEN']['VALUE']:'')?>"><?=(($aSportsmen)?Aiplk::getFIO($aUserSportsmen):'')?></option>
    </select> 
  </div>
  <div class="form-outline mb-2 aip_line2">
    <div class="wrap-input100 form-outline mb-2">
      <span class="label-input">Дата рождения</span>
      <input disabled class="reg_data_rozhd form-control form-control-lg" type="date" maxlength="50" value="<?=(($aSportsmen)?ConvertDateTime($aUserSportsmen['PERSONAL_BIRTHDAY'], "YYYY-MM-DD", "ru"):'')?>"/>
    </div>    
  </div>
  <div class="wrap-input100 form-outline mb-2 inp_disabled">
      <span class="label-input">Регион</span>
			<?$aRegion=Aiplk::getRegionTitle($aSportsmen)?>
			<?if(empty($aRegion['val'])){?>
        <?if(empty($_r)){
          $aRegion=array('val'=>$curUserRegion['UF_XML_ID'], 'txt'=>$curUserRegion['NAME']);
        }else{
          $aRegion=Aiplk::getRegionTitle($_r);
        }?>
      <?}?>
      <select <?=((!$ed)?'disabled':'')?> required class="inp_tags_region form-control form-control-lg" data-f="REGION" name="reg[REGION]">
        <option value="<?=$aRegion['val']?>"><?=$aRegion['txt']?></option>
      </select>  
  </div>
  <div class="wrap-input100 form-outline mb-2">
    <span class="label-input">Дисциплины</span>
    <div class="reg_disc_cont">
      <?foreach($aDisc as $row){?>
      <label>
        <?if(empty($aSportsmen['PROPERTIES']['DISCIPLINY']['VALUE']))$aSportsmen['PROPERTIES']['DISCIPLINY']['VALUE']=[]?>
        <input <?=(($aSportsmen and in_array($row['UF_XML_ID'], $aSportsmen['PROPERTIES']['DISCIPLINY']['VALUE']))?'checked':'')?> name="reg[DISCIPLINY][]" value="<?=$row['UF_XML_ID']?>" type="checkbox">
        <span class="custom-checkbox"></span>
        <span><?=$row['NAME']?></span>
      </label>
      <?}?>
    </div>
  </div>
  <div class="wrap-input100 mt-4 btn_cont_1">
    <input type="submit" name="go" value="Сохранить" class="questionnaire_btn btn btn-primary">
  </div>
</form>