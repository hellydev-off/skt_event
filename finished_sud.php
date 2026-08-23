<?php
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<div class="table_cont">
  <table class="table_reg">
    <tr>
      <th>Мероприя</th>
      <th>Даты проведения</th>
      <th>Место проведения</th>
      <th>Должность</th>
      <th>Оценка</th>
    </tr>
    <?$aDiscAll=array();foreach($aSorevn as $aItem){?>
      <?$aSprtsm=Aiplk::getSprtCurrent($aItem['ID'])?>
      <tr>
        <td><?=$aItem['NAME']?></td>
        <td><?=ConvertDateTime($aItem['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> -<br><?= ConvertDateTime($aItem['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></td>
        <td><?=Aiplk::getRegionTitle($aItem)['txt']?></td>
        <td><?=$aDol[$aSprtsm['PROPERTIES']['DOLZHNOST']['VALUE']]['NAME']?></td>
        <td><?=$aOcenka[$aSprtsm['PROPERTIES']['OCENKA_GLAVNOGO']['VALUE']]['NAME']?></td>
      </tr>
    <?}?>
  </table>
</div>
