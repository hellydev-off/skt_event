<?
//var_dump(Aiplk::getGlavnSud($id)['PROPERTIES']['SUDYA']['VALUE'], Aiplk::isGlavSud($id));
if(Aiplk::isEditable($id) and (Aiplk::getStartPage()=='lk_ross' or (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($id))))$ed=true;else $ed=false;
$aItems=Aiplk::getProgrammy($id);
//v($aItems);
$aItems=Aiplk::prepareProgrammy($aItems);
$aSorevn=Aiplk::getSorevn($id);
$aVozrgruppa=Aiplk::getVozrastGuppa();
$aDiscipl=Aiplk::getDisciplina();
$aVarEtap=Aiplk::getVariantEtap();
$aVarStend=Aiplk::getVariantStend();
if(empty($aItems))$aItems=array([false]);

?>
<h2 style="margin: 15px 0;"><?=$aSorevn['NAME']?></h2>
<input type="hidden" name="ID_SOREVN" value="<?=$id?>">
<div class="prog_cont">

<?foreach($aItems as $aItem){?>

  <div class="prog_item">
    <div class="aip_line2">
      <div class="w_200">
        <span class="line_note">Возрастная группа:</span>
        <?if(empty($aItem['VOZRAST_GRUPPA']))$aItem['VOZRAST_GRUPPA']=array();?>
        <select onchange="cms_prg_get_kolvo($(this).parents('div.prog_item'))" <?=((!$ed)?'disabled':'')?> required class="inp_tags prog_vozrgr form-control form-control-lg" data-f="VOZRAST_GRUPPA" name="SUD[<?=$aItem['ID']?>][VOZRAST_GRUPPA][]">
        <option value="">Возрастная группа</option>
        <?foreach(Aiplk::getVozrastGuppa() as $_r){?>
          <option <?=(($aItem['VOZRAST_GRUPPA']['UF_XML_ID']==$_r['UF_XML_ID'])?'selected':'')?> value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
        <?}?>
        </select>
      </div>
      <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
      <div class="w_200">
        <span class="line_note">Дисциплина:</span>
        <select onchange="cms_prg_get_kolvo($(this).parents('div.prog_item'))" <?=((!$ed)?'disabled':'')?> required class="inp_tags prog_discipl form-control form-control-lg" data-f="DISCIPLINA" name="SUD[<?=$aItem['ID']?>][DISCIPLINA]">
          <option value="">Дисциплина</option>
          <?foreach(Aiplk::getDisciplina() as $_r){?>
            <option <?=(($aItem['DISCIPLINA']['UF_XML_ID']==$_r['UF_XML_ID'])?'selected':'')?> value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
          <?}?>
        </select>  
      </div>
      <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
      <div class="w_200">
        <span class="line_note">Вариант программы:</span>
        <select
        	<?=((!$ed)?'disabled':'')?> required class="inp_tags inp_varetap form-control form-control-lg"
        	name="SUD[<?=$aItem['ID']?>][VARETAP]">
          <option selected value="">Не выбрано</option>
          <?
          if(empty($aItem['VARETAP']))$_sel='';else $_sel=$aItem['VARETAP'];
          //if(!empty($_POST['prgVarEtap']) and $varetap=intval($_POST['prgVarEtap']))$_sel=$varetap
          foreach($aVarEtap as $_r){?>
            <option
            	<?=(($_sel==$_r['ID'])?'selected':'')?>
            	value="<?=$_r['ID']?>"
            	data-etapy='<?=json_encode($_r['PROPERTIES']['ETAP']['VALUE'], JSON_UNESCAPED_UNICODE)?>'
            ><?=$_r['NAME']?></option>
          <?}?>
        </select>
      </div>

    </div>


    <?/*
		<div class="aip_line2">

      <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
      <div class="w_200">
        <span class="line_note">Стендов:</span>
        <select onchange="cms_prg_get_kolvo($(this).parents('div.prog_item'))"
        	<?=((!$ed)?'disabled':'')?> required
        	class="inp_tags inp_varstend form-control form-control-lg"
        	name="SUD[<?=$aItem['ID']?>][VARSTEND]">
          <option value="">Не выбрано</option>
          <?
					if(empty($aItem['VARSTEND']))$_sel='';else $_sel=$aItem['VARSTEND'];
          foreach(Aiplk::getVariantStend() as $_r){?>
            <option data-kolvo="<?=$_r['KOLVO']?>" <?=(($_sel==$_r['ID'])?'selected':'')?> value="<?=$_r['ID']?>"><?=$_r['NAME']?></option>
          <?}?>
        </select>
      </div>
    </div>  
      */?>

    <div class="table_cont">    
      <table><?/*
        <tr>
          <td colspan="5" style="padding: 0;"><span class="line_note">Этапы</span></td>
        </tr>*/?>
        <?foreach(Aiplk::getEtap() as $etap){
        	if(empty($aItem['VARETAP']) or !in_array($etap['UF_XML_ID'], $aVarEtap[$aItem['VARETAP']]['PROPERTIES']['ETAP']['VALUE'])){
        		$_hidden=true;
        	}else $_hidden=false;
          $ed2=false;
          $ed3=$ed;
          $stend='';
          $seriy='';
          $data='';
          $vr='';
          $kolvo='';
          $s_serii='';
          $so_stenda='';
          if(isset($aItem['ITEMS'][$etap['UF_XML_ID']])){
            $ed2=true;
            $stend=$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['KOLVO_STENDOV']['VALUE'];
            $so_stenda=$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['SO_STENDA']['VALUE'];
            $seriy=$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['KOLVO_SERIY']['VALUE'];
            $s_serii=$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['S_SERII']['VALUE'];
            $data=ConvertDateTime($aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['VREMYA_NACH']['VALUE'], "YYYY-MM-DD", "ru");
            $vr=ConvertDateTime($aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['VREMYA_NACH']['VALUE'], "HH:MI", "ru");
            if($vr=='00:00')$vr='';
            //var_dump($aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['VREMYA_NACH']['VALUE']);
            //var_dump($vr);

            $kolvoAll=count(Aiplk::getSportsmenyKolvo($id, $aItem['DISCIPLINA']['UF_XML_ID'], $aItem['VOZRAST_GRUPPA']['UF_XML_ID']));
            $kolvo=$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['KOLVO_UCH']['VALUE'];
          }
          //if($ed and $ed2)$ed3=true;else $ed3=false;
          $ed3=true;
        ?>
          <tr style="<?=($_hidden)?'display:none':''?>" class="prog_etap_<?=$etap['UF_XML_ID']?>">
            <td>
            	<div class="inp_disabled" style="display:none">
              <label>
                <input 
                  onchange="cms_prg_get_kolvo($(this).parents('div.prog_item'))"
                  data-id="<?=$aItem['ITEMS'][$etap['UF_XML_ID']]['ID']?>"
                  class="prog_etap_activate prog_etap"
             			<?=((!$_hidden)?'checked':'')?>
                  <?//=(($etap['UF_XML_ID']==$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['ETAP']['VALUE'])?'checked':'')?>
                  type="checkbox"
                  name="prog_etap[]"
                  value="<?=$etap['UF_XML_ID']?>"
                  <?=(($_hidden or (!$ed3 and !$ed))?'disabled':'')?>>
                <span class="custom-checkbox"></span>
              </label>
              </div>
              <span><?=$etap['NAME']?></span>
            </td>
            <td>
              <div class="w60">
                <span class="line_note">Стендов</span>

                <select <?/*onchange="cms_prg_get_kolvo($(this).parents('div.prog_item'))"*/?>
                  <?=((!$ed)?'disabled':'')?>
                  class="inp_tags inp_varstend form-control form-control-lg"
                  <?/*name="SUD[<?=$aItem['ID']?>][VARSTEND]"*/?>>
                  <?/*<option value="">Не выбрано</option>*/?>
                  <?
                  if(empty($aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['VARSTEND']['VALUE']))$_sel='728';else $_sel=$aItem['ITEMS'][$etap['UF_XML_ID']]['PROPERTIES']['VARSTEND']['VALUE'];
                  foreach($aVarStend as $_r){?>
                    <option data-kolvo="<?=$_r['KOLVO']?>" <?=(($_sel==$_r['ID'])?'selected':'')?> value="<?=$_r['ID']?>"><?=$_r['KOLVO']?></option>
                  <?}?>
                </select>

                <?/*
                <input 
                  value="<?=$stend?>"
                  class="prog_stendov form-control form-control-lg" type="number"  <?=((!$ed3)?'disabled':'')?>>
                */?>
              </div>          
            </td>

            <td style="display:none">
              <div class="w60">
                <span class="line_note">Нач. стенд</span>
                <input 
                  value="<?=(empty($so_stenda))?'1':$so_stenda?>"
                  class="prog_so_stenda form-control form-control-lg" type="number"  <?=((!$ed3)?'disabled':'')?>>
              </div> 
            </td>       

            <td>
              <div class="w60">
                <span class="line_note">Серий</span>
                <input 
                  value="<?=(empty($seriy))?'10':$seriy?>"
                  class="prog_seriy form-control form-control-lg" type="number"  <?=((!$ed3)?'disabled':'')?>>
              </div> 
              <?/*пусть тут пока будет*/?>
              <input type="hidden" class="prog_broskov" value="3">   
            </td>       
            
            <td style="display:none">
              <div class="w60">
                <span class="line_note">Нач. смена</span>
                <input 
                  value="<?=(empty($s_serii))?'1':$s_serii?>"
                  class="prog_s_serii form-control form-control-lg" type="number"  <?=((!$ed3)?'disabled':'')?>>
              </div> 
            </td>             
            
            <td>
              <div class="">
                <span class="line_note">Дата</span>
                <input 
                  value="<?=$data?>"
                  class="prog_data form-control form-control-lg" type="date"  <?=((!$ed3)?'disabled':'')?>>
              </div>          
            </td>          
            <td>
              <div class="">
                <span class="line_note">Время начала</span>
                <input 
                  value="<?=$vr?>"
                  class="prog_vremya form-control form-control-lg" type="time"  <?=((!$ed3)?'disabled':'')?>>
              </div>          
            </td>
            <td>
              <div class="inp_disabled">
                <span class="line_note">Кол-во участников</span>
                <input                   
                  value="<?=$kolvo?>"
                  class="prog_kolvo form-control form-control-lg" type="number"  <?=((!$ed3)?'disabled':'')?>>
              </div>          
            </td>          
          </tr>
        <?}?>   
      </table>
      <?if($ed){?>
        <div class="p_editable">
          <a data-id="<?=$aItem['ID']?>" href="#" class="prog_del"><i class="bx bx-menu"></i></a>
        </div>  
      <?}?>  
    </div>
  </div>

<?}?>

</div>

<?if($ed){?>
<div class="wrap-input100 mt-4 btn_cont_1 btn_cont_2">
  <a href="#" id="prog_add" class="btn btn-light">Добавить</a>
  <input type="submit" name="go" value="Сохранить" class="questionnaire_btn btn btn-primary">  
</div>
<?}?>

<script>
		//выставляем актуальное колво по каждой программе
	$('div.prog_item').each(function(){
		//alert('sdfs00');
		cms_prg_get_kolvo($(this));
	});
</script>