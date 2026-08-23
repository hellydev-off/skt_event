<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,10,11,12)))die('Нет доступа...');
$ajax=intval($_REQUEST['ajax']);
if(empty($_REQUEST['iskl_prgid']) or !is_array($_REQUEST['iskl_prgid']))$iskl_prgid=array();
//v($_REQUEST);
$sprtIds=json_decode($_REQUEST['sprtids'], true);
$userId=intval($_REQUEST['userid']);
//filter
  $flt_god=false;
  $flt_disc=false;
 if(isset($_REQUEST['god']))$flt_god=intval($_REQUEST['god']);
 if(isset($_REQUEST['disc']))$flt_disc=addslashes($_REQUEST['disc']);
///
$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
$arResult=Aiplk::getSportsmens($sprtIds);//все спортсмены (для программ, 1 спрт = 1 соревнование и несколько программ)
$_aPreparedSprtTblFlt=Aiplk::prepareSprtTblFromFilter($arResult, $flt_god, $flt_disc);
$aSprtTblFlt=Aiplk::getSprtTblFromFilter($_aPreparedSprtTblFlt['tbl'], $iskl_prgid);//получаем по соревнованиям за нужный год и нужной дисциплины
//v($aSprtTblFlt); 
?>
<div class="tren_grafik_flt_cont">
  <input type="hidden" id="flt_sprids" value='<?=$_REQUEST['sprtids']?>'>
  <input type="hidden" id="flt_userid" value='<?=$userId?>'>
  <div class="h1_cont tren_item_title">
    <h1>Средняя динамика по зачетным сериям</h1>
    <div>&nbsp;</div>
  </div> 
  <div class="tren_item_r">
    <div class="tren_item_h1 cblue"><?=Aiplk::getFIO($userId)?></div>
    <div>
      <select class="form-control form-control-lg inp_tags" name="" id="select_flt_disc">
        <option value="">Все дисциплины</option>
            <?foreach($_aPreparedSprtTblFlt['ALL_DISC'] as $k=>$v){?>              
              <option <?=(($flt_disc==$k)?'selected':'')?> value="<?=$k?>"><?=$v?></option>
            <?}?>
      </select>
    </div>        
    <div>
      <select class="form-control form-control-lg inp_tags" name="" id="select_flt_god">
        <option value="">За все года</option>
            <?foreach($_aPreparedSprtTblFlt['ALL_GOD'] as $k=>$v){?>
              <option <?=(($flt_god==$v)?'selected':'')?> value="<?=$v?>"><?=$v?></option>
            <?}?>
      </select>
    </div>
  </div>
      <?
        $aItems=array();
        $sredBall=[];
        foreach($_aPreparedSprtTblFlt['tbl'] as $sprtId=>$_aTbl){
          foreach($_aTbl as $prgId=>$aTbl){
            $aPrg=$_aPreparedSprtTblFlt['PRG'][$prgId];
            $aSorevn=Aiplk::getSorevnFromId($aPrg['PROPERTIES']['ID_SOREVN']['VALUE']);
            $aItems[]=[
              'sort'=>MakeTimeStamp($aPrg['PROPERTIES']['VREMYA_NACH']['VALUE']),
              'sprtid'=>$sprtId,
              'prgid'=>$aPrg['ID'],
              'sorevnid'=>$aPrg['PROPERTIES']['ID_SOREVN']['VALUE'],
              'vremz_nach_prg'=>ConvertDateTime($aPrg['PROPERTIES']['VREMYA_NACH']['VALUE'], "DD.MM.YYYY", "ru"),
              'sorevnname'=>$aSorevn['NAME'],
              'prgname'=>$aPrg['NAME'],
              'gorod'=>Aiplk::getRegionTitle($aSorevn)['g'],
              'mesto'=>$aTbl['MESTO'],
              'ballov'=>$aTbl['OCHKOV']
            ];
            $sredBall[]=intval($aTbl['OCHKOV']);
          }
        }        
        usort($aItems, function($a, $b){
          if($a['sort']==$b['sort'])return 0;
          return $a['sort'] < $b['sort']?1:-1;
        });        
      ?>
  <div style="margin-bottom:10px" class="h1_cont mtb3020">
    <div class="gr_big">Список соревнований <span class="cblue">
    <?=((!empty($flt_god))?'за '.$flt_god.' год':'за все года')?>
    , 
    <?=((!empty($_aPreparedSprtTblFlt['ALL_DISC'][$flt_disc]))?$_aPreparedSprtTblFlt['ALL_DISC'][$flt_disc]:'все дистанции')?>
    </span></div>
    <?if(!empty($sredBall)){?><div class="gr_big">Средние общие баллы <span class="cblue" id="gr_big_srednie_bally"><?=round((array_sum($sredBall)/count($sredBall)), 0)?></span></div><?}?>
  </div>    

  <div class="tren_grafik_big_c"><canvas id="tren_grafik_big" data-res='<?=json_encode($aSprtTblFlt, JSON_UNESCAPED_UNICODE)?>'></canvas></div>  

  <div class="table_cont">
    <table class="graf_tbl">

      <?foreach($aItems as $row){?>
      <tr>
        <td style="background:none">
          <label>
            <?
            $ch='checked';
            if(in_array($row['prgid'], $iskl_prgid))$ch='';
            ?>
            <input class="biggraf_noprgid" <?=$ch?> data-sorevnid="<?=$row['sorevnid']?>" data-sprtid="<?=$row['sprtid']?>" data-prgid="<?=$row['prgid']?>" type="checkbox">
            <span class="custom-checkbox"></span>
          </label>
        </td>
        <td><?=$row['vremz_nach_prg']?></td>
        <td class="graf_wrap"><?=$row['sorevnname']?><br><small style="color:gray"><?=$row['prgname']?></small></td>
        <td><?=$row['gorod']?></td>
        <td><?=$row['mesto']?> место</td>
        <td class="cblue"><?=$row['ballov']?> баллов</td>
      </tr>
      <?}?>

    </table>
  </div>
</div>