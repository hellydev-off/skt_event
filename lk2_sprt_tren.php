<?php
if(!empty($_REQUEST['ajax']))require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
else require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$curUser=Aiplk::getUser($GLOBALS['USER']->getID());
$arGroups=CUser::GetUserGroup($curUser['ID']);
if(!in_array(10, $arGroups))die();
$APPLICATION->SetTitle('Спортсмены');
$aUsers=Aiplk::getSprt4trener($curUser['ID']);//все спортсмены тренера
?>
<div>
<div class="h1_cont tren_item_title">
  <h1>Спортсмены</h1>
  <div class="inp_cont"><input type="text" id="grafik_inp_sprt"></div> 
</div>
<div class="merop_list_cont tren_item">
<?
$aSelectGod=array();
$aSelectDisc=array();
foreach($aUsers as $arResult){

  if(!empty($_REQUEST['ajax']) and !empty($_REQUEST['sprtId'])){
    $_REQUEST['sprtId']=intval($_REQUEST['sprtId']);
    if($arResult['ID']!=$_REQUEST['sprtId'])continue;
  }

  //filter
  $flt_god=false;
  $flt_disc=false;
  if(isset($_REQUEST['flt_god_'.$arResult['ID']]))$flt_god=intval($_REQUEST['flt_god_'.$arResult['ID']]);
  if(isset($_REQUEST['flt_disc_'.$arResult['ID']]))$flt_disc=addslashes($_REQUEST['flt_disc_'.$arResult['ID']]);
  //filter name
  if(!empty($_REQUEST['grafik_inp_sprt'])){
    $_name=addslashes($_REQUEST['grafik_inp_sprt']);
    $_curName=Aiplk::getFIO($arResult);
    if(mb_stripos($_curName, $_name)===false)continue;
  }
  ///

  //$_aPreparedSprtTblFlt=Aiplk::prepareSprtTblFromFilter($arResult['sprts'], 2025, 'd4m');
  $_aPreparedSprtTblFlt=Aiplk::prepareSprtTblFromFilter($arResult['sprts'], $flt_god, $flt_disc);
  
  
  $aSprtTblFlt=Aiplk::getSprtTblFromFilter($_aPreparedSprtTblFlt['tbl']);//получаем по соревнованиям за нужный год и нужной дисциплины
  $aSelectGod=array_merge($aSelectGod, $_aPreparedSprtTblFlt['filters']['GOD']);
  $aSelectDisc=array_merge($aSelectDisc, $_aPreparedSprtTblFlt['filters']['DISC']);
  $aStat=Aiplk::getSatisticSprt($_aPreparedSprtTblFlt['ALL']);

  if(isset($_aPreparedSprtTblFlt['PRG'][$aStat['maxPrgId']])){
    $aStat['allmax']=Aiplk::getMaxBallov($_aPreparedSprtTblFlt['PRG'][$aStat['maxPrgId']]);
  }else $aStat['allmax']=0;
  if(isset($_aPreparedSprtTblFlt['PRG'][$aStat['minPrgId']])){
    $aStat['allmin']=Aiplk::getMaxBallov($_aPreparedSprtTblFlt['PRG'][$aStat['minPrgId']]);
  }else $aStat['allmin']=0;


  //filter
  if(isset($_REQUEST['flt_god_'.$arResult['ID']]))$flt_god=intval($_REQUEST['flt_god_'.$arResult['ID']]);else $flt_god=false;//Aiplk::getFirst($_aPreparedSprtTblFlt['ALL_GOD']);
  if(isset($_REQUEST['flt_disc_'.$arResult['ID']]))$flt_disc=addslashes($_REQUEST['flt_disc_'.$arResult['ID']]);else $flt_disc=false;//Aiplk::getFirst($_aPreparedSprtTblFlt['ALL_DISC'], true);

  $aSprtIds=array();
  foreach($arResult['sprts'] as $_row)$aSprtIds[]=$_row['ID'];

  $arFile=CFile::GetFileArray($arResult['UF_PHOTO_SPRT']);
?>
  	<div class="merop_item grafik_item_<?=$arResult['ID']?>">
      <div class="tren_item_r">
        <div><img class="tren_item_photo" src="<?=$arFile['SRC']?>" alt=""></div>
        <div class="tren_item_c">
			    <div class="h4"><?=Aiplk::getFIO($arResult)?></div>
          <div class="tren_item_r">
            <?
              $dateFromField=$arResult['UF_TRENER_DATE_ADD'];
              if($dateFromField){
                $dateTimeObj = new DateTime($dateFromField);
                setlocale(LC_TIME, 'ru_RU.UTF-8', 'ru_RU', 'rus_RUS');
                $formattedDate = strftime('%e %B %Y, в %H:%M', $dateTimeObj->getTimestamp());
                $formattedDate = preg_replace('/^0/', '', $formattedDate);
            ?>
            <div class="tren_item_h2">Вас добавили в качестве тренера: <?=$formattedDate?></div><div>|</div>
            <?}?>
            <a class="tren_item_del" data-id="<?=$arResult['ID']?>" href="#">Удалить из моих спортсменов</a>
          </div>            
          <div class="tren_item_r tren_item_cell">
            <div><span>Дата рождения</span><span><?=ConvertDateTime($arResult['PERSONAL_BIRTHDAY'], "DD.MM.YYYY", "ru")?></span></div>
            <div><span>Возрастная группа</span><span><?=Aiplk::getVozrastGruppa($arResult)[2]['NAME']?></span></div>            
            <div><span>Разряд</span><span><?=Aiplk::getRazryad($arResult["UF_RAZR"])['NAME']?></span></div>            
            <div><span>Город</span><span><?=Aiplk::getRegionTitle($arResult)['g']?></span></div>            
            <div><span>Телефон</span><span><?=$arResult['PERSONAL_PHONE']?></span></div>            
            <div><span>Почта</span><span><?=$arResult['EMAIL']?></span></div>            
          </div>  
        </div>
      </div>
      <hr>
      <div class="tren_item_r mtb3020">
        <div class="tren_item_h1">Статистика спортсмена</div>


        <div>
          <select class="form-control form-control-lg inp_tags sel_tren_disc" data-id="<?=$arResult['ID']?>" name="flt_disc_<?=$arResult['ID']?>">
            <option value="">Все дисциплины</option>
            <?foreach($_aPreparedSprtTblFlt['ALL_DISC'] as $k=>$v){?>
              <option <?=(($flt_disc==$k)?'selected':'')?> value="<?=$k?>"><?=$v?></option>
            <?}?>
          </select>
        </div>        
        <div>
          <select class="form-control form-control-lg inp_tags sel_tren_god" data-id="<?=$arResult['ID']?>" name="flt_god_<?=$arResult['ID']?>">
            <option value="">За все года</option>
            <?foreach($_aPreparedSprtTblFlt['ALL_GOD'] as $k=>$v){?>
              <option <?=(($flt_god==$v)?'selected':'')?> value="<?=$v?>"><?=$v?></option>
            <?}?>
          </select>
        </div>
      </div>

      <?if(empty($aStat['average'])){?>
        <div>Нет данных</div>
      <?}else{?>

      <div class="tren_item_r progress_txt">
        <div>
          <span>Лучший результат на дистанции</span>
          <span class="progress_h1 progress_strelka"><span><?=$aStat['max']?></span> из <?=$aStat['allmax']?></span>
          <span class="progress_bar"><span style="width:<?=Aiplk::getProcent($aStat['max'], $aStat['allmax'])?>%!important"></span></span>
        </div>        
        <div>
          <span>Средний результат на дистанции</span>
          <span class="progress_h1"><span style="text-align:center;width:100%;display:inline-block"><?=$aStat['average']?></span></span>
          <?/*<span class="progress_bar"><span style="width:<?=Aiplk::getProcent($aStat['average'], $aStat['allmax'])?>%!important"></span></span>*/?>
        </div>        
        <div>
          <span>Худший результат на дистанции</span>
          <span class="progress_h1 progress_strelka"><span><?=$aStat['min']?></span> из <?=$aStat['allmin']?></span>
          <span class="progress_bar"><span style="width:<?=Aiplk::getProcent($aStat['min'], $aStat['allmin'])?>%!important"></span></span>
        </div>        
        <div>
          <span>Средняя динамика по зачетным сериям</span>
          <div class="tren_grafik_cont">
            <div class="tren_grafik_c"><canvas id="grafik_small_<?=$arResult['ID']?>" data-res='<?=json_encode($aSprtTblFlt, JSON_UNESCAPED_UNICODE)?>' class="tren_grafik"></canvas></div>         
            <?if(!empty($aSprtTblFlt)){?>
              <div><a data-sprtids='<?=json_encode($aSprtIds, JSON_UNESCAPED_UNICODE)?>' data-userid="<?=$arResult['ID']?>" class="tren_grafik_find" href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/lk2/ico_lupa_white.png" alt=""></a></div>
            <?}?>  
          </div>
        </div>
      </div>

    <?}?>

		</div>  	
  <?}?>
