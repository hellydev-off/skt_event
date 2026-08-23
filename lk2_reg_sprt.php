<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(!in_array(12, $arGroups))die();
$id=intval($_REQUEST['id']);
$aSorevn=Aiplk::getSorevn($id);
$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
$aRegion=Aiplk::getRegionTitle($aSorevn);
$aCurRegion=Aiplk::getCurRegion($curUser);

$aSprt=Aiplk::getSportsmeny($aSorevn['ID'], 'Y', ['ACTIVE'=>'Y', 'IBLOCK_ID'=>6, 'PROPERTY_ID_SOREVN'=>$id, 'PROPERTY_REGION_SPR'=>$aCurRegion['UF_XML_ID']]);
$APPLICATION->SetTitle('Регистрация на '.$aSorevn['NAME']);
?>

<input type="hidden" name="ID_SOREVN" value="<?=$id?>">
<input type="hidden" name="TITLE_SOREVN" value="<?=$aSorevn['NAME']?>">

<a href="/lk.php" class="reg_sprt_back">Вернуться назад</a>
<div id="print_cont">
<div class="h1_cont">
  <h1>Заявка на участие в соревнованиях (<?=$aSorevn['NAME']?>)</h1>
  <div>&nbsp;</div>  
</div>
<hr>
<div class="reg_sprt_top1">
  <div>Команда:<span><?=Aiplk::getRegionSpr($aSorevn['PROPERTIES']['KOMANDA']['VALUE'])['NAME']?></span></div>
  <div>Вид спорта:<span>Спортивное метание ножа</span></div>
  <div>Даты проведения:<span><?=ConvertDateTime($aSorevn['DATE_ACTIVE_FROM'], "DD.MM.YYYY", "ru") ?> - <?= ConvertDateTime($aSorevn['DATE_ACTIVE_TO'], "DD.MM.YYYY", "ru")?></span></div>
  <div>Соревнования:<span><?=Aiplk::getUroven($aSorevn['PROPERTIES']['UROVEN']['VALUE'])['NAME']?></span></div>
  <div>Место проведения:<span><?=$aRegion['txt']?></span></div>
</div>
<br>


