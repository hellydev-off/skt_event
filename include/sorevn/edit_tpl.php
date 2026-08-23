<?
if(!CSite::InGroup(array(1,9)))die('Нет доступа.');
$aItem=Aiplk::getSorevn($id);
if($aItem['PROPERTIES']['STATUS']['VALUE']=='closed')$ed=false;
else $ed=true;
?>
<input type="hidden" name="SOREVN_ID" value="<?=$aItem['ID']?>">
<div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Название<span class="req">*</span></span> 
          <input <?=((!$ed)?'disabled':'')?> value="<?=$aItem['NAME']?>" class="form-control form-control-lg" type="text" id="OBJECT_NAME" name="PROJECT[NAME]" required="">
				</div>
        
        <div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Номер соревнования</span> 
          <input <?=((!$ed)?'disabled':'')?> value="<?=$aItem['PROPERTIES']['NOM_SOREVN']['VALUE']?>" class="form-control form-control-lg" type="text" id="NOM_SOREVN" name="PROJECT[NOM_SOREVN]">
				</div>



        <div class="wrap-input100 form-outline mb-2 aip_line">
            <span class="label-input">Статус</span>
            <select <?=((!$ed)?'disabled':'')?> style="width:auto;max-width: 100%;" class="form-control form-control-lg form-control form-control-lg-lg" id="OBJECT_UROVEN" name="PROJECT[UROVEN]">
                              <option value="">Не выбрано</option>
                              <?foreach(Aiplk::getUroven() as $row){?>
                                <option <?=(($aItem['PROPERTIES']["UROVEN"]['VALUE']==$row['UF_XML_ID'])?'selected':'')?> value="<?=$row['UF_XML_ID']?>"><?=$row['NAME']?></option>
                              <?}?>                              
            </select>
        </div>  
        
        

				<div class="wrap-input100 form-outline mb-2 tag_select_cont">
          <span class="label-input">Спортивная организация<span class="req">*</span></span> 
          <style>
            .tag_select_cont .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover, .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus,
            .tag_select_cont .select2-selection__choice__display,
            .tag_select_cont .select2-selection__choice,
            .tag_select_cont .select2-selection__choice__remove{
              background:#03a9ff!important;color:white!important;border:none!important;
            }
            .tag_select_cont .select2-container .select2-selection--multiple .select2-selection__rendered{
              display:flex
            }
            .tag_select_cont .select2-selection.select2-selection--multiple{
              display: flex;
              align-items: center;
              justify-content: flex-start;
              caret-color: transparent;
            }
            .tag_select_cont .select2-selection__rendered{font-size:24px;margin-top:0;margin-bottom:0}
            .tag_select_cont .select2-results{background:#eff5fa}
            .tag_select_cont .select2-container--default .select2-selection--multiple,
            .tag_select_cont .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple,
            .tag_select_cont .select2-container--default.select2-container--focus .select2-selection--multiple{
              background-color: #eff5fa;
              border: none;
              border-radius: var(--bs-border-radius-lg);
              min-height: calc(1.5em + 1rem + calc(var(--bs-border-width) * 2));
            }
          </style>          <select multiple="multiple" class="form-control form-control-lg" id="SPORT_ORG2" name="PROJECT[SPORT_ORG][]">
            <?
            $aUser=Aiplk::getUser($GLOBALS['USER']->GetID());
            $aUserWC=Aiplk::getWorkcompArr($aUser['WORK_COMPANY']);
            $aWorkcomp=Aiplk::getWorkcompArr($aItem['PROPERTIES']['SPORT_ORG']['VALUE']);
            foreach($aUserWC as $row){?>
              <option <?=((in_array($row, $aWorkcomp))?'selected':'')?> value="<?=$row?>"><?=$row?></option>
            <?}?>
          </select>
          <script>
            	$('#SPORT_ORG2').select2();
          </script>
          <?/*
          <input <?=((!$ed)?'disabled':'')?>  value="<?=$aItem['PROPERTIES']['SPORT_ORG']['VALUE']?>" class="form-control form-control-lg" type="text" id="SPORT_ORG" name="PROJECT[SPORT_ORG]" required="">
          */?>
				</div>




				<div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Место проведения<span class="req">*</span></span> 
          <select <?=((!$ed)?'disabled':'')?> class="form-control form-control-lg inp_tags" name="PROJECT[MESTO]" id="MESTO1" required>
            <?$aRegion=Aiplk::getRegionTitle($aItem)?>
            <option selected value="<?=$aRegion['xmlval']?>"><?=$aRegion['txt']?></option>
          </select>
				</div>
				<div class="wrap-input100 form-outline mb-2 aip_line">
          <span class="label-input no_margin">Даты проведения</span>
          <div>
            <span class="aip_line">с&nbsp;&nbsp;<input value="<?=ConvertDateTime($aItem['DATE_ACTIVE_FROM'], "YYYY-MM-DD", "ru")?>" class="form-control form-control-lg no_margin" type="date" id="DATE_ACTIVE_FROM" name="PROJECT[DATE_ACTIVE_FROM]" required ></span>
            <span class="aip_line">&nbsp;&nbsp;по&nbsp;&nbsp;<input value="<?=ConvertDateTime($aItem['DATE_ACTIVE_TO'], "YYYY-MM-DD", "ru")?>" class="form-control form-control-lg no_margin" type="date" id="DATE_ACTIVE_TO" name="PROJECT[DATE_ACTIVE_TO]" required></span>
          </div>  
				</div>
				<div class="wrap-input100 form-outline mb-2">
          <span class="label-input">Добавить описание</span> 
          <textarea <?=((!$ed)?'disabled':'')?> class="form-control form-control-lg" type="text" id="OBJECT_NAME" name="PROJECT[DESCR]"><?=$aItem['PROPERTIES']['DESCR']['VALUE']?></textarea>
				</div>

        <div class="wrap-input100 form-outline mb-2 aip_line">
          <?if($ed){?>
          <label class="label-input input-file">
              <span>Добавить документы</span>
              <input <?=((!$ed)?'disabled':'')?> onchange="showFiles3(this,3)" type="file" name="docs_meropr[]" multiple="">		
          </label>
          <span class="add_file" onclick="$(this).parent().find('input').trigger('click');return false;">
            <div><img src="/local/templates/lk/img/skrepka.png" alt=""><span>Прикрепить файл</span></div>
            <?/*<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>*/?>
          </span>   
          <?}?>
        </div>
        <div id="imagePreviews3" class="input-file-list">
        <?foreach ($aItem['PROPERTIES']['DOCS']['VALUE'] as $fid){
            $arFile=CFile::GetFileArray($fid);
            $typeFile=explode('/', $arFile['CONTENT_TYPE']);
        ?>
          <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
            <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
            <div class="text-center mt-2"> 
              <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
            </div>
          </a>
        <?}?>            
        </div>   
        <div class="wrap-input100 form-outline mb-2 aip_line">
          <?if($ed){?>
          <label class="label-input input-file">
              <span>Добавить афишу</span>
              <input <?=((!$ed)?'disabled':'')?> onchange="showFiles3(this,4)" type="file" name="afisha_meropr[]">		
          </label>
          <span class="add_file" onclick="$(this).parent().find('input').trigger('click');return false;">
            <div><img src="/local/templates/lk/img/skrepka.png" alt=""><span>Прикрепить файл</span></div>
            <?/*<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>*/?>
          </span>   
          <?}?>
        </div>
        <div id="imagePreviews4" class="input-file-list">
        <?//foreach ($aItem['PROPERTIES']['AFISHA']['VALUE'] as $fid){
            $fid=$aItem['PROPERTIES']['AFISHA']['VALUE'];
            $arFile=CFile::GetFileArray($fid);
            $typeFile=explode('/', $arFile['CONTENT_TYPE']);
        ?>
          <a href="<?=$arFile['SRC']?>" class="col-md-4 mb-3" target="_blank">
            <img src="<?=$arFile['SRC']?>" alt="Preview" class="img-fluid rounded"> 
            <div class="text-center mt-2"> 
              <span class="badge bg-secondary"><?=$arFile['FILE_NAME']?></span> 
            </div>
          </a>
        <?//}?>            
        </div>  

        <div class="wrap-input100 mt-4 btn_cont_1">
          <?if($ed){?>
          <input type="submit" name="go" value="Сохранить" class="questionnaire_btn btn btn-primary">
          <?}?>
        </div>