</div>
</div>





<?if(!isset($_REQUEST['ajax'])){?>

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


<script>
//глобальная сортировка все года и все дисциплины (не надо пока)  
<?
  $aSelectGod=array_unique($aSelectGod);
  $aSelectDisc=array_unique($aSelectDisc);
  asort($aSelectGod);
  asort($aSelectDisc);
?>
window.aSelectGod='<?=json_encode($aSelectGod, JSON_UNESCAPED_UNICODE)?>';
window.aSelectDisc='<?=json_encode($aSelectDisc, JSON_UNESCAPED_UNICODE)?>';
//
window.respd='';
$('body').on('change','#grafik_inp_sprt',function(e){
  $('.overlay_loading').addClass('active');
  var t=$(this);
  $.post('',{'ajax':'Y','grafik_inp_sprt':t.val()},function(resp){
    window.respd=resp;
    console.log(window.respd);
    d=$(resp).find('.merop_list_cont').html();
    $('.merop_list_cont').html(d);
    tren_graf_small_update();
    $('.overlay_loading').removeClass('active');
  });
});
$('body').on('change','.sel_tren_disc,.sel_tren_god',function(e){
  var id=$(this).attr('data-id');
  var ndisc='flt_disc_'+id;
  var ngod='flt_god_'+id;
  var flt_god=$('[name='+ngod+']').val();
  var flt_disc=$('[name='+ndisc+']').val();
  var data={};
  data['ajax']='Y';
  data['sprtId']=id;
  data[ndisc]=flt_disc;
  data[ngod]=flt_god;
  $('.overlay_loading').addClass('active');
  $.post('',data,function(resp){
    var d=$(resp).find('.grafik_item_'+id);
    if(d.length>0)$('.grafik_item_'+id).html(d.html());
    tren_graf_small_update();
    $('.overlay_loading').removeClass('active');
  });
  e.preventDefault();
  return false;
});

$('body').on('click','.tren_item_del',function(e){
  var t=$(this);
  $.post('/local/templates/lk/ajax/lk2_sprt_tren_user_del.php',{'SPRT_ID':t.attr('data-id')},function(data){
    if(data)console.log(data);
    else t.parents('div.merop_item').hide('fast',function(){$(this).remove()});
  });
  e.preventDefault();
  return false;
});
$('body').on('click','.tren_grafik_find',function(e){
  var _flt_gr=$('.flt_reg_block .lnk_active').attr('data-xmlid');
  var id=$(this).attr('data-userid');
  var disc=$('.grafik_item_'+id).find('select.sel_tren_disc').val();
  var god=$('.grafik_item_'+id).find('select.sel_tren_god').val();
  var sprtids=$(this).attr('data-sprtids');
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/tren_grafik_find.php',{'userid':id,'disc':disc,'god':god,'sprtids':sprtids},function(data){
    $('.popup.popup-object-reg .popup__title h2').css('display','none');
    $('#form_object_reg').html(data);
    $('.popup.popup-object-reg').addClass('popup_open');
    tren_graf_big_update();
    $('.overlay_loading').removeClass('active');
  });
  e.preventDefault();
  return false;    
}); 
$('.popup.popup-object-reg .popup__bgd, .popup.popup-object-reg .popup__close').on('click', function () {
  $('.popup.popup-object-reg').removeClass('popup_open');
}); 

