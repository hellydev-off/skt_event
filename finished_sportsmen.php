<?php
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if(isset($_REQUEST['xmlIdDisc']))$getxmlIdDisc=addslashes($_REQUEST['xmlIdDisc']);else $getxmlIdDisc=false;
?>
<div class="flex_reverse_col" id="moi_resultaty_sprtsmn">
  <div class="table_cont">
    <table class="table_reg">
      <tr>
        <th>Мероприя</th>
        <th>Даты проведения</th>
        <th>Место проведения</th>
        <th>Возрастная группа</th>
        <th>Этап</th>
        <th>Результат</th>
        <th>Место</th>
        <th>Разряд/звание</th>
      </tr>
      <?
      //var_dump('<pre>',$aSorevn);
      $aDiscAll=array();foreach($aSorevn as $aItem){?>
        <?
          $aSprtsm=Aiplk::getSprtCurrent($aItem['ID']);
          $aProgrammy=Aiplk::getProgrammy($aItem['ID'], true);      
          $aRes=array();
          foreach($aProgrammy as $row){
            $_aRes=Aiplk::getMestoFromProgramma($row)[$aSprtsm['ID']];
            if(!empty($_aRes[0]) and in_array($row['PROPERTIES']['DISCIPLINA']['VALUE'], $aSprtsm['PROPERTIES']['DISCIPLINY']['VALUE'])){
              $aDiscAll[$aDisc[$row['PROPERTIES']['DISCIPLINA']['VALUE']]['UF_XML_ID']]=$aDisc[$row['PROPERTIES']['DISCIPLINA']['VALUE']]['NAME'];
              $_aRes['ETAP']=$aEtap[$row['PROPERTIES']['ETAP']['VALUE']]['NAME'];
              $_aRes['DISC']=$aDisc[$row['PROPERTIES']['DISCIPLINA']['VALUE']]['NAME'];
              $_aRes['DISC_ID']=$aDisc[$row['PROPERTIES']['DISCIPLINA']['VALUE']]['ID'];
              $_aRes['DISC_XML_ID']=$aDisc[$row['PROPERTIES']['DISCIPLINA']['VALUE']]['UF_XML_ID'];
              $aRes[]=$_aRes;              
            }
          }
          if($aVozrgruppa[$aSprtsm['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']]['UF_POL']==3)$pol='M';else $pol='F';
          
          if(!$getxmlIdDisc and !empty($aRes)){
            $getxmlIdDisc=$aRes[0]['DISC_XML_ID'];
          }
          $aTmp=array();
          foreach($aRes as $_a)if($_a['DISC_XML_ID']==$getxmlIdDisc)$aTmp[]=$_a;
          $aRes=$aTmp;
          //var_dump('<pre>', $aRes);

          $rowspan=count($aRes);
          if($rowspan>0){
            $rowspan='rowspan="'.($rowspan+1).'"';
          }else{
            $rowspan='';          
          }
        ?>
        <tr>
          <td <?=$rowspan?>><?=$aItem['NAME']?></td>
          <td <?=$rowspan?>><?=ConvertDateTime($aItem['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> -<br><?= ConvertDateTime($aItem['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></td>
          <td <?=$rowspan?>><?=Aiplk::getRegionTitle($aItem)['txt']?></td>
          <td <?=$rowspan?>><?=$aVozrgruppa[$aSprtsm['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']]['NAME']?></td>
          <?if($rowspan){?>
        </tr>
                <?foreach($aRes as $rspan){
                      $newRazr=$aRazryadId[Aiplk::getRazryadRes($rspan['DISC_ID'], $pol, $rspan[1])['UF_RAZR']]['NAME'];
                      if(empty($newRazr))$newRazr=' - ';            
                ?>
                <tr class="__show_discipl __show_discipl_<?=$rspan['DISC_XML_ID']?>">
          
                        <td><?=$rspan['ETAP']?>, <?=$rspan['DISC']?></td>
                        <td><?=$rspan[1]?></td>
                        <td><?=$rspan[0]?></td>
                        <td><?=$newRazr?></td>
                </tr>
                <?}?>
        
          <?}else{?>
                
          
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
               
                <?}?>

      <?}?>
    </table>
  </div>
  <div class="reg_btn_cont flt_reg_block btn_block1">
    <?foreach($aDiscAll as $xmlIdDisc=>$disc){?>
      <a class="<?=(($getxmlIdDisc==$xmlIdDisc)?'lnk_active':'')?> lnk2" data-xmlid="<?=$xmlIdDisc?>" href="#"><?=$disc?></a>
    <?}?>
  </div>  
</div> 
<script>
$(document).ready(function(){
  $('body').on('click','.flt_reg_block a',function(e){
    $('.overlay_loading').addClass('active');
    $.post('/index.php',{'xmlIdDisc':$(this).attr('data-xmlid')},function(data){
      if(data){
        $('#moi_resultaty_sprtsmn').html($(data).find('#moi_resultaty_sprtsmn').html());
        $('.overlay_loading').removeClass('active');
      }
    });
    // $('.show_discipl').css('display','none');
    // $('.flt_reg_block a').removeClass('lnk_active');
    // $(this).addClass('lnk_active');
    // $('.show_discipl_'+$(this).attr('data-xmlid')).css('display','table-row');
     e.preventDefault();
     return false;
  });
  //$('.flt_reg_block a').eq(0).trigger('click');
});
</script>