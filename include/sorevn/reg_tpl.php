<?
if(Aiplk::getStartPage()=='org' or (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($id)) or Aiplk::getStartPage()=='sport')$ed=true;else $ed=false;
if(!Aiplk::isEditable($id))$ed=false;
if(Aiplk::getStartPage()=='lk_region' or Aiplk::getStartPage()=='lk_ross')$ed=true;

if(!isset($_REQUEST['sort']))$sort='PROPERTY_SORT';else $sort=$_REQUEST['sort'];
if(!isset($_REQUEST['sortn']))$sortn='ASC';else $sortn=$_REQUEST['sortn'];
if(empty($_REQUEST['flt_gr']))$flt_gr=false;else $flt_gr=addslashes($_REQUEST['flt_gr']);
if(empty($_REQUEST['flt_disc']))$flt_disc=false;else $flt_disc=addslashes($_REQUEST['flt_disc']);

$aItems=Aiplk::getSportsmeny($id, 'Y', false, [$sort=>$sortn]);
if($sort=='PROPERTY_SORT' and $flt_disc)Aiplk::sortSprts($aItems, $flt_disc, $sortn);
$aItemsWait=Aiplk::getSportsmeny($id, 'N');
$aRazr=Aiplk::getRazryad();
$aDisc=Aiplk::getDisciplina();  
$aSorevn=Aiplk::getSorevn($id);
$aGruppa=Aiplk::getVozrastGuppa();
$aCurrentGroups=array();
$aCurrentDiscipl=array();

//v($id);

if($aSorevn['PROPERTIES']['STATUS']['VALUE']=='closed')$ed=false;

foreach($aGruppa as $_gr){
  foreach($aItems as $_item){
    if($_item['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']==$_gr['UF_XML_ID']){
      $aCurrentGroups[$_gr['UF_XML_ID']]=$_gr['NAME'];
    }
  }
}
//var_dump('<pre>', $_item,'</pre>');die();
foreach($aDisc as $_gr){
  foreach($aItems as $_item){
    if(empty($_item['PROPERTIES']['DISCIPLINY']['VALUE']))continue;
    if(in_array($_gr['UF_XML_ID'], $_item['PROPERTIES']['DISCIPLINY']['VALUE'])){
      $aCurrentDiscipl[$_gr['UF_XML_ID']]=$_gr['NAME'];
    }
  }
}
if($aSorevn['PROPERTIES']['REGISTRACIYA_OFF']['VALUE']=='Y')$regOff=true;else $regOff=false;
?>
<?if(1==2 and (!$regOff and !empty($aItemsWait) and $ed)){?>
<div>
<b style="display:block;margin-bottom:10px">Ожидают регистрации:</b>
<table class="table">
					<thead class="table__head">
						<tr>
							<th>Спортсмен</th>
							<th class="table__position--center">Дата рождения</th>
							<th class="table__position--center">Команда</th>
							<th class="table__position--center">Разряд</th>
							<th class="table__position--center">Дисциплины</th>
							<th class="table__position--center"></th>
						</tr>
					</thead>
					<tbody class="table__body">
          <?
            foreach($aItemsWait as $aItem){
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
							<td><?=$_r['LAST_NAME']?> <?=$_r['NAME']?> <?=$_r['SECOND_NAME']?> (<?=Aiplk::getVozrast($_r)?> <?=Aiplk::vozrastTitle(Aiplk::getVozrast($_r))?>)</td>
							<td><?=$startDate?></td>
							<td><?=$aRegion['txt']?></td>
							<td><?=$aRazr[$aItem['PROPERTIES']['RAZRYAD']['VALUE']]['NAME']?></td>
							<td>
                <?foreach($aItem['PROPERTIES']['DISCIPLINY']['VALUE'] as $_d){?>
                  <?=$aDisc[$_d]['UF_NAME']?>
                  <?}?> 
                </td>
              <td style="text-align:center"><input data-id="<?=$aItem['ID']?>" type="button" id="activate_sprtsn" value="Зарегистрировать" class="questionnaire_btn btn btn-primary"></td>
						</tr>            
          <?}?>  
          </tbody>
</table>
</div> 
<?}unset($aItem);?>




<input type="hidden" name="ID_SOREVN" value="<?=$id?>">
<input type="hidden" name="TITLE_SOREVN" value="<?=$aSorevn['NAME']?>">

<?//if(!empty($aItems)){?>