function tren_graf_big_update(){
  const ctx = $('#tren_grafik_big')[0]; 
  var _data=$('#tren_grafik_big').attr('data-res');
  _data=JSON.parse(_data);  
  var _labels=_data.map((_, index) => `Зачётная серия ${index + 1}`);
  new Chart(ctx, {
    type: 'line',
    data: {
      labels:_labels,
      datasets: [{
        borderWidth: 2,
        borderColor: '#00a8ff',     // Ваш цвет линии
        pointRadius: 3,                 // Радиус точки 3px
        pointBackgroundColor: 'white', // Прозрачный фон внутри
        pointBorderColor: '#00a8ff',    // Цвет обводки (например, синий)
        pointBorderWidth: 2,     
        //label: '# of Votes',
        data:_data,
      }]
    },
    plugins: [ChartDataLabels],
    options: {
      maintainAspectRatio: false, // Обязательно, чтобы слушаться высоты div
      fill: true,                // Обязательно для заливки фона
      backgroundColor: '#f3faff', // Подставляем наш градиент
      tension:.5,
      scales: {
        x: {
          //ticks:{display: false},
          //grid:{display: false}
        },
        y: {
          //ticks:{display: false},
          //grid: {display: false}
        }
      },

      plugins: {
            legend:{display: false},    
            datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: function(value, context) {
                    const dataIndex = context.dataIndex;
                    const dataset = context.dataset.data;

                    // Если это самая первая точка, разницы нет
                    if (dataIndex === 0) {
                        return value; 
                    }

                    // Считаем разницу
                    const prevValue = dataset[dataIndex - 1];
                    const diff = value - prevValue;

                    // Форматируем вывод: добавляем + для положительных чисел
                    const sign = diff > 0 ? '+' : '';
                    //return `${value} (${sign}${diff})`;
                    return `${sign}${diff}`;
                },
                color: (context) => {
                    // Опционально: красим разницу (зеленый если выросло, красный если упало)
                    const i = context.dataIndex;
                    const d = context.dataset.data;
                    if (i === 0) return 'black';
                    return d[i] >= d[i-1] ? '#00a7ff' : '#ff3533';
                },

                //color: '#36A2EB', // цвет чисел
                // anchor: 'end', // Прижать метку к верхней границе точки
                // align: 'top',  // Расположить метку НАД границей (выше точки)
                // offset: 5,     // Расстояние в пикселях от точки до числа
                font: {
                    size:'25px',
                    weight: 'bold'
                },
                //formatter: Math.round // округлять, если числа дробные
            }

      }
    }
  });  
}
window.myCarts={};
tren_graf_small_update();
function tren_graf_small_update(){
  $('.tren_grafik').each(function(){
    const ctx = $(this)[0];
    if(window.myCarts[ctx.id]){
      window.myCarts[ctx.id].destroy();
    }
    const ctxс = ctx.getContext('2d');
    const gradient = ctxс.createLinearGradient(0, 0, 0, 61);
    gradient.addColorStop(0, '#c9ebff');
    gradient.addColorStop(0.25, '#d2eefe');
    gradient.addColorStop(0.5, '#daf1fd');
    gradient.addColorStop(0.75, '#e3f3fc');
    gradient.addColorStop(1, '#ecf6fb');
    var _data=$(this).attr('data-res');
    _data=JSON.parse(_data);
    if(typeof(_data)!='object'||_data.length==0){     
      $(ctx).parent().html('<div class="grafic_empty">Нет данных</div>');
      return true;
    }
    var _labels=_data.map((_, index) => `Зачётная серия ${index + 1}`);
    window.myCarts[ctx.id]=new Chart(ctx, {
      type: 'line',
      data: {
        labels: _labels,
        datasets: [{
          borderWidth: 2,
          borderColor: '#00a8ff',     // Ваш цвет линии
          pointRadius: 3,                 // Радиус точки 3px
          pointBackgroundColor: 'white', // Прозрачный фон внутри
          pointBorderColor: '#00a8ff',    // Цвет обводки (например, синий)
          pointBorderWidth: 2,     
          //label: '# of Votes',
          data: _data,
        }]
      },
      options: {
        maintainAspectRatio: false, // Обязательно, чтобы слушаться высоты div
        fill: true,                // Обязательно для заливки фона
        backgroundColor: gradient, // Подставляем наш градиент
        tension:.5,
        scales: {
          x: {
            ticks:{display: false},
            grid:{display: false}
          },
          y: {
            ticks:{display: false},
            grid: {display: false}
          }
        },
        plugins: {
              legend:{display: false},
        }
      }
    });  
  }); 
}

//big
$('body').on('change','#select_flt_disc,#select_flt_god',function(e){
  var disc=$('#select_flt_disc').val();
  var god=$('#select_flt_god').val();
  var userid=$('#flt_userid').val();
  var sprtids=$('#flt_sprids').val();
  $('.overlay_loading').addClass('active');
  $.post('/local/templates/lk/ajax/tren_grafik_find.php',{'ajax':'1','god':god,'disc':disc,'userid':userid,'sprtids':sprtids,'iskl_prgid':biggraf_getisklprg()},function(resp){
    $('.tren_grafik_flt_cont')[0].outerHTML=resp;
    tren_graf_big_update();
    $('.overlay_loading').removeClass('active');
  });
  e.preventDefault();
  return false;
});
function biggraf_getisklprg(){
  var ret=[];
  $('.biggraf_noprgid').each(function(){if(!$(this).is(':checked'))ret.push($(this).attr('data-prgid'))});
  return ret;
}
$('body').on('change','.biggraf_noprgid',function(e){
  $('#select_flt_disc').trigger('change');
  e.preventDefault();
  return false;
})
</script>
<?}?>

<?if(empty($_REQUEST['ajax']))require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>