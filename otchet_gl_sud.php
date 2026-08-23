<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Протоколы");
$APPLICATION->SetPageProperty("title", "Протоколы");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$ID_SOREVN=intval($_REQUEST['id_sorevn']);
if(empty($ID_SOREVN))LocalRedirect("/404.php", "404 Not Found");
$userGlSud=Aiplk::getGlavnSud($ID_SOREVN);
$aSorevn=Aiplk::getSorevn($ID_SOREVN);
$aOcenka=Aiplk::getOcenkaSudi();

if($aSorevn['PROPERTIES']['STATUS']['VALUE']!='process')$closed=true;else $closed=false;
if(($GLOBALS['USER']->GetID()==$userGlSud['PROPERTIES']['SUDYA']['VALUE'] or Aiplk::getStartPage()=='org'/* or CSite::InGroup(array(1))*/) and !$closed)$me=true;else $me=false;
if(!Aiplk::isEditable($id))$me=false;
?>
<?//=var_dump('<pre>',Aiplk::getGlavnSud($ID_SOREVN),'</pre>')?>
<?/*<input title="Стендов" value="<?=$aItem['PROPERTIES']['KOLVO_STENDOV']['VALUE']?>" name="SUD[KOLVO_STENDOV][]" required placeholder="Стендов" class="form-control form-control-lg" type="number">*/?>