<div id="sf_cont">
  <div class="reg_btn_cont">
  <?if($ed){?>
    <a href="#" data-sorevnid="<?=$aSorevn['ID']?>" id="reg_add" class="lnk2 type_add">
      <i class="bx bx-plus"></i>&nbsp;
      Добавить
    </a>
  <?}?>
  <?if(!$regOff and Aiplk::getStartPage()=='lk_ross'){?>
    <a class="lnk2 type_red" id="end_cont_sh" href="#">закрыть регистрацию</a>
    <a class="lnk2 type_red_white" id="sf_cont_sh" href="#">жеребьевка</a>
  <?}elseif(Aiplk::getStartPage()=='lk_ross'){?>
    <?if($aSorevn['PROPERTIES']['STATUS']['VALUE']!='closed'){?>
      <a class="lnk2 type_red" id="start_cont_sh" href="#">Открыть регистрацию</a>
    <?}?>
  <?}?>
  </div>
  <h2><?=$aSorevn['NAME']?></h2>
  <div class="reg_btn_cont flt_reg_block">
    <?if(!$flt_gr or !isset($aCurrentGroups[addslashes($flt_gr)]))$flt_gr='all';?>
    <a class="<?=(($flt_gr=='all')?'lnk_active':'')?> lnk2" data-xmlid="all" href="#">Все группы</a>
    <?$i=0;foreach($aCurrentGroups as $xmlId=>$name){?>
      <a class="<?=(($flt_gr==$xmlId)?'lnk_active':'')?> lnk2" data-xmlid="<?=$xmlId?>" href="#"><?=$name?></a>
    <?}?>
  </div>  

  <div class="reg_btn_cont flt_reg_block2">
    <?if(!$flt_disc or !isset($aCurrentDiscipl[addslashes($flt_disc)]))$flt_disc='all';?>
    <a class="<?=(($flt_disc=='all')?'lnk_active':'')?> lnk2" data-xmlid="all" href="#">Все дисциплины</a>
    <?$i=0;foreach($aCurrentDiscipl as $xmlId=>$name){?>
      <a class="<?=(($flt_disc==$xmlId)?'lnk_active':'')?> lnk2" data-xmlid="<?=$xmlId?>" href="#"><?=$name?></a>
    <?}?>
  </div>

  <div class="table_cont">
    <table class="table_reg">
      <tr>
        <th class="col_sort <?=(($sort=='NAME')?'col_sort_active':'')?> <?=(($sortn=='DESC')?'desc':'')?>" data-field="NAME">Спортсмен</th>
        <th class="col_sort <?=(($sort=='PROPERTY_SORT')?'col_sort_active':'')?> <?=(($sortn=='DESC')?'desc':'')?>" data-field="PROPERTY_SORT">№</th>
        <th>Дата рождения</th>
        <th class="col_sort <?=(($sort=='PROPERTY_REGION')?'col_sort_active':'')?> <?=(($sortn=='DESC')?'desc':'')?>" data-field="PROPERTY_REGION">Регион</th>
        <th>Дисциплины</th>
        <?if($ed){?><th></th><?}?>
      </tr>
	
    <?$aItems=Aiplk::fltSportsmenGroup($aItems, $flt_gr, $flt_disc);
      $i=0;foreach($aItems as $aItem){$i++;
                  $_r=$aItem['USER_SPORTSMEN'];
                  $_rt=$aItem['USER_TRENER'];
                  //$aRegion=Aiplk::getRegionTitle($aItem);
    ?>
      <tr>
        <td><?=$_r['LAST_NAME']?> <?=$_r['NAME']?> <?=$_r['SECOND_NAME']?> (<?=Aiplk::getVozrast($_r)?> <?=Aiplk::vozrastTitle(Aiplk::getVozrast($_r))?>)</td>
        <td>
          <?=$aItem['_SORT']?>
          <?//=empty($aItem['PROPERTIES']['SORT']['VALUE'])?$i:$aItem['PROPERTIES']['SORT']['VALUE']?>
        </td>
        <td><?=ConvertDateTime($_r['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru")?></td>
        <td><?=$aItem['PROPERTIES']['REGION']['VALUE']?><?//=$aRegion['txt']?></td>
        <td>
          <?$_ret=[];foreach($aItem['PROPERTIES']['DISCIPLINY']['VALUE'] as $_d)$_ret[]=$aDisc[$_d]['UF_DESCRIPTION']?>
          <?=implode(', ', $_ret)?>
        </td>
        <?if($ed){?>
        <td style="text-align:center">
          <a class="reg_edit" data-id_sportsmen="<?=$aItem['ID']?>" href="#"><img src="/local/templates/lk/img/edit.svg" alt=""></a>
          <a class="reg_del" data-id_sportsmen="<?=$aItem['ID']?>" href="#"><img src="/local/templates/lk/img/delete.svg" alt=""></a>
        </td>
        <?}?>
      </tr>
    <?}?>
    </table>
  </div>
</div>
<?/*}else{?>
  Доступ ограничен, для регистрации на соревнования в качестве спортсмена, необходимо в настройках сперва включить профиль спортсмена и активировать его в меню слева.
<?}*/?> 
<br>
<br>
<br>