<?
if(
  Aiplk::getStartPage()=='lk_region' or 
  Aiplk::getStartPage()=='lk_ross' or 
  (Aiplk::getStartPage()=='sud' and Aiplk::isGlavSud($id))
)$ed=true;else $ed=false;
if(!Aiplk::isEditable($id))$ed=false;
$aItems=Aiplk::getKollegiya($id);
//var_dump('<pre>',$aItem,'</pre>');
?>
<input type="hidden" name="ID_SOREVN" value="<?=$id?>">
<input type="hidden" name="TITLE_SOREVN" value="<?=Aiplk::getSorevn($id)['NAME']?>">
<div id="sf_cont">
<?foreach($aItems as $aItem){?>
<div class="aip_col2 sud_fields_cont" data-id="<?=$aItem['ID']?>">
  <div class="l_line2x2">
    <div>
      <span class="line_note">Должность:</span>	
      <select <?=((!$ed)?'disabled':'')?> required class="inp_tags_dolzhnost form-control form-control-lg" data-f="DOLZHNOST" name="SUD[<?=$aItem['ID']?>][DOLZHNOST]">
        <option value="">Должность</option>
        <?foreach(Aiplk::getDolzhnostSudi() as $_r){?>
          <option <?=(($aItem['PROPERTIES']['DOLZHNOST']['VALUE']==$_r['UF_XML_ID'])?'selected':'')?> value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
        <?}?>
      </select>
    </div>	
    <div>
      <span class="line_note">Судья:</span>		
      <?$_r=$aItem['USER_SPORTSMEN']//;var_dump('<pre>',$_r,'</pre>');?>
      <select <?=((!$ed)?'disabled':'')?> required class="inp_tags_sportsmen form-control form-control-lg" data-f="SUDYA" name="SUD[<?=$aItem['ID']?>][SUDYA]">  
        <option value="<?=$aItem['PROPERTIES']['SUDYA']['VALUE']?>"><?=$_r['LAST_NAME']?> <?=$_r['NAME']?> <?=$_r['SECOND_NAME']?> (<?=Aiplk::getVozrast($_r)?> <?=Aiplk::vozrastTitle(Aiplk::getVozrast($_r))?>)</option>
      </select>  
    </div>
  </div>  
  <div class="l_line2x2">
    <div class="inp_disabled">
      <span class="line_note">Регион:</span>	
      <?$aRegion=Aiplk::getRegionTitle($aItem);//var_dump('<pre>',$aItem,'</pre>');?>
      <?if(empty($aRegion['val']))$aRegion=Aiplk::getRegionTitle($_r)?>
      <select <?=((!$ed)?'disabled':'')?> required class="inp_tags_region form-control form-control-lg" data-f="REGION" name="SUD[<?=$aItem['ID']?>][REGION]">
        <option value="<?=$aRegion['val']?>"><?=$aRegion['txt']?></option>
      </select>  
    </div>
    <div class="inp_disabled">
      <span class="line_note">Категория судьи:</span>		
      <select <?=((!$ed)?'disabled':'')?> required class="inp_tags inp_kateg_sud form-control form-control-lg" data-f="KATEGORIYA" name="SUD[<?=$aItem['ID']?>][KATEGORIYA]">
        <option value="">Категория</option>
        <?foreach(Aiplk::getKategoriiSudi() as $_r) { ?>
          <option <?=(($aItem['PROPERTIES']['KATEGORIYA']['VALUE']==$_r['UF_XML_ID'])?'selected':'')?> value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
        <?}?>
      </select>
    </div>	
  </div>    
  <?if($ed){?>
    <a href="#" class="sudya_del" data-id="<?=$aItem['ID']?>"><i class="bx bx-menu"></i></a>
  <?}?>  
</div>
<?}?>




<?if(empty($aItem)){?>
<div class="aip_col2 sud_fields_cont" data-id="<?=$aItem['ID']?>">
  <div class="l_line2x2">
	<div>
    <span class="line_note">Должность:</span>	
		<select <?=((!$ed)?'disabled':'')?> required class="inp_tags form-control form-control-lg line_cloned" data-f="DOLZHNOST" name="SUD_NEW[DOLZHNOST][]">
			<option value="">Должность</option>
			<?foreach(Aiplk::getDolzhnostSudi() as $_r){?>
				<option value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
			<?}?>
		</select>
	</div>	
	<div>
    <span class="line_note">Судья:</span>		
		<select <?=((!$ed)?'disabled':'')?> required class="inp_tags_sportsmen form-control form-control-lg line_cloned" data-f="SUDYA" name="SUD_NEW[SUDYA][]">  </select>  
	</div>
	</div>
  <div class="l_line2x2">
	<div class="inp_disabled">
    <span class="line_note">Регион:</span>	
		<select <?=((!$ed)?'disabled':'')?> required class="inp_tags_region form-control form-control-lg line_cloned" data-f="REGION" name="SUD_NEW[REGION][]">  </select>  
	</div>
	<div class="inp_disabled">
    <span class="line_note">Категория судьи:</span>		
		<select <?=((!$ed)?'disabled':'')?> required class="inp_kateg_sud inp_tags form-control form-control-lg line_cloned" data-f="KATEGORIYA" name="SUD_NEW[KATEGORIYA][]">
			<option value="">Категория</option>
			<?foreach(Aiplk::getKategoriiSudi() as $_r) { ?>
				<option value="<?=$_r['UF_XML_ID']?>"><?=$_r['NAME']?></option>
			<?}?>
		</select>
	</div>	
	</div>	
  <?if($ed){?>
    <a href="#" class="sudya_del" data-id="<?=$aItem['ID']?>"><i class="bx bx-menu"></i></a>
  <?}?>  
</div>
<?}?>
</div>
<?if($ed){?>
<div class="wrap-input100 mt-4 btn_cont_1 btn_cont_2">
    <a href="#" id="sudya_add" class="btn btn-light">Добавить</a>
    <input type="submit" name="go" value="Сохранить" class="questionnaire_btn btn btn-primary">
</div>
<?}?>