<?if(empty($aSorevn)){?>
  <big>Нет данных</big>
<?}else{?>

<form id="otchet_gl_sud_form">
<input type="hidden" name="id_sorevn" value="<?=$aSorevn['ID']?>">
<div class="table_cont">
<table class="table_reg">
  <tr>
    <th colspan="3"><center>1. Организация соревнований</center></th>
  </tr>
  <tr>
    <td style="width:70px">1</td>
    <td style="width:250px">Наименование соревнований</td>
    <td><?=$aSorevn['NAME']?></td>
  </tr>  
  <tr>
    <td>2</td>
    <td>Дата проведения соревнований</td>
    <td><?=ConvertDateTime($aSorevn['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($aSorevn['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></td>
  </tr>  
  <tr>
    <td>3</td>
    <td>Город и место проведения соревнований</td>
    <td><?=Aiplk::getRegionTitle($aSorevn)['txt']?></td>
  </tr>
  <tr>
    <td>4</td>
    <td>Спортивная организация</td>
    <td>
      <div class="td_cont"><textarea <?=((!$me)?'disabled':'')?> name="otchet[SPORT_ORG]"><?=$aSorevn['PROPERTIES']['SPORT_ORG']['VALUE']?></textarea></div>
    </td>
  </tr>
  <tr>
    <td>5</td>
    <td>Порядок проведения соревнований</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[PORYADOK]" ><?=$aSorevn['PROPERTIES']['PORYADOK']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <td>6</td>
    <td>Оценка орканизации соревнований</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[OCENKA_GLAVNOGO]" ><?=$aSorevn['PROPERTIES']['OCENKA_GLAVNOGO']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <td>7</td>
    <td>Выводы и предложения</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[VYVODY_GLAVNOGO]" ><?=$aSorevn['PROPERTIES']['VYVODY_GLAVNOGO']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <th colspan="3"><center>2. Популяризация соревнований</center></th>
  </tr>  
  <tr>
    <td>1</td>
    <td>Содержание и оценка проведенной работы по популяризации вида спорта</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[OCENKA_POP_GLAVNOGO]" ><?=$aSorevn['PROPERTIES']['OCENKA_POP_GLAVNOGO']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <td>2</td>
    <td>Общее количество зрителей, из них:</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[KOLVO_ZRITELEY]" ><?=$aSorevn['PROPERTIES']['KOLVO_ZRITELEY']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <td>2.1</td>
    <td>Офлайн (присутствующие на соревнованиях)</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[OFFLINE_ZRITELEY]" ><?=$aSorevn['PROPERTIES']['OFFLINE_ZRITELEY']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <td>2.2</td>
    <td>Онлайн (онлайн-трансляции, соц. сети и др.)</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[ONLINE_ZRITELEY]" ><?=$aSorevn['PROPERTIES']['ONLINE_ZRITELEY']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <th colspan="3"><center>3. Участники соревнований</center></th>
  </tr>  
  <?$sportsmenyAll=Aiplk::getSportsmeny($ID_SOREVN)?>  
  <tr>
    <td>1</td>
    <td>Количество допущеных участников</td>
    <td><?=count($sportsmenyAll)?></td>
  </tr>
  <tr>
    <td>3</td>
    <td>Количество спортсменов от каждого региона</td>
    <td>
      <?//var_dump('<pre>',Aiplk::getSudyi($ID_SOREVN),'</pre>')?>
      <table>
        <?foreach(Aiplk::getSportsmenyTblGorod($ID_SOREVN) as $gorod=>$scount){?>
        <tr>
          <td><?=$gorod?></td>
          <td><?=$scount?></td>
        </tr>
        <?}?>
      </table>
    </td>
  </tr>
  <tr>
    <td>4</td>
    <td>Разрядная квалификация</td>
    <td>
      <table>
        <?foreach(Aiplk::getSportsmenyTblRazryad($ID_SOREVN) as $gorod=>$scount){?>
        <tr>
          <td><?=$gorod?></td>
          <td><?=$scount?></td>
        </tr>
        <?}?>
      </table>      
    </td>
  </tr>
  <tr>
    <td>5</td>
    <td>Количество недопущеных/снятых участников судейской коллегией, в том числе из-за неявки (персонально) и по заключению врача (персонально)</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[KOLVO_SNYATYH_UCH]"><?=$aSorevn['PROPERTIES']['KOLVO_SNYATYH_UCH']['VALUE']?></textarea></div></td>
  </tr>
  <tr>
    <th colspan="3"><center>4. Спортивная оценка соревнований</center></th>
  </tr>  
  <tr>
    <td>1</td>
    <td>Количество участников, выполнивших нормативы разрядов</td>
    <td></td>
  </tr>   
  <tr>
    <td>2</td>
    <td>Количество претендентов на участие в вышестоящих соревнованиях</td>
    <td></td>
  </tr>   
  <tr>
    <th colspan="3"><center>5. Судейство</center></th>
  </tr> 
  <tr>
    <td>1</td>
    <td colspan="2">
      <table>
        <tr>
          <td>ФИО</td>
          <td>Должность</td>
          <td>Категория</td>
          <td>Оценка</td>
        </tr>
        <?foreach(Aiplk::getSudyi($ID_SOREVN) as $row){?>
        <tr>
          <td><?=Aiplk::getFIO($row['PROPERTIES']['SUDYA']['VALUE'])?></td>
          <td><?=Aiplk::getDolzhnostSudi($row['PROPERTIES']['DOLZHNOST']['VALUE'])['UF_NAME']?></td>
          <td><?=Aiplk::getKategoriiSudi($row['PROPERTIES']['KATEGORIYA']['VALUE'])['UF_NAME']?></td>
          <td>
            <div class="td_cont">
              <select <?=((!$me)?'disabled':'')?> name="sud[<?=$row['ID']?>]">
                <?foreach($aOcenka as $oc){?>
                  <option <?=(($oc['UF_XML_ID']==$row['PROPERTIES']['OCENKA_GLAVNOGO']['VALUE'])?'selected':'')?> value="<?=$oc['UF_XML_ID']?>"><?=$oc['NAME']?></option>
                <?}?>
              </select>
            </div>
          </td>
        </tr>
        <?}?>
      </table>
    </td>
  </tr>   
  <tr>
    <td>2</td>
    <td>Количество поданных заявлений</td>
    <td>
      <table>
        <tr>
          <td style="width:50%;padding: 0;">Удовлетворительно</td>
          <td style="width:50%;padding: 0;">Отклонено</td>
        </tr>
        <tr>
          <td><div class="td_cont1"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[ZAYAVL_UD_GLAVNOGO]"><?=$aSorevn['PROPERTIES']['ZAYAVL_UD_GLAVNOGO']['VALUE']?></textarea></div></td>
          <td><div class="td_cont1"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[ZAYAVL_NEUD_GLAVNOGO]"><?=$aSorevn['PROPERTIES']['ZAYAVL_NEUD_GLAVNOGO']['VALUE']?></textarea></div></td>
        </tr>
      </table>
    </td>
  </tr>   
  <tr>
    <td>3</td>
    <td>Предложения по изменению и уточнению Правил, системы и способов проведения соревнований и тд.</td>
    <td><div class="td_cont"><textarea <?=((!$me)?'disabled':'')?>  name="otchet[PREDLOZHENIYA]"><?=$aSorevn['PROPERTIES']['PREDLOZHENIYA']['VALUE']?></textarea></div></td>
  </tr>   
</table>
</div>
<div>
  <div><?=Aiplk::getGlavnSud($ID_SOREVN)['NAME']?></div>
</div>
<br>
<br>
<br>
<div>
  <div class="otchet_err"></div>
  <?if($me){?>
    <input class="otchet_gl_save btn_otchet" type="submit" value="Сохранить / Завершить соревнование">
  <?}?>
  <?if($closed and Aiplk::isGlavSud($aSorevn['ID'])){?>
    <a class="btn_otchet otchet_gl_return" data-id="<?=$aSorevn['ID']?>" href="#">Вернуть на доработку</a>
  <?}?>
</div>
</form>
<br>
<a class="btn_otchet" onclick="printDiv();return false" href="#"><img src="/local/templates/lk/img/btn_print.png"> Распечатать</a>
<script>
  $('.otchet_gl_return').click(function(e){
  $.post('/local/templates/lk/ajax/otchet_gl_sud_return.php',{'id_sorevn':$(this).attr('data-id')},function(data){
    if(data.err)$('.otchet_err').html(data.err);
    else location.reload();
  },'json');
  e.preventDefault();
  return false;
});
$('#otchet_gl_sud_form').submit(function(e){
  $.post('/local/templates/lk/ajax/otchet_gl_sud.php',$(this).serialize(),function(data){
    if(data.err)$('.otchet_err').html(data.err);
    else location.reload();
  },'json');
  e.preventDefault();
  return false;
});
function printDiv(){
  var divToPrint=document.getElementById('otchet_gl_sud_form');
  var newWin=window.open('','Отчет главного судьи');
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},1000);
}
</script>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>