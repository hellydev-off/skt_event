<?
//if(!CSite::InGroup(array(1,9)))die('Нет доступа.');
$aItems=Aiplk::getProgrammy($id);
$aSorevn=Aiplk::getSorevn($id);
//var_dump('<pre>',$aItems,'</pre>');
?>
<input type="hidden" value="<?=$aSorevn['ID']?>" id="ID_SOREVN">
<h2 style="font-weight:normal"><?=$aSorevn['NAME']?></h2>
<?if(!empty($aItems)){?>
<div class="table_cont is_desktop">
<table class="table_reg">
  <tr>
    <th>Возрастная группа</th>
    <th>Дисципплина</th>
    <th>Дата</th>
    <th>Время</th>
    <th>Этап</th>
    <?if(Aiplk::getStartPage()!='sud' and Aiplk::getStartPage()!='sport' and Aiplk::getStartPage()!='lk_region'){?>
    <th>1-ая смена</th>
    <th>1-й стенд</th>
    <?}?>
    <th>&nbsp;</th>
  </tr>
<?foreach($aItems as $aItem){
  $vr=ConvertDateTime($aItem['PROPERTIES']['VREMYA_NACH']['VALUE'], "HH:MI", "ru");
  if($vr=='00:00')$vr='';
  if(empty($aItem['PROPERTIES']['SO_STENDA']['VALUE']))$aItem['PROPERTIES']['SO_STENDA']['VALUE']=1;
  if(empty($aItem['PROPERTIES']['S_SERII']['VALUE']))$aItem['PROPERTIES']['S_SERII']['VALUE']=1;
?>
  <tr>
    <td><?=Aiplk::getVozrastGuppa($aItem['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'])['NAME']?></th>
    <td><?=Aiplk::getDisciplina($aItem['PROPERTIES']['DISCIPLINA']['VALUE'])['NAME']?></td>
    <td><?=ConvertDateTime($aItem['PROPERTIES']['VREMYA_NACH']['VALUE'], "DD.MM.YYYY", "ru")?></th>
    <td><?=$vr?></td>
    <td><?=Aiplk::getEtap($aItem['PROPERTIES']['ETAP']['VALUE'])['NAME']?></td>
    <?if(Aiplk::getStartPage()!='sud' and Aiplk::getStartPage()!='sport' and Aiplk::getStartPage()!='lk_region'){?>
      <td><input data-id_prog="<?=$aItem['ID']?>" class="inp_prog_s_serii" style="width: 100px;text-align: center;" type="number" value="<?=$aItem['PROPERTIES']['S_SERII']['VALUE']?>"></td>
      <td><input data-id_prog="<?=$aItem['ID']?>" class="inp_prog_so_stenda" style="width: 100px;text-align: center;" type="number" value="<?=$aItem['PROPERTIES']['SO_STENDA']['VALUE']?>"></td>
    <?}?>  
    <td style="padding:3px;min-width:150px"><a target="_blank" style="background:#07a8ff;width:100%;height:55px;border:none;font-size:17px" class="btn btn-primary btn-sm" href="/protokol.php?id_programma=<?=$aItem['ID']?>">Перейти</a></td>
  </tr>
<?}?>
</table>
</div>  

<div class="is_mobile protokol_list_cont">
<?foreach($aItems as $aItem){
  $vr=ConvertDateTime($aItem['PROPERTIES']['VREMYA_NACH']['VALUE'], "HH:MI", "ru");
  if($vr=='00:00')$vr='';
  if(empty($aItem['PROPERTIES']['SO_STENDA']['VALUE']))$aItem['PROPERTIES']['SO_STENDA']['VALUE']=1;
  if(empty($aItem['PROPERTIES']['S_SERII']['VALUE']))$aItem['PROPERTIES']['S_SERII']['VALUE']=1;
?>
  <div>
    <h3><?=Aiplk::getEtap($aItem['PROPERTIES']['ETAP']['VALUE'])['NAME']?></h3>
    <div><span>Дата</span><span><?=ConvertDateTime($aItem['PROPERTIES']['VREMYA_NACH']['VALUE'], "DD.MM.YYYY", "ru")?></span></div>
    <div><span>Время</span><span><?=$vr?></span></div>
    <div><span>Возрастная группа</span><span><?=Aiplk::getVozrastGuppa($aItem['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'])['NAME']?></span></div>
    <div><span>Дисципплина</span><span><?=Aiplk::getDisciplina($aItem['PROPERTIES']['DISCIPLINA']['VALUE'])['NAME']?></span></div>
    <?if(Aiplk::getStartPage()!='sud' and Aiplk::getStartPage()!='sport'){?>
      <div><span>1-ая смена</span><span><input data-id_prog="<?=$aItem['ID']?>" class="inp_prog_s_serii" style="width: 100px;text-align: center;" type="number" value="<?=$aItem['PROPERTIES']['SO_STENDA']['VALUE']?>"></span></div>
      <div><span>1-й стенд</span><span><input data-id_prog="<?=$aItem['ID']?>" class="inp_prog_so_stenda" style="width: 100px;text-align: center;" type="number" value="<?=$aItem['PROPERTIES']['S_SERII']['VALUE']?>"></span></div>
    <?}?>  
    <div><span></span><a href="/protokol.php?id_programma=<?=$aItem['ID']?>" class="protbtnmob">Перейти</a></div>
  </div>
<?}?>
</div>
<?if(Aiplk::getStartPage()!='sud' and Aiplk::getStartPage()!='sport'){?>
<div class="wrap-input100 mt-4 btn_cont_1">
  <input type="button" id="btn_prot_save" name="go" value="Сохранить" class="questionnaire_btn btn btn-primary disabled">
</div>
<?}?>
<?}else{?>
<center>Пусто...</center>
<?}?>