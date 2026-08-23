<?
if(Aiplk::getStartPage()=='sport')$ed=true;else $ed=false;
$aSor=Aiplk::getSorevn($id);
if(!Aiplk::isEditable($aSor))$ed=false;
$aItems=Aiplk::getSportsmeny($id);
//var_dump('<pre>',$aItems,'</pre>');
?>



<?/*
<table class="table">
					<thead class="table__head">
						<tr>
							<th>№</th>
							<th>Спортсмен</th>
							<th class="table__position--center">Дата рождения</th>
							<th class="table__position--center">Команда</th>
							<th class="table__position--center">Тренер</th>
							<th class="table__position--center">Разряд</th>
							<th class="table__position--center">Дисциплины</th>
						</tr>
					</thead>
					<tbody class="table__body">
          <?
            $i==0;
            $aRazr=Aiplk::getRazryad();
            $aDisc=Aiplk::getDisciplina();
            foreach($aItems as $aItem){
              //var_dump($aItem['USER_SPORTSMEN'],$GLOBALS['USER']->GetId());
              //if($aItem['USER_SPORTSMEN']['ID']==$GLOBALS['USER']->GetId())$ed=false;
              $i++;
              $_r=$aItem['USER_SPORTSMEN'];
              $_rt=$aItem['USER_TRENER'];
              $aRegion=Aiplk::getRegionTitle($aItem);
              $startDate=ConvertDateTime($_r['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru");
              //var_dump('<pre>',$aDisc,'</pre>');
          ?>
						<tr>
							<td>№ <?=$i?></td>
							<td><?=$_r['LAST_NAME']?> <?=$_r['NAME']?> <?=$_r['SECOND_NAME']?> (<?=Aiplk::getVozrast($_r)?> <?=Aiplk::vozrastTitle(Aiplk::getVozrast($_r))?>)</td>
							<td><?=$startDate?></td>
							<td><?=$aRegion['txt']?></td>
							<td><?=$_rt['LAST_NAME']?> <?=$_rt['NAME']?> <?=$_rt['SECOND_NAME']?></td>
							<td><?=$aRazr[$aItem['PROPERTIES']['RAZRYAD']['VALUE']]['NAME']?></td>
							<td>
                <?foreach($aItem['PROPERTIES']['DISCIPLINY']['VALUE'] as $_d){?>
                  <?=$aDisc[$_d]['UF_NAME']?>
                <?}?> 
              </td>
						</tr>            
          <?}?>  
          </tbody>
</table>
*/?>




<?
$wait=false;
$au=Aiplk::getSprtCurrent($id);
if($au['ACTIVE']=='N'){
  $wait=true;
  $ed=false;
}
?>
<?if($wait){$ed=false;?>
  <div>Вы уже отправили заявку, ожидайте подтверждения</div>
<?}elseif(!empty(Aiplk::getSprtCurrent($id))){$ed=false;?>
  <div>Вы уже зарегистрированны</div>
<?}?>  
<?if($aSor['PROPERTIES']['REGISTRACIYA_OFF']['VALUE']=='Y'){$ed=false;?>
  <div>Регистрация окончена</div>
<?}?>  
<?if($ed){
  $aUser=Aiplk::getUser($GLOBALS['USER']->GetId());
  $aReg=Aiplk::getRegionTitle($aUser);
  $vozrastGruppa=Aiplk::getVozrastGruppa($aUser);  
?>
  <form id="sf_cont" class="reg_zayavka">
    <input type="hidden" name="ID_SOREVN" value="<?=$id?>">
    <input type="hidden" name="TITLE_SOREVN" value="<?=$aSor['NAME']?>">

    <h2 style="margin: 15px 0;"><?=$aSor['NAME']?></h2>
    <div class="text">
      <?=$aSor['PROPERTIES']['DESCR']['VALUE']?>
    </div>
    <br>
    <span class="label-input">Дисциплины</span>
    <br>
    <div class="reg_disc_cont">
      <?foreach(Aiplk::getDisciplina() as $_r){?>
      <label>
        <input name="reg[DISCIPLINY][]" value="<?=$_r['UF_XML_ID']?>" type="checkbox">
        <span class="custom-checkbox"></span>
        <span><?=$_r['NAME']?></span>
      </label>
      <?}?>
    </div>
    <br>
    <?foreach($aSor['PROPERTIES']['DOCS']['VALUE'] as $fId){
      $af=CFile::GetFileArray($fId);
    ?>
      <a style="color:black;display:block" href="<?=$af['SRC']?>"><?=$af['FILE_NAME']?></a>
    <?}?>
    <br>
    <br>
    <div class="wrap-input100 mt-4 btn_cont_1">
      <input type="button" name="go" value="Отправить заявку на участие" class="reg_zayavka_btn questionnaire_btn btn btn-primary">
    </div>
  </form>
<?}?>