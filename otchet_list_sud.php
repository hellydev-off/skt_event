<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Протоколы");
$APPLICATION->SetPageProperty("title", "Протоколы");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$ID_SOREVN=intval($_REQUEST['id_sorevn']);
if(empty($ID_SOREVN))LocalRedirect("/404.php", "404 Not Found");
$userGlSud=Aiplk::getGlavnSud($ID_SOREVN);
$userGlSudSekretar=Aiplk::getGlavnSudSekretar($ID_SOREVN);
$aSorevn=Aiplk::getSorevn($ID_SOREVN);
if($aSorevn['PROPERTIES']['STATUS']['VALUE']!='process')$closed=true;else $closed=false;
if(($GLOBALS['USER']->GetID()==$userGlSud['PROPERTIES']['SUDYA']['VALUE'] or Aiplk::getStartPage()=='org'/* or CSite::InGroup(array(1))*/) and !$closed)$me=true;else $me=false;
if(!Aiplk::isEditable($id))$me=false;
?>
<?//var_dump('<pre>',Aiplk::getGlavnSud($ID_SOREVN),'</pre>')?>
<?/*<input title="Стендов" value="<?=$aItem['PROPERTIES']['KOLVO_STENDOV']['VALUE']?>" name="SUD[KOLVO_STENDOV][]" required placeholder="Стендов" class="form-control form-control-lg" type="number">*/?>

<div id="print_cont">

<?if(empty($aSorevn)){?>
  <big>Нет данных</big>
<?}else{?>

<div class="item-list">
  <h1 class="block-title">СПРАВКА о судейской коллегии для проведения Чемпионата "<?=$aSorevn['NAME']?>" по спортивному метанию ножа</h1>
</div>  
<?/*<div class="bx-auth-profile"><h3><?=$aSorevn['NAME']?></h3></div>*/?>
<div style="border-bottom:0" class="prot_title_cont dubl">
  <div style="min-width:49%;"><span>Вид спорта:</span> <span>спортивное метание ножа</span></div>
  <div style="min-width:49%;"><span>Место проведения:</span> <span><?=Aiplk::getRegionTitle($aSorevn)['txt']?></span></div>
  <div style="min-width:49%;"><span>№ мероприятия:</span> <span>2009100017017407</span></div>
  <div style="min-width:49%;"><span>Даты проведения:</span> <span><?=ConvertDateTime($aSorevn['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($aSorevn['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></span></div>
</div>


<div class="table_cont">
<table class="table_reg">
  <tr>
    <th>№ п/п</th>
    <th>ФИО (полностью)</th>
    <th>Наименование спортивных судей</th>
    <th>Судейская категория</th>
    <th>Территория (город, субъект РФ)</th>
  </tr>
 <?$i=0;foreach(Aiplk::getSudyi($ID_SOREVN) as $row){$i++;?>
  <tr>
    <td><?=$i?></td>
    <td><?=Aiplk::getFIO($row['USER_SUDYA'])?><?//=var_dump('<pre>',$row['PROPERTIES']['DOLZHNOST']['VALUE'],'</pre>')?></td>
    <td><?=Aiplk::getDolzhnostSudi($row['PROPERTIES']['DOLZHNOST']['VALUE'])['NAME']?></td>
    <td><?=Aiplk::getKategoriiSudi($row['PROPERTIES']['KATEGORIYA']['VALUE'])['NAME']?></td>
    <td><?=Aiplk::getRegionTitle($row)['txt']?></td>
  </tr>
<?}?>
</table>
</div>
<?}?> 

<div style="border:none" class="prot_title_cont">
  <div><span>Главный спортивный судья:</span> <span><?=Aiplk::getFIO($userGlSud['USER_SUDYA'])?></span></div>
  <div></div>
  <div></div>
  <div><span>Главный спортивный судья-секретарь:</span> <span><?=Aiplk::getFIO($userGlSudSekretar['USER_SUDYA'])?></span></div>
</div> 

</div>
<br>
<a class="btn_otchet" onclick="printDiv();return false" href="#"><img src="/local/templates/lk/img/btn_print.png"> Распечатать</a>

<script>
function printDiv(){
  var divToPrint=document.getElementById('print_cont');
  var newWin=window.open('','СПРАВКА о судейской коллегии');
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},1000);
}
</script>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>