<?php
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//var_dump('<pre>',Aiplk::getSprtCurrent($aItem['ID'])['PROPERTIES']['DISCIPLINY']['VALUE'],'</pre>');
// foreach($aProgrammy as $row){
//   $aRes[$row['PROPERTIES']['DISCIPLINA']['VALUE']]=$aDisc[$row['PROPERTIES']['DISCIPLINA']['VALUE']]['UF_DESCRIPTION'];
// }
// sort($aRes);
$aRes=Aiplk::getSprtCurrent($aItem['ID'])['PROPERTIES']['DISCIPLINY']['VALUE'];
?>
<div>
  <div class="disc_list_cont">
    <?foreach($aRes as $row){?>
      <div class="disc_list_name"><?=$aDisc[$row]['UF_DESCRIPTION']?></div>
    <?}?>
  </div>
</div>
<div>
  <?/*<a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_reg" href="#">Регистрация</a>*/?>
  <a data-id="<?=$aItem['ID']?>" class="btn btn-primary btn-sm lk_sorevn_protokoly" href="#">Протоколы</a>   
</div>