<?
$_aSprt=array();
$aDiscipl=array();
$_aDiscipl=array();
$aDiscSpr=Aiplk::getDisciplina();
foreach($aSprt as $sprt){
  if(empty($sprt['PROPERTIES']['DISCIPLINY']['VALUE']))$sprt['PROPERTIES']['DISCIPLINY']['VALUE']=array();
  $_aDiscipl=array_merge($_aDiscipl, $sprt['PROPERTIES']['DISCIPLINY']['VALUE']);
  $aSprtReg=Aiplk::getRegionTitle($sprt);
  $_aSprt[]=[
    $aSprtReg['r'],
    Aiplk::getFIO($sprt),//.$sprt['PROPERTIES']['REGION_SPR']['VALUE'],
    ConvertDateTime($sprt['USER_SPORTSMEN']['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru"),
    Aiplk::getRazryad($sprt['USER_SPORTSMEN']['UF_RAZR'])['NAME'],
    $aSprtReg['g'],
    Aiplk::getFIO($sprt['PROPERTIES']['TRENER']['VALUE']),
    $sprt['PROPERTIES']['KOMAND_ZACHET']['VALUE'],
    $sprt['ID'],
    $sprt['PROPERTIES']['DISCIPLINY']['VALUE']
  ];
}
foreach($aDiscSpr as $xml=>$row){
  if(in_array($xml, $_aDiscipl))$aDiscipl[$xml]=$row;
}
?>


<div class="table_cont">
  <table class="table_reg tbl_lk2_reg">
  <tbody>
    <tr>
      <th rowspan="2" style="max-width:60px">№</th>
      <!-- <th rowspan="2">Регион</th> -->
      <th rowspan="2">ФИО спортсменов</th>
      <th rowspan="2">Дата рождения</th>
      <th rowspan="2">Спорт. разряд, звание</th>
      <!-- <th rowspan="2">Город</th> -->
      <th rowspan="2">ФИО тренера</th>
      <th rowspan="2">Командный зачет</th>
      <th colspan="<?=count($aDiscipl)?>">Дисциплины</th>
      <th rowspan="2">Допуск врача</th>
      <th class="trashuga" rowspan="2"></th>
    </tr>
    <tr>
      <?foreach($aDiscipl as $row){?>
      <th><?=$row['UF_DESCRIPTION']?></th>
      <?}?>
    </tr>
  <?$i=0;foreach($_aSprt as $aItem){
    $i++;
    //v($sprt['PROPERTIES']['DISCIPLINY']['VALUE']);
  ?>
    <tr>
      <td><?=$i?></td>
      <!-- <td><?=$aItem[0]?></td> -->
      <td><?=$aItem[1]?></td>
      <td><?=$aItem[2]?></td>
      <td><?=$aItem[3]?></td>
      <!-- <td><?=$aItem[4]?></td> -->
      <td><?=$aItem[5]?></td>

      <?if(!empty($aItem[6])){?>
        <td data-user="<?=$aItem[7]?>" class="lk2_reg_chb lk2_reg_chb_active" data-field="KOMAND_ZACHET" data-value="2" data-html="К">К</td>
      <?}else{?>
        <td data-user="<?=$aItem[7]?>" class="lk2_reg_chb" data-field="KOMAND_ZACHET" data-value="2" data-html="К"></td>
      <?}?>
      <?foreach($aDiscipl as $xml=>$row){?>
        <?if(in_array($xml, $aItem[8])){?>
          <td data-xmlid="<?=$xml?>" data-user="<?=$aItem[7]?>" class="lk2_reg_chb lk2_reg_chb_active" data-field="disc" data-value="Y" data-html="+">+</td>
        <?}else{?>
            <td data-xmlid="<?=$xml?>" data-user="<?=$aItem[7]?>" class="lk2_reg_chb" data-field="disc" data-value="Y" data-html="+"></td>
        <?}?>
      <?}?>
      <td>&nbsp;</td>
      <td class="trashuga"><a data-id_sportsmen="<?=$aItem[7]?>" href="#" class="reg_del"><img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_trash.png" alt=""></a></td>
    </tr>
  <?}?>
  </tbody>
  </table>
</div>
<div class="lk2_reg_add_cont">
  <div class="dashed-border">
    <a href="#" data-sorevnid="<?=$aSorevn['ID']?>" id="reg_add">Добавить спортсмена</a>
  </div>  
</div>
<br>
<br>
<br>

<div class="podpisant_line2 podzasrant_tmp">
  <div class="podpisant_title" contenteditable="true"></div>
  <div>
    <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"></div><div>ФИО</div></div>
    <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>подпись</div></div>
    <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>м.п.</div></div>
  </div>
  <a href="#" class="podpisant_del">&nbsp;</a>
</div>

<?
$aPodp=json_decode($aSorevn['PROPERTIES']['PODZASRANTY']['~VALUE'], true);
if(empty($aPodp)){?>
<div class="podpisant_cont">
  <div>
    <div class="podpisant_line1">
      <div class="nowrap podpisant_title" contenteditable="true">Представитель команды</div>
      <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"></div><div>ФИО</div></div>
      <div>Указанные в настоящей заявке <span style="border-bottom:2px solid #d3e0e9;padding:0 20px"><?//=$i?></span>спортсмена(ов) по состоянию здоровья допущены к участию в соревнованиях по спортивному метанию ножа.</div>
    </div>
    <div class="podpisant_line2">
      <div class="podpisant_title" contenteditable="true">Руководитель региональной федерации/отделения:</div>
      <div>
        <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"></div><div>ФИО</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>подпись</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>м.п.</div></div>
      </div>
      <a href="#" class="podpisant_del">&nbsp;</a>
    </div>    
    <div class="podpisant_line2">
      <div class="podpisant_title" contenteditable="true">Врач:</div>
      <div>
        <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"></div><div>ФИО</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>подпись</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>м.п.</div></div>
      </div>
      <a href="#" class="podpisant_del">&nbsp;</a>
    </div>
    <div class="podpisant_line2">
      <div class="podpisant_title" contenteditable="true">Руководитель органа исполнительной власти в области физической культуры и спорта субъекта РФ</div>
      <div>
        <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"></div><div>ФИО</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>подпись</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>м.п.</div></div>
      </div>
      <a href="#" class="podpisant_del">&nbsp;</a>
    </div>
    <div class="podpisant_line2">
      <div class="podpisant_title" contenteditable="true">Главный врач:</div>
      <div>
        <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"></div><div>ФИО</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>подпись</div></div>
        <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>м.п.</div></div>
      </div>
      <a href="#" class="podpisant_del">&nbsp;</a>
    </div>    
  </div>
</div>
<?}else{
  $aFirst=array_shift($aPodp);
?>
<div class="podpisant_cont">
  <div>    
    <div class="podpisant_line1">
      <div class="nowrap podpisant_title" contenteditable="true"><?=$aFirst[0]?></div>
      <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"><?=$aFirst[1]?></div><div>ФИО</div></div>
      <div>Указанные в настоящей заявке <span style="border-bottom:2px solid #d3e0e9;padding:0 20px"><?//=$i?></span> спортсмена(ов) по состоянию здоровья допущены к участию в соревнованиях по спортивному метанию ножа.</div>
    </div>
    <?if(!empty($aPodp)){?>
      <?foreach($aPodp as $v){?>
      <div class="podpisant_line2">
        <div class="podpisant_title" contenteditable="true"><?=$v[0]?></div>
        <div>
          <div class="podpisant_field1 nowrap w25"><div class="podpisant_ed" contenteditable="true"><?=$v[1]?></div><div>ФИО</div></div>
          <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>подпись</div></div>
          <div class="podpisant_field1 nowrap w25"><div>&nbsp;</div><div>м.п.</div></div>
        </div>
        <a href="#" class="podpisant_del">&nbsp;</a>
      </div>
      <?}?>    
    <?}?>
  </div>
</div>
<?}?>
</div>
<br>
<br>
<br>
<div class="lk2_reg_add_cont">
  <div class="dashed-border1">
    <a href="#" class="add_podzasranta">Добавить подписанта</a>
  </div>  
</div>
<br>
<br>
<br>
<div class="reg_sprt_btn_cont">
  <a class="btn_otchet btn_podzasranty_save" href="#">Сохранить</a>
  <a class="btn_otchet" onclick="printDiv();return false" href="#"><img src="/local/templates/lk/img/btn_print.png"> Распечатать</a>
</div>

<script>
  $('body').on('click','.btn_podzasranty_save',function(e){    
    $('.overlay_loading').addClass('active');
    var ret=[];
    var p=$('.podpisant_cont>div>div');
    p.each(function(){
      ret.push([$(this).find('.podpisant_title').text(),$(this).find('.podpisant_ed').text()]);
    });
    $.post('/local/templates/lk/ajax/podpisant_save.php',{'ID_SOREVN':$('input[name=ID_SOREVN]').val(),'data':ret},function(data){
      if(data.err)console.log(data);
      else{
        $('.overlay_loading').removeClass('active');
      }
    });
    e.preventDefault();
    return false;
  });
  $('body').on('click','.add_podzasranta',function(e){  
    var t=$('.podzasrant_tmp').clone(true).appendTo($('.podpisant_cont>div')).removeClass('podzasrant_tmp');
    t.find('a.podpisant_del').show('fast');
    t.find('.podpisant_title').html('Новый заголовок...');
    t.find('.podpisant_ed').empty();
    e.preventDefault();
    return false;
  });
  $('body').on('click','.podpisant_del',function(e){
    var p=$(this).parent();
    p.hide('fast',function(){p.remove()});
    e.preventDefault();
    return false;
  });
  $('body').on('click','.lk2_reg_chb',function(e){
    var t=$(this);
    t.toggleClass('lk2_reg_chb_active');
    if(t.hasClass('lk2_reg_chb_active'))t.html(t.attr('data-html'));else t.empty();
    lk2_reg_update(t);
    e.preventDefault();
    return false;
  });
  function lk2_reg_update(t){
    var id=t.attr('data-user');
    var f=t.attr('data-field');
    var v=t.attr('data-value');
    var xmlid=t.attr('data-xmlid');
    if(!t.hasClass('lk2_reg_chb_active'))v='';
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/lk2_reg_update.php',{'SPRT_ID':id,'SPRT_FIELD':f,'SPRT_VAL':v,'XMLID':xmlid},function(data){
      if(!data.err){
        $('.overlay_loading').removeClass('active');
      }else console.log(data.err);
    },'json');
  }

  $('body').on('click','#reg_add',function(e){
    var _flt_gr=$('.flt_reg_block .lnk_active').attr('data-xmlid');
    $('.overlay_loading').addClass('active');
    $.post('/local/templates/lk/ajax/sorevn_reg.php',{'get':$(this).attr('data-sorevnid'),'flt_gr':_flt_gr,'reg_edit':'Y'},function(data){
      $('.popup.popup-object-reg .popup__title h2').html('Добавить участника');
      $('#form_object_reg').html(data);
      $('.popup.popup-object-reg').addClass('popup_open');
      cms_setselect2_form_object_reg();  
      $('.overlay_loading').removeClass('active');
    });
    e.preventDefault();
    return false;    
  }); 
  $('body').on('submit','#reg_edit_form',function(e){
    $('.overlay_loading').addClass('active');
    //console.log($(this).serialize());return false;
    $.post('/local/templates/lk/ajax/sorevn_reg.php',$(this).serialize(),function(data){
      if(data.err){
        alert(data.err);
        $('.overlay_loading').removeClass('active');
        return false;
      }
      //$('.overlay_loading').removeClass('active');
      window.location.reload();
    },'json');
    e.preventDefault();
    return false;
  });  
function cms_setselect2_form_object_reg(){
  $('#form_object_reg').find('.inp_tags_region').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_gorod.php',
      dataType: 'json',
      delay: 250
    }
  });
  $('#form_object_reg').find('.inp_tags_sportsmen').select2({
    'placeholder':'Не выбрано',
    'tags':false,
    'selectOnClose':false,
    'closeOnSelect':true,
    'ajax':{
      url: '/local/templates/lk/ajax/get_sportsmen.php?VGRUPPA='+$('input[name=VGRUPPA]').val(),
      dataType: 'json',
      delay: 250
    }
  }).on('select2:select',function(e){
    var data=e.params.data;
    if(data.region_val){
      var p=$(this).parents('#form_object_reg').find('.inp_tags_region');
      var newOption=new Option(data.region_txt, data.region_val, true, true);
      p.append(newOption).trigger('change');
    }
    if(data.data_rozhd){
      $(this).parents('#form_object_reg').find('.reg_data_rozhd').val(data.data_rozhd);
    }
    if(data.vozrast_gruppa_val){
      $('#reg_vgr').html(data.vozrast_gruppa_txt);
      $('input[name=VGRUPPA]').val(data.vozrast_gruppa_val);
      // var p=$(this).parents('#form_object_reg').find('.inp_vozrast_gruppa');
      // var newOption=new Option(data.vozrast_gruppa_txt, data.vozrast_gruppa_val, true, true);
      // p.append(newOption).trigger('change');
    }
  });
}
$('body').on('click','.reg_del',function(e){
  var t=$(this);
  var id=$(this).attr('data-id_sportsmen');
  if(!confirm('Вы уверены?'))return false;
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/delete_sportsmen.php',{'sportsmen_id':id, 'ID_SOREVN':$('input[name=ID_SOREVN]').val()},function(data){
    if(data.err)console.log(data);
    else{
      t.parents('tr').hide('fast');
      $('.overlay_loading').removeClass('active');
    }
  },'json');
  e.preventDefault();
  return false;
});  
function reg_update_data(){
  $('.popup__close').trigger('click');
}
$('.popup.popup-object-reg .popup__bgd, .popup.popup-object-reg .popup__close').on('click', function () {
  $('.popup.popup-object-reg').removeClass('popup_open');
});  
function printDiv(){
  window.print();
}
</script>

<style>
@media print{
  @page {size:A4 landscape;margin:10px;padding:0}  
  body {
    transform-origin: top left;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    font-size:12px;
  }  
  .reg_sprt_btn_cont,.lk2_reg_add_cont,
  .popup,br,a,.reg_del,#header,.l-navbar,.dashed-border1,.dashed-border,img{display:none!important}
  .podpisant_ed{background-image:none}
  .lk2_reg_chb{background-image:none!important}
  .table_reg{margin-top:30px;margin-bottom:30px;max-width:100px;font-size:12px;}
  td,th{padding:0!important;width:20px!important;border:none!important;box-shadow: none!important;}
  table{page-break-inside: auto}
  tr{page-break-inside: avoid}
  .reg_sprt_top1{gap:5px;font-size:12px;}
  .podpisant_line1,.podpisant_line2{font-size:12px;}
  .podpisant_cont>div{gap:10px}
  .table_cont{overflow: hidden;}
  h1{font-size:15px!important;font-weight:bold;}
  .h1_cont{margin-bottom:5px!important;}
  .trashuga{display:none}
  .table_reg tr:first-child th:first-child{border-top-left-radius:0}
}
</style>

<div class="popup popup-object-reg">
	<div class="popup__bgd">
	</div>
	<div class="popup__content">
		<div class="popup__close">
      <i class="bx bx-menu"></i>
		</div>
		<div>
			<div class="popup__title">
				<h2></h2>        
			</div>
			<div id="form_object_reg" method="post"></div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>