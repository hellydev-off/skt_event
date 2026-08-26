<?php
use Bitrix\Main\UserTable;
use Bitrix\Main\UserGroupTable;
function v($ret,$die=false){echo '<pre>';var_dump($ret);echo '</pre>';if($die)die();}
CModule::IncludeModule('iblock');

class Aiplk{
  static $groupIds=[9,7,8,10,4,11,12];
  static $glavnSudEnumID='main_sud';
  static $glavnSudSekretarEnumID='gl_sekr';

  static function getStartPageGroup($groupId){
    $ret='/404.php';
    switch($groupId){
      case(4):$ret='nobody';break;//новый
      case(7):$ret='sud';break;//Судья
      case(8):$ret='sport';break;//Спортсмен
      case(9):$ret='org';break;//Организатор - заменить везде на 11 (lk_ross)
      case(10):$ret='trener';break;//Тренеры
      case(11):$ret='lk_ross';break;//Вместо организатора
      case(12):$ret='lk_region';break;//Региональная орг Вместо организатора (добавляет пользователей в соревнование)
    }
    return $ret;
  }
  static function setGroup($groupId){
    if(CSite::InGroup(array($groupId)))$_SESSION['lk_setgroup']=intval($groupId);
    return self::getStartPageGroup($_SESSION['lk_setgroup']);
  }
  static function getStartPage($getGroupId=false){
    //unset($_SESSION['lk_setgroup']);
    $aGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
    if(isset($_SESSION['lk_setgroup'])){
      if(in_array($_SESSION['lk_setgroup'], $aGroups)){
        if($getGroupId)$ret=$_SESSION['lk_setgroup'];
        else $ret=self::getStartPageGroup($_SESSION['lk_setgroup']);
      }else unset($_SESSION['lk_setgroup']);
    }else{
      $groupId=false;
      foreach(self::$groupIds as $gId){
        if(in_array($gId, $aGroups)){
          $groupId=$gId;
          break;
        }
      }
      if($getGroupId)$ret=$groupId;
      else $ret=self::getStartPageGroup($groupId);
    }
    return $ret;
  }
  static function getDolzhnostSudi($UF_XML_ID=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(3, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }    
  static function getOcenkaSudi($UF_XML_ID=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(5, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }  
  static function getKategoriiSudi($UF_XML_ID=false, $id=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    elseif($id)$aFilter=array('ID'=>$id);
    else $aFilter=array();
    $ret=self::getHighloadIB(4, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID or $id)$ret=array_shift($ret);
    return $ret;
  }  
  static function getVozrastGuppa($UF_XML_ID=false){//привет гуппам)
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(13, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }  
  static function getDisciplina($UF_XML_ID=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(7, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }    
  static function getRegionSpr($UF_XML_ID=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(20, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }  
  static function getEtap($UF_XML_ID=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(8, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }  
  static function getRazryad($UF_XML_ID=false){
    if(!empty($UF_XML_ID)){
      $id=intval($UF_XML_ID);
      if(!empty($id) and $id==$UF_XML_ID)$aFilter=array('ID'=>$UF_XML_ID);
      else $aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    }elseif($UF_XML_ID===false) $aFilter=array();
    else return false;
    $ret=self::getHighloadIB(9, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }    
  static function getRegionSprNew($UF_XML_ID=false, $findName=false){
    if($findName){
      $UF_XML_ID=str_replace('-', ' ', $UF_XML_ID);
      $aFilter=array('UF_NAME'=>'%'.$UF_XML_ID.'%');
      $ret=self::getHighloadIB(20, $aFilter, array("UF_SORT"=>"ASC"));
      if(!empty($ret))$ret=array_shift($ret);else return false;
      return $ret;
    }
    $id=intval($UF_XML_ID);
    if(!empty($id) and $id==$UF_XML_ID)$aFilter=array('ID'=>$UF_XML_ID);
    elseif($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(20, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }  
  static function getCurRegion($aUser=false){
    if(!$aUser)$aUser=Aiplk::getUser($GLOBALS['USER']->getID());
    return Aiplk::getRegionSprNew($aUser['UF_REGION_SPR']);
  }
  static function getUroven($UF_XML_ID=false){
    if($UF_XML_ID)$aFilter=array('UF_XML_ID'=>$UF_XML_ID);
    else $aFilter=array();
    $ret=self::getHighloadIB(14, $aFilter, array("UF_SORT"=>"ASC"));
    if($UF_XML_ID)$ret=array_shift($ret);
    return $ret;
  }
  static function getRazryadRes($disc_XML_ID, $pol, $res){
    if($pol=='M')$pol=5;else $pol=6;
    $aFilter=array('UF_DISCIPLINA'=>$disc_XML_ID, 'UF_POL'=>$pol, '<=UF_RES'=>$res);
    $ret=self::getHighloadIB(15, $aFilter, array("ID"=>"ASC"));
    usort($ret, function($a, $b){
      if($a['UF_RES']==$b['UF_RES'])return 0;
      return $a['UF_RES'] < $b['UF_RES']?-1:1;
    });
    return array_pop($ret);
  }  
  static function getHighloadIB($IBID, $aFilter, $aOrder=array("UF_SORT"=>"ASC")){
    \Bitrix\Main\Loader::IncludeModule("highloadblock");
    $hlblock=\Bitrix\Highloadblock\HighloadBlockTable::getById($IBID)->fetch();
    $entity=\Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityDataClass=$entity->getDataClass();
    $result = $entityDataClass::getList(array(
      "select"=>array("*"),
      "order"=>$aOrder,
      "filter"=>$aFilter,
    ));
    $ret=array();
    while($arRow=$result->Fetch())$ret[$arRow['UF_XML_ID']]=array_merge($arRow, ['UF_XML_ID'=>$arRow['UF_XML_ID'], 'NAME'=>$arRow['UF_NAME']]);
    return $ret;
  }
  static function getIB($aFilter, $aOrder=array("SORT"=>"ASC")){
    $el=new CIBlockElement;
    $ret=array();
    $res=$el->GetList($aOrder, $aFilter, false, false, ['*']);
    while($arRow=$res->GetNextElement()){
      $aFields=$arRow->GetFields();
      $aProps=$arRow->GetProperties(Array(),Array('ACTIVE'=>'Y','EMPTY'=>'N'));
      $aFields['PROPERTIES']=$aProps;
      $ret[$aFields['ID']]=$aFields;
    }
    return $ret;    
  }
  static function getVariantEtap($varEtapId=false){
  	if(!$varEtapId)$aFilter=['IBLOCK_ID'=>8, 'ACTIVE'=>'Y'];
  	else $aFilter=['IBLOCK_ID'=>8, 'ID'=>$varEtapId];
  	$aOrder=['SORT'=>'ASC'];
    $ret=self::getIB($aFilter, $aOrder);
    return $ret;
  }
  static function getVariantStend($varEtapId=false){
  	if(!$varEtapId)$aFilter=['IBLOCK_ID'=>9, 'ACTIVE'=>'Y'];
  	else $aFilter=['IBLOCK_ID'=>9, 'ID'=>$varEtapId];
  	$aOrder=['SORT'=>'ASC'];
    $ret=self::getIB($aFilter, $aOrder);
    foreach($ret as $k=>$row){
    	$ret[$k]['KOLVO']=count($row['PROPERTIES']['STENDY']['VALUE']);
    }
    return $ret;
  }
  static function getIDsSorevnFrom(){
    $ret=array();
    if(Aiplk::getStartPage()=='sud'){
      $aOrder=['DATE_CREATE'=>'ASC'];    
      $aFilter=['IBLOCK_ID'=>4, 'PROPERTY_SUDYA'=>$GLOBALS['USER']->GetId()];
      $_ret=self::getIB($aFilter, $aOrder);
      foreach($_ret as $row)$ret[]=$row['PROPERTIES']['ID_SOREVN']['VALUE'];
    }    
    if(Aiplk::getStartPage()=='sport'){
      $aOrder=['NAME'=>'ASC'];    
      $aFilter=['IBLOCK_ID'=>6, 'PROPERTY_SPORTSMEN'=>$GLOBALS['USER']->GetId()];
      //$aFilter=['IBLOCK_ID'=>6];
      $_ret=self::getIB($aFilter, $aOrder);
      foreach($_ret as $row)$ret[]=$row['PROPERTIES']['ID_SOREVN']['VALUE'];
    }    
    if(Aiplk::getStartPage()=='trener'){
      $aOrder=['NAME'=>'ASC'];    
      $aFilter=['IBLOCK_ID'=>6, 'PROPERTY_TRENER'=>$GLOBALS['USER']->GetId()];
      $_ret=self::getIB($aFilter, $aOrder);
      foreach($_ret as $row)$ret[]=$row['PROPERTIES']['ID_SOREVN']['VALUE'];
    }
    $ret=array_unique($ret);
    $ret=array_values($ret);
    return $ret;
  }
  static function getSorevnFromId($id){
    $aFilter=['IBLOCK_ID'=>3, 'ID'=>$id];
    $aOrder=['DATE_ACTIVE_TO'=>'DESC'];
    $ret=self::getIB($aFilter, $aOrder);
    return array_shift($ret);
  }
  static function getSorevn($id=false, $active='process', $all=false){//closed   process
    $aOrder=['DATE_ACTIVE_TO'=>'DESC'];
		if(Aiplk::getStartPage()=='lk_ross' or Aiplk::getStartPage()=='lk_region' or Aiplk::getStartPage()=='trener'){
      if($id){
        $aFilter=['IBLOCK_ID'=>3, 'ID'=>$id];      
      }else{
        $aFilter=['PROPERTY_STATUS'=>$active, 'IBLOCK_ID'=>3, 'CREATED_BY'=>$GLOBALS['USER']->GetID()];
      }
    }else{
      if($id){
        $aFilter=['IBLOCK_ID'=>3, 'ID'=>$id];      
      }elseif(!$all){
        $aID_SOREVN=self::getIDsSorevnFrom();
        if(empty($aID_SOREVN))return array();
        $aFilter=['PROPERTY_STATUS'=>$active, 'IBLOCK_ID'=>3, 'ID'=>$aID_SOREVN];
      }
    }
    //!!!!!!!!!РАСКОМЕНТИТЬ!!!!!!!!!!!!!!!!!!!!!!!!!
    if(!$id and (CSite::InGroup(array(1)) or $all)){//админу все показываем
    //if(!$id and ($all)){
    //!!!!!!!!!РАСКОМЕНТИТЬ!!!!!!!!!!!!!!!!!!!!!!!!!        
			if($active)$aFilter['PROPERTY_STATUS']=$active;
			$aFilter['IBLOCK_ID']=3;
      unset($aFilter['CREATED_BY']);
      unset($aFilter['ID']);
    }
    $aFilter['ACTIVE']='Y';
    $ret=self::getIB($aFilter, $aOrder);
    if($id)$ret=array_shift($ret);
    return $ret;
  }
  static function getUserSudi($name=null){
    $groupId_sudya=7;
    $arAdmins=UserGroupTable::getList([
        'filter'=>['=GROUP_ID'=>$groupId_sudya],
        'select'=>['USER_ID'],
    ])->fetchAll();
    $arAdminsIds=array_column($arAdmins, 'USER_ID');
    if(!empty($name))$aFilter=['ID'=>$arAdminsIds, '%LAST_NAME'=>addslashes($name)];
    else $aFilter=['ID'=>$arAdminsIds];		
    $arUsers=UserTable::getList([
        'filter'=>$aFilter,
        'select'=>['*', 'UF_REGION', 'UF_GOROD', 'UF_REGION_STRANA', 'UF_SUD_KAT', 'UF_REGION_SPR']
    ])->fetchAll();
    $aUsers=array();
    foreach($arUsers as $row)$aUsers[$row['ID']]=$row;
    return $aUsers;
  }  
  static function getUserFromGroup($idGroup, $idRegion){//отдаем юзеров по группе и региону (8-спортсмены)
    // Определяем параметры для выборки
    $parameters = [
        'select' => ['*','GROUPS.GROUP_ID','UF_LIC_TRENER_TIP', 'UF_LIC_TRENER_NOMER', 'UF_LIC_TRENER_SROK','UF_TRENER_KAT','UF_TRENER_DATE_ADD', 'UF_COMM', 'UF_DOPUSK', 'UF_REGION_SPR', 'UF_REGION', 'UF_GOROD', 'UF_REGION_STRANA', 'UF_TRENER_ID', 'UF_SUD_KAT', 'UF_RAZR', 'UF_PHOTO_MAIN', 'UF_PHOTO_SPRT', 'UF_PHOTO_ORG', 'UF_PHOTO_SUD', 'UF_PHOTO_TREN'],
        'filter' => [
            'GROUPS.GROUP_ID' => $idGroup,
            '=UF_REGION_SPR' =>$idRegion
        ],
        'order' => ['LAST_NAME' => 'ASC']
    ];

    // Выполняем запрос
    $result = UserTable::getList($parameters);

    // Обрабатываем результат
    $users = [];
    while ($user = $result->fetch()) {
        $users[] = $user; // Добавляем каждого пользователя в массив
    }
    return $users;
  }
  static function getUserSportsmeny($name=null, $groupId_sportsmen=8, $regionId=false, $isDopusk=true){
    if(empty($groupId_sportsmen)){
      $arAdmins=UserGroupTable::getList([
          'select'=>['USER_ID'],
      ])->fetchAll();
    }else{
      $arAdmins=UserGroupTable::getList([
          'filter'=>['=GROUP_ID'=>$groupId_sportsmen],
          'select'=>['USER_ID'],
      ])->fetchAll();
    }
    $arAdminsIds=array_column($arAdmins, 'USER_ID');
    if(!empty($name))$aFilter=['ID'=>$arAdminsIds, 'LAST_NAME'=>'%'.addslashes($name).'%'];
    else $aFilter=['ID'=>$arAdminsIds];
    if($regionId){
      $aFilter['UF_REGION_SPR']=$regionId;
    }
    if(!$isDopusk){
      $aFilter=[
        'LOGIC' => 'AND', 
        $aFilter, 
        [
            'LOGIC' => 'OR', 
            ['UF_DOPUSK' => '7'],
            ['UF_DOPUSK' => null],
        ],
      ];
    }
      // v($aFilter);
    $arUsers=UserTable::getList([
        'filter'=>$aFilter,
        'select'=>['*','UF_LIC_TRENER_TIP', 'UF_LIC_TRENER_NOMER', 'UF_LIC_TRENER_SROK','UF_TRENER_KAT', 'UF_TRENER_DATE_ADD', 'UF_COMM', 'UF_DOPUSK', 'UF_REGION_SPR', 'UF_REGION', 'UF_GOROD', 'UF_REGION_STRANA', 'UF_TRENER_ID', 'UF_SUD_KAT', 'UF_RAZR', 'UF_PHOTO_MAIN', 'UF_PHOTO_SPRT', 'UF_PHOTO_ORG', 'UF_PHOTO_SUD', 'UF_PHOTO_TREN']
    ])->fetchAll();
    $aUsers=array();
    foreach($arUsers as $row)$aUsers[$row['ID']]=$row;
    return $aUsers;
  }    
  static function getEnumList($fielName){
    $rsEnum = CUserFieldEnum::GetList(
        array(), 
        array("USER_FIELD_NAME" => $fielName)
    );
    $ret=array();
    while($arEnum = $rsEnum->Fetch())$ret[$arEnum["ID"]]=$arEnum["VALUE"];
    return $ret;
  }
	static function getUser($id){
    $arUsers=UserTable::getList([
        'filter'=>['ID'=>$id],
        'select'=>['*', 'UF_LIC_TRENER_TIP', 'UF_LIC_TRENER_NOMER', 'UF_LIC_TRENER_SROK','UF_TRENER_KAT', 'UF_TRENER_DATE_ADD', 'UF_COMM', 'UF_DOPUSK', 'UF_REGION_SPR', 'UF_REGION', 'UF_GOROD', 'UF_REGION_STRANA', 'UF_TRENER_ID', 'UF_SUD_KAT', 'UF_RAZR', 'UF_PHOTO_MAIN', 'UF_PHOTO_SPRT', 'UF_PHOTO_ORG', 'UF_PHOTO_SUD', 'UF_PHOTO_TREN']
    ])->fetchAll();
		if(is_array($id)){
			$a=array();
			foreach($arUsers as $row)$a[$row['ID']]=$row;
			return $a;
		}
    return $arUsers[0];
  }  
  static function getUserTrenery($name=null){
    $groupId_trenery=10;
    $arAdmins=UserGroupTable::getList([
        'filter'=>['=GROUP_ID'=>$groupId_trenery],
        'select'=>['USER_ID'],
    ])->fetchAll();
    $arAdminsIds=array_column($arAdmins, 'USER_ID');
    if(!empty($name))$aFilter=['ID'=>$arAdminsIds, '%LAST_NAME'=>addslashes($name)];
    else $aFilter=['ID'=>$arAdminsIds];    
    $arUsers=UserTable::getList([
        'filter'=>$aFilter,
        'select'=>['*', 'UF_REGION']
    ])->fetchAll();
    $aUsers=array();
    foreach($arUsers as $row)$aUsers[$row['ID']]=$row;
    return $aUsers;
  }
  static function getKollegiya($ID_SOREVN){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>4, /*'CREATED'=>$GLOBALS['USER']->GetID(),*/ 'PROPERTY_ID_SOREVN'=>$ID_SOREVN];
    $ret=self::getIB($aFilter, $aOrder);	
		$aId=array();
		$_ret=array();
		foreach($ret as $row){
      $aIds[]=$row['PROPERTIES']['SUDYA']['VALUE'];
    }
		$aUsers=self::getUser($aIds);
		foreach($ret as $row){
			$row['USER_SPORTSMEN']=$aUsers[$row['PROPERTIES']['SUDYA']['VALUE']];
			$_ret[$row['ID']]=$row;
		}		
    return $_ret;    
  }
  static function getProgrammy($ID_SOREVN, $currentUser=false){

    //$aOrder=['PROPERTY_ETAP'=>'DESC', 'PROPERTY_DISCIPLINA'=>'ASC', 'ID'=>'ASC'];   
    $aOrder=['PROPERTY_VREMYA_NACH'=>'ASC', 'PROPERTY_VOZRAST_GRUPPA'=>'ASC'];   
    if($currentUser){
      $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>5, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN, 'PROPERTY_SPORTSMEN'=>$GLOBALS['USER']->GetID()];
    }else{
      $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>5, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN];
    }
    $ret=self::getIB($aFilter, $aOrder);
    return $ret;
  }  
  static function prepareProgrammy(&$aItems){
    $ret=array();
    $aVozrgruppa=self::getVozrastGuppa();
    $aDiscipl=self::getDisciplina();
    foreach($aVozrgruppa as $grId=>$aGr){
      foreach($aDiscipl as $discId=>$aDisc){
        foreach($aItems as $row){
          if($row['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']==$grId and $row['PROPERTIES']['DISCIPLINA']['VALUE']==$discId){
            if(!isset($ret[$grId.'_'.$discId]))$ret[$grId.'_'.$discId]=array('ITEMS'=>array());
            $ret[$grId.'_'.$discId]['ID']=$row['ID'];
            $ret[$grId.'_'.$discId]['VOZRAST_GRUPPA']=$aGr;
            $ret[$grId.'_'.$discId]['DISCIPLINA']=$aDisc;
            $ret[$grId.'_'.$discId]['VARETAP']=$row['PROPERTIES']['VARETAP']['VALUE'];
            $ret[$grId.'_'.$discId]['VARSTEND']=$row['PROPERTIES']['VARSTEND']['VALUE'];
            $ret[$grId.'_'.$discId]['ITEMS'][$row['PROPERTIES']['ETAP']['VALUE']]=$row;
          }
        }
      }
    }
    return $ret;
  }
  static function getProgramma($ID_PROGRAMMA){
    $aOrder=['ID'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>5, 'ID'=>$ID_PROGRAMMA];
    $ret=self::getIB($aFilter, $aOrder);
    return array_shift($ret);    
  }
  static function getSportsmenyKolvo($ID_SOREVN, $discipl_id='', $aVozrgruppa=array()){
    $aOrder=['PROPERTY_SORT'=>'ASC'];   
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>6, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN, 'PROPERTY_VOZRAST_GRUPPA'=>$aVozrgruppa, 'PROPERTY_DISCIPLINY'=>$discipl_id];
    return self::getIB($aFilter, $aOrder);
  }
  static function getSportsmeny($ID_SOREVN, $active='Y', $aFilter=false, $aOrder=false){
    //if($aOrder===false)$aOrder=['PROPERTY_SORT'=>'ASC'];
    if($aOrder===false)$aOrder=['ID'=>'ASC'];
    if($aFilter===false)$aFilter=['ACTIVE'=>$active, 'IBLOCK_ID'=>6, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN];
    $ret=self::getIB($aFilter, $aOrder);
    //v($aFilter);
		$aIds=array();
		$_ret=array();
		foreach($ret as $row){
      $aIds[]=$row['PROPERTIES']['SPORTSMEN']['VALUE'];
      $aIds[]=$row['PROPERTIES']['TRENER']['VALUE'];
    }
		$aUsers=self::getUser($aIds);
		foreach($ret as $row){
			$row['USER_SPORTSMEN']=$aUsers[$row['PROPERTIES']['SPORTSMEN']['VALUE']];
			$row['USER_TRENER']=$aUsers[$row['PROPERTIES']['TRENER']['VALUE']];
      $row['NumSort']=self::getSort($row);
			$_ret[$row['ID']]=$row;
		}
    if(!empty($_REQUEST['flt_disc'])){
      $discXmlId=addslashes($_REQUEST['flt_disc']);
      foreach($_ret as $k=>$v){
        if(isset($v['NumSort'][$discXmlId])){        
          $_ret[$k]['_SORT']=str_pad($v['NumSort'][$discXmlId], 2, '0', STR_PAD_LEFT);
        }
      }
    }
    //v($_ret);
    return $_ret;
  }    
  static function sortSprts(&$aSprt, $discXmlId, $asc='ASC'){
    foreach($aSprt as $k=>$v){
      if(isset($v['NumSort'][$discXmlId])){        
        $aSprt[$k]['_SORT']=str_pad($v['NumSort'][$discXmlId], 2, '0', STR_PAD_LEFT);
      }
    }
    if($asc=='ASC'){
      usort($aSprt, function($a, $b){
        if($a['_SORT']==$b['_SORT'])return 0;
        return $a['_SORT'] < $b['_SORT']?-1:1;
      });
    }else{
      usort($aSprt, function($a, $b){
        if($a['_SORT']==$b['_SORT'])return 0;
        return $a['_SORT'] < $b['_SORT']?1:-1;
      });      
    }
  }
  static function getSudyi($ID_SOREVN){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>4, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN];
    $ret=self::getIB($aFilter, $aOrder);
		$aIds=array();
		$_ret=array();
		foreach($ret as $row){
      $aIds[]=$row['PROPERTIES']['SUDYA']['VALUE'];
    }
		$aUsers=self::getUser($aIds);
		foreach($ret as $row){
			$row['USER_SUDYA']=$aUsers[$row['PROPERTIES']['SUDYA']['VALUE']];
			$_ret[$row['ID']]=$row;
		}
    return $_ret;    
  }  
  static function getSportsmen($ID, $active='Y'){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>$active, 'IBLOCK_ID'=>6, 'ID'=>$ID];
    $ret=self::getIB($aFilter, $aOrder);
    return array_shift($ret);
  }    
  static function getSportsmens($ID){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['IBLOCK_ID'=>6, 'ID'=>$ID];
    $ret=self::getIB($aFilter, $aOrder);
    return $ret;
  }    
  static function getSportsmenFromUserId($ID_SOREVN, $userId, $active='Y'){
    $aOrder=['NAME'=>'ASC'];    
    if(empty($ID_SOREVN)){
      $aFilter=['ACTIVE'=>$active, 'IBLOCK_ID'=>6, 'PROPERTY_SPORTSMEN'=>$userId];
    }else{
      $aFilter=['ACTIVE'=>$active, 'IBLOCK_ID'=>6, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN, 'PROPERTY_SPORTSMEN'=>$userId];
    }
    $ret=self::getIB($aFilter, $aOrder);
    if(empty($ret))$ret=false;
    return $ret;
  }  
  static function getSprtCurrent($ID_SOREVN){
    if(Aiplk::getStartPage()=='sport'){
      $aFilter=['IBLOCK_ID'=>6, 'PROPERTY_SPORTSMEN'=>$GLOBALS['USER']->GetID(), 'PROPERTY_ID_SOREVN'=>$ID_SOREVN];
    }elseif(Aiplk::getStartPage()=='sud'){
      $aFilter=['IBLOCK_ID'=>4, 'PROPERTY_SUDYA'=>$GLOBALS['USER']->GetID(), 'PROPERTY_ID_SOREVN'=>$ID_SOREVN];
    }
    $aOrder=['NAME'=>'ASC'];    
    $ret=self::getIB($aFilter, $aOrder);
    return array_shift($ret);
  }
  static function getSportsmenResults($ID){
		if(!is_array($ID)){
			$aOrder=['NAME'=>'ASC'];    
			$aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>6, 'ID'=>$ID];
			$ret=self::getIB($aFilter, $aOrder);
			$_a=array_shift($ret);
		}else $_a=$ID;
    if(!isset($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE']) or empty($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE'])){
      $ret=array();
    }else{
      $ret=json_decode($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE'], true);
    }  
    return $ret;  
  }  
  static function getSportsmenAllResult($ID){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>6, 'ID'=>$ID];
    $ret=self::getIB($aFilter, $aOrder);
    $_a=array_shift($ret);
    if(!isset($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE']) or empty($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE'])){
      $c=0;
    }else{
      $ret=json_decode($_a['PROPERTIES']['REZULTATY_JSON']['~VALUE'], true);
      $c=0;
      foreach($ret as $prgId=>$prg){
        foreach($prg as $ser)$c+=array_sum($ser);
      }
    }  
    return $c;  
  }
  static function setLastUniqBall(&$ret, $prev=false){
    //находим всех с одинаковыми баллами [0], остальным проставляем в [3] рез-т по последней серии
    foreach($ret as $sprtId=>$aItem)$aDuble[$aItem[0]][$sprtId]=$aItem;
    foreach($aDuble as $ball=>$retItem){
      if(count($retItem)==1){
        foreach($retItem as $sprtId=>$v){
          $ret[3]=$v[1][count($v[1])-1];
        }
        unset($aDuble[$ball]);
      }
    }
    foreach($aDuble as $group=>$_ret){
      foreach($_ret as $sprtId=>$aItem){//по группе
        $__ret=$_ret;
        $aNSer=array_shift($__ret)[1];    
        foreach($aNSer as $nSer=>$__v){//срез по серии в группе
          $GLOBALS['_nser']=$nSer;
          if(empty($nSer))return false;
          uasort($ret, function($a, $b){
            if($a[1][$GLOBALS['_nser']]==$b[1][$GLOBALS['_nser']])return 0;
            return $a[1][$GLOBALS['_nser']]<$b[1][$GLOBALS['_nser']]?1:-1;
          });         
        }
      }
    }
    //if(!$prev)v($ret); 
  } 
  static function getPrevPrgId($aProgramma){
  	$aVarEtap=Aiplk::getVariantEtap();
  	$aVarEtap=$aVarEtap[$aProgramma['PROPERTIES']['VARETAP']['VALUE']]['PROPERTIES']['ETAP']['VALUE'];
  	$prev=false;
  	foreach($aVarEtap as $etap){
  		if($etap==$aProgramma['PROPERTIES']['ETAP']['VALUE'])break;
  		$prev=$etap;
  	}
  	$ret=false;
		if($prev){
			$aOrder=['NAME'=>'ASC'];
	    $aFilter=[
	    	'ACTIVE'=>$active,
	    	'IBLOCK_ID'=>5,
	    	'PROPERTY_DISCIPLINA'=>$aProgramma['PROPERTIES']['DISCIPLINA']['VALUE'],
	    	'PROPERTY_ID_SOREVN'=>$aProgramma['PROPERTIES']['ID_SOREVN']['VALUE'],
	    	'PROPERTY_VOZRAST_GRUPPA'=>$aProgramma['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'],
	    	'PROPERTY_ETAP'=>$prev
	  	];
	    $ret=self::getIB($aFilter, $aOrder);
	    $ret=array_shift($ret);
	  }
    return $ret;
  }
  static function getMestoFromProgramma($aProgramma){
    $aSportsmeny=self::getSportsmeny($aProgramma['PROPERTIES']['ID_SOREVN']['VALUE']);
    $prevPrg=self::getPrevPrgId($aProgramma);
    $ret=array();
    $prevRet=array();
    foreach($aSportsmeny as $kUser=>$aUserSportsmen){
      //if(!in_array($aUserSportsmen['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'], $aProgramma['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']))continue;   
			if(!is_array($aUserSportsmen['PROPERTIES']['DISCIPLINY']['VALUE']))$aUserSportsmen['PROPERTIES']['DISCIPLINY']['VALUE']=[];
      if(
        $aUserSportsmen['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']!=$aProgramma['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'] or
        !in_array($aProgramma['PROPERTIES']['DISCIPLINA']['VALUE'], $aUserSportsmen['PROPERTIES']['DISCIPLINY']['VALUE'])
      )continue;      
      //var_dump($aUserSportsmen['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'], $aProgramma['PROPERTIES']['VOZRAST_GRUPPA']['VALUE'], $aUserSportsmen['ID']);
      
      //var_dump('<pre>',$aUserSportsmen['PROPERTIES']['DISCIPLINY']['VALUE'], $aProgramma['PROPERTIES']['DISCIPLINA']['VALUE'],'</pre>');

      $aAllResult=Aiplk::getSportsmenResults($aUserSportsmen['ID']);
      //var_dump('<pre>',$aUserSportsmen['NAME'], $aAllResult,'</pre>');
      $allBally=0;
      $aSeriyaSum=array();
      foreach($aAllResult[$aProgramma['ID']] as $kSeriya=>$aSeriya){
        foreach($aSeriya as $v){
        	if(!isset($aSeriyaSum[$kSeriya]))$aSeriyaSum[$kSeriya]=0;
        	$aSeriyaSum[$kSeriya]+=$v;
          $allBally+=$v;         
        }
      }
      //[0]общее баллов, [1]сумма в сериях, [2]все серии, [3]признак учета y/n [4]пред место
      //$ret[$aUserSportsmen['ID']]=array($allBally, $aSeriyaSum, $aAllResult[$aProgramma['ID']], 'n');
      $ret[$aUserSportsmen['ID']]=array($allBally, $aSeriyaSum, false, 'n', 0);
	    //баллы по пред программе
	    $prev_allBally=0;
      $prev_aSeriyaSum=array();
	    if($prevPrg){
				foreach($aAllResult[$prevPrg['ID']] as $prev_kSeriya=>$prev_aSeriya){
	        foreach($prev_aSeriya as $v){
	        	if(!isset($prev_aSeriyaSum[$prev_kSeriya]))$prev_aSeriyaSum[$prev_kSeriya]=0;
	        	$prev_aSeriyaSum[$prev_kSeriya]+=$v;
	        	$prev_allBally+=$v;
	        }
	    	}
    		//$prevRet[$aUserSportsmen['ID']]=array($prev_allBally, $prev_aSeriyaSum, $aAllResult[$prevPrg['ID']], 'n', 0);
    		$prevRet[$aUserSportsmen['ID']]=array($prev_allBally, $prev_aSeriyaSum, false, 'n', 0);
	  	}
    }
	//предыдущая программа
  //var_dump('<pre>',$prevPrg,'</pre>');die();
		if($prevPrg){
	 		//оставляем нужное кол-во, лучших по очкам
	    //для одинаковых серий
	    self::setLastUniqBall($prevRet, true);
	    //сортируем по весу asc
	    uasort($prevRet, function($a, $b){
	      if($a[3]==$b[3])return 0;
	      return $a[3]<$b[3]?1:-1;
	    });
	    //сортируем по очкам asc
	    uasort($prevRet, function($a, $b){
	      if($a[0]==$b[0])return 0;
	      return $a[0]<$b[0]?1:-1;
	    });
	    $_ret=array();
	    $i=0;
	    $c=$aProgramma['PROPERTIES']['KOLVO_UCH']['VALUE'];
	    foreach($prevRet as $k=>$row){
	      if($i>=$c)break;
	      $i++;
	      $_ret[$k]=$row;
	    }
	    $prevRet=$_ret;
	    $_ret=array();
	    $prevMesto=1;
	    foreach($prevRet as $k=>$v){
	   		foreach($ret as $k1=>$v1){
	   			$ret[$k][4]=$prevMesto;
	   			if($k==$k1)$_ret[$k]=$ret[$k];
	   		}
	   		$prevMesto++;
	    }
	    $ret=$_ret;
		}
    //v($ret);
    //для одинаковых серий
    self::setLastUniqBall($ret);
    //сортируем по весу asc
    uasort($ret, function($a, $b){
      if($a[3]==$b[3])return 0;
      return $a[3]<$b[3]?1:-1;
    });    

    //сортируем по очкам asc
    uasort($ret, function($a, $b){
      if($a[0]==$b[0])return 0;
      return $a[0]<$b[0]?1:-1;
    });
    //пишем места
    //[0]-mesto [1]-ochkov v programme
    $i=1;
    foreach($ret as $userSpId=>$row){
      if(empty($row[0])){
        $ret[$userSpId]=['-', $row[0], $row[4], $row[3]];
      }else{
        $ret[$userSpId]=[$i, $row[0], $row[4], $row[3]];
      }  
      $i++;
    }

    if(!$prevPrg){
	    $_ret=array();
	    $i=0;
	    $c=$aProgramma['PROPERTIES']['KOLVO_UCH']['VALUE'];
	    foreach($ret as $k=>$row){
	      if($i>=$c)break;
	      $i++;
	      $_ret[$k]=$row;
	    }
	    $ret=$_ret;
	  }
    //var_dump('<pre>',$ret,'</pre>');
    return $ret;
  }
  // static function array_swap(&$array, $swap_a, $swap_b){
  //   $ret=array();
  //   foreach($array as $k=>$v){
  //     if($k!=$swap_a and $k!=$swap_b)$ret[$k]=$v;
  //     if($k==$swap_a)$ret[$swap_b]=$v;
  //     if($k==$swap_b)$ret[$swap_a]=$v;
  //   }
  //   return $ret;
  // }
  static function getGlavnSud($ID_SOREVN){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>4, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN, 'PROPERTY_DOLZHNOST'=>self::$glavnSudEnumID];
    $ret=self::getIB($aFilter, $aOrder);
    $ret=array_shift($ret);
    $ret['USER_SUDYA']=self::getUser($ret['PROPERTIES']['SUDYA']['VALUE']);
    if(empty($ret))return false;
    return $ret;
  }  
  static function getGlavnSudSekretar($ID_SOREVN){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>4, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN, 'PROPERTY_DOLZHNOST'=>self::$glavnSudSekretarEnumID];
    $ret=self::getIB($aFilter, $aOrder);
    $ret=array_shift($ret);
    $ret['USER_SUDYA']=self::getUser($ret['PROPERTIES']['SUDYA']['VALUE']);
    if(empty($ret))return false;
    return $ret;
  }
  static function getCurrentSudDolzhnost($ID_SOREVN){
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>4, 'PROPERTY_ID_SOREVN'=>$ID_SOREVN, 'PROPERTY_SUDYA'=>$GLOBALS['USER']->GetID()];
    $_ret=self::getIB($aFilter, $aOrder);
    if(empty($_ret))return false;
    $ret=array();
    $aDolzh=self::getDolzhnostSudi();
    foreach($_ret as $row)$ret[]=$aDolzh[$row['PROPERTIES']['DOLZHNOST']['VALUE']]['NAME'];
    return $ret;
  }  
  static function isEditable($ID_SOREVN){
    if(CSite::InGroup(array(1,9,7,12,11)))return true;
    $ret=true;
    if(is_numeric($ID_SOREVN))$sor=self::getSorevn($ID_SOREVN);
    else $sor=$ID_SOREVN;
    try{
      if($sor['PROPERTIES']['STATUS']['VALUE']=='closed')throw new Exception(false);
      if($sor['PROPERTIES']['REGISTRACIYA_OFF']['VALUE']=='Y')throw new Exception(false);
    }catch(Exception $e){
      $ret=false;
    }
    return $ret;
  }
  static function isGlavSud($ID_SOREVN){
    if(
      //CSite::InGroup(array(1)) or 
      ($GLOBALS['USER']->GetID()==self::getGlavnSud($ID_SOREVN)['PROPERTIES']['SUDYA']['VALUE'] and Aiplk::getStartPage()=='sud')      
    )return true;
    else return false;
  }
  static function getSportsmenyTblGorod($ID_SOREVN){
    $a=self::getSportsmeny($ID_SOREVN);
    $ret=array(); 
    foreach($a as $aspm){
      $reg=self::getRegionTitle($aspm)['txt'];
      if(!isset($ret[$reg]))$ret[$reg]=0;
      $ret[$reg]++;
    }
    return $ret;
  }  
  static function getSportsmenyTblRazryad($ID_SOREVN){
    $a=self::getSportsmeny($ID_SOREVN);
    $aGoroda=self::getRazryad();
    $ret=array();
    foreach($aGoroda as $ag){      
      $ret[$ag['UF_NAME']]=0;
      foreach($a as $aspm){
        if($ag['UF_XML_ID']==$aspm['PROPERTIES']['RAZRYAD']['VALUE']){
          $ret[$ag['UF_NAME']]++;
        }
      }
    }
    return $ret;
  }
  static function getFIO($ID_USER){
    if(is_array($ID_USER))$_r=$ID_USER;
    else{
      $_r=CUser::GetByID($ID_USER);
      $_r=$_r->Fetch();
    }
    if(isset($_r['USER_SPORTSMEN'])){
      $_r=$_r['USER_SPORTSMEN'];
    }
    $ret=$_r['LAST_NAME'].' '.$_r['NAME'].' '.$_r['SECOND_NAME'];
    return $ret;
  }
	static function setFIO(&$aUser){
		$aUser['LAST_NAME']=self::mb_ucfirst($aUser['LAST_NAME']);
		$aUser['NAME']=self::mb_ucfirst($aUser['NAME']);
		$aUser['SECOND_NAME']=self::mb_ucfirst($aUser['SECOND_NAME']);
		return $aUser;
	}
	static function mb_ucfirst(string $string, string $encoding = 'UTF-8'): string{
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $thenChars = mb_substr($string, 1, null, $encoding);
    
    return mb_strtoupper($firstChar, $encoding) . mb_strtolower($thenChars, $encoding);
	}
  static function getRegionTitle($aItem){
    $ret=array('txt'=>'', 'val'=>'', 's'=>'', 'r'=>'', 'g'=>'');
    if(isset($aItem['PROPERTIES']['REGION_SPR']['VALUE'])){
      $_r=self::getRegionSprNew($aItem['PROPERTIES']['REGION_SPR']['VALUE']);
      $aItem['PROPERTIES']['REGION']['VALUE']=$_r['UF_NAME'];
      $ret['txt']=$aItem['PROPERTIES']['REGION_STRANA']['VALUE'].', '.$aItem['PROPERTIES']['REGION']['VALUE'].', '.$aItem['PROPERTIES']['REGION_GOROD']['VALUE'];
      $ret['val']=$aItem['PROPERTIES']['REGION_STRANA']['VALUE'].'_'.$aItem['PROPERTIES']['REGION']['VALUE'].'_'.$aItem['PROPERTIES']['REGION_GOROD']['VALUE'];
      $ret['val']=str_replace(' ', '-', $ret['val']);
      $ret['s']=$aItem['PROPERTIES']['REGION_STRANA']['VALUE'];
      $ret['r']=$aItem['PROPERTIES']['REGION']['VALUE'];
      $ret['g']=$aItem['PROPERTIES']['REGION_GOROD']['VALUE'];
      $ret['xmlval']=$aItem['PROPERTIES']['REGION_STRANA']['VALUE'].'_'.$aItem['PROPERTIES']['REGION_SPR']['VALUE'].'_'.$aItem['PROPERTIES']['REGION_GOROD']['VALUE'];
			$ret['UF_XML_ID']=$aItem['PROPERTIES']['REGION_SPR']['VALUE'];
    }
    if(isset($aItem['UF_REGION_SPR'])){
      $_r=self::getRegionSprNew($aItem['UF_REGION_SPR']);
      $aItem['UF_REGION']=$_r['UF_NAME'];
      $ret['txt']=$aItem['UF_REGION_STRANA'].', '.$aItem['UF_REGION'].', '.$aItem['UF_GOROD'];
      $ret['val']=$aItem['UF_REGION_STRANA'].'_'.$aItem['UF_REGION'].'_'.$aItem['UF_GOROD'];
      $ret['val']=str_replace(' ', '-', $ret['val']);
      $ret['s']=$aItem['UF_REGION_STRANA'];
      $ret['r']=$aItem['UF_REGION'];
      $ret['g']=$aItem['UF_GOROD'];
      $ret['xmlval']=$aItem['UF_REGION_STRANA'].'_'.$aItem['UF_REGION_SPR'].'_'.$aItem['UF_GOROD'];
			$ret['UF_XML_ID']=$aItem['UF_REGION_SPR'];
    }
    return $ret;
  }
	static function getVozrast($aUser){
    $currentDate=new DateTime();    
    $startDate=new DateTime(ConvertDateTime($aUser['PERSONAL_BIRTHDAY'], "YYYY-MM-DD", "ru"));
    $diff=$currentDate->diff($startDate);    
    $vozrast=$diff->y;
		return $vozrast;
	}
  static function getVozrastGruppa($ID_USER){//отдаем возр.группу юзера
    if(is_array($ID_USER))$_r=$ID_USER;
    else{
      $_r=CUser::GetByID($ID_USER);
      $_r=$_r->Fetch();
    }
    $pol=$_r['PERSONAL_GENDER'];
    if($pol=='M')$p='3';
    else $p='4';
    $vozrast=self::getVozrast($_r);
    $vsearch=$vozrast;
    //если дата рождения еще будет, то +1год (кроме групп муж и жен, туда можно попасть только по факту 18-летия)
    if($vozrast<17){
      $startDate=strtotime(ConvertDateTime($_r['PERSONAL_BIRTHDAY'], date('Y')."-MM-DD", "ru"));
      $nowDate=strtotime(date('Y-m-d'));
      if($nowDate<$startDate)$vsearch++;
    }
    //
    $aFilter=array('<=UF_OT'=>$vsearch, '>=UF_DO'=>$vsearch, 'UF_POL'=>$p);
    $ret=self::getHighloadIB(13, $aFilter, array("UF_SORT"=>"ASC"));
    $gruppa=array_shift($ret);
    if(empty($gruppa))$gruppa=false;
    return array($pol, $vozrast, $gruppa);
  }
	static function vozrastTitle($i){
    if(preg_match("|(1)$|",$i))$comment='год';
    elseif(preg_match("/(2|3|4)$/",$i))$comment='года';
    else $comment='лет';
    if(preg_match("/(1)[0-9]$/",$i))$comment='лет';
    return $comment;
	}
	static function parseRegion(string $postRegion, $findName=false){
		$ret=array();
		$postRegion=addslashes($postRegion);
		$aMesto=explode('_', $postRegion);
		if(count($aMesto)!==3)return false;
		$aMesto[0]=addslashes(trim($aMesto[0]));
		$aMesto[1]=addslashes(trim($aMesto[1]));
		$aMesto[2]=addslashes(trim($aMesto[2]));
    $ret['strana']=$aMesto[0];
    $ret['strana']=str_replace(' ', '-', $ret['strana']);
    //$ret['region']=$aMesto[1];

    if($findName)$_reg=self::getRegionSprNew($aMesto[1], true);
    else $_reg=self::getRegionSprNew($aMesto[1]);

    if($_reg==false)return false;
    $ret['region']=$_reg['UF_NAME'];
    $ret['region_xml']=$_reg['UF_XML_ID'];
    $ret['region_id']=$_reg['ID'];
    $ret['gorod']=$aMesto[2];
    $ret['gorod']=str_replace(' ', '-', $ret['gorod']);
		return $ret;
	}
  static function fltSportsmenGroup(&$aItem, $xmlIdGroup, $xmlIdDisc){
    $ret=array();
    foreach($aItem as $k=>$item){
      if(empty($item['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']))$item['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']=array();
      if(empty($item['PROPERTIES']['DISCIPLINY']['VALUE']))$item['PROPERTIES']['DISCIPLINY']['VALUE']=array();
      if(        
        ($item['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']==$xmlIdGroup or $xmlIdGroup=='all') and
        (in_array($xmlIdDisc, $item['PROPERTIES']['DISCIPLINY']['VALUE']) or $xmlIdDisc=='all')
      ){
        $ret[$k]=$item;
      }
    }    
    return $ret;
  }
  static function protokolGetStendSmena($aStendy, $mesto, $allStendCount, $s=1, $sSer=1){
    if(empty($s))$s=1;
    if(empty($sSer))$sSer=1;
    $s=$s-1;
    $sSer=$sSer-1;
  	$ret=array('smena'=>0, 'stend'=>0);
    $smena=1;
  	if($mesto>$allStendCount){
      $smena=floor($mesto/$allStendCount)+1;
      $mesto=$mesto%$allStendCount;
    }
    $_stend=array_search(($mesto), $aStendy);
  	if($_stend!==false){
  		$ret['smena']=$smena;
  		$ret['stend']=$_stend+1;
  	}else{
  		//$ret['smena']=floor($mesto/$allStendCount)+1;
  		//$ret['stend']=$aStendy[$mesto%$allStendCount];
  	}
    $ret['stend']+=$s;
    $ret['smena']+=$sSer;
  	return $ret;
  }
  static function getSort($aItem, $flt_disc=false){
    $ret=false;
    if(isset($aItem['PROPERTIES']['SORT']['~VALUE']))$a=$aItem['PROPERTIES']['SORT']['~VALUE'];
    else $a=$aItem['~PROPERTY_SORT_VALUE'];
    $a=json_decode($a, true);
    if($a and $flt_disc){
      if(!empty($a[$flt_disc]))$ret=$a[$flt_disc];
    }else $ret=$a;
    return $ret;
  }
  static function getLastUserSort($aProps, $ID_SOREVN){
    if(!empty($aProps['DISCIPLINY']) and is_array($aProps['DISCIPLINY'])){
      $aProps['SORT']=array();
      $aDisc=Aiplk::getDisciplina();
      $aSportsmeny=Aiplk::getSportsmeny($ID_SOREVN);
      $aCurrentDiscipl=array();
      foreach($aDisc as $_gr){
        if(!in_array($_gr['UF_XML_ID'], $aProps['DISCIPLINY']))continue;
        foreach($aSportsmeny as $_item){
          if(is_array($_item['PROPERTIES']['DISCIPLINY']['VALUE']) and in_array($_gr['UF_XML_ID'], $_item['PROPERTIES']['DISCIPLINY']['VALUE'])){
            $_sort=json_decode($_item['PROPERTIES']['SORT']['~VALUE'], true);
            if(!empty($_sort[$_gr['UF_XML_ID']])){
              $aCurrentDiscipl[$_gr['UF_XML_ID']][$_item['ID']]=$_sort[$_gr['UF_XML_ID']];
            }
          }
        }
      }
      $aSort=array();
      foreach($aCurrentDiscipl as $discId=>$aSorts){
        sort($aSorts);
        $k=$aSorts[count($aSorts)-1]+1;
        $aSort[$discId]=$k;
      }
      return json_encode($aSort, JSON_UNESCAPED_UNICODE);
    }
    return '';
  }
  static function updateProgramKolvo($aProps, $SOREVN_ID){
    $el=new CIBlockElement;
    $aProgrammy=Aiplk::getProgrammy($SOREVN_ID);
    $aVarEtap=Aiplk::getVariantEtap();
    foreach($aProgrammy as $aProg){
      $etapAllKolvoDef_k=$aVarEtap[$aProg['PROPERTIES']['VARETAP']['VALUE']]['PROPERTIES']['ETAP']['VALUE'];
      if(empty($etapAllKolvoDef_k))continue;
      $etapAllKolvoDef_k=array_search($aProg['PROPERTIES']['ETAP']['VALUE'], $etapAllKolvoDef_k);
      if($etapAllKolvoDef_k!==false){
        if(
          $aProg['PROPERTIES']['VOZRAST_GRUPPA']['VALUE']==$aProps['VOZRAST_GRUPPA'] and        
          in_array($aProg['PROPERTIES']['DISCIPLINA']['VALUE'], $aProps['DISCIPLINY']) and 
          $aVarEtap[$aProg['PROPERTIES']['VARETAP']['VALUE']]['PROPERTIES']['KOLVO']['VALUE'][$etapAllKolvoDef_k]==0
        ){
          $allKol=count(Aiplk::getSportsmenyKolvo($SOREVN_ID, $aProg['PROPERTIES']['DISCIPLINA']['VALUE'], $aProps['VOZRAST_GRUPPA']));
          $el->SetPropertyValuesEx($aProg['ID'], 5, ['KOLVO_UCH'=>$allKol]);
        }
      }
    }    
  }
  static function getHLXML_fromID(&$aSpr, $id, $key='UF_XML_ID'){
    foreach($aSpr as $k=>$v){
      if($v['ID']==$id)return $v[$key];
    }
  }
  static function deleteFilesFromIB($IBLOCK_ID, $ID, $FIELD){//удалить все файлы из ИБ
    $dbElements = \CIBlockElement::GetList(
      [],
      [
        "IBLOCK_ID" => $IBLOCK_ID,
        "ID" => $ID
      ],
      false,
      false,
      [
        'IBLOCK_ID',
        'ID',
        'PROPERTY_'.$FIELD,
      ]
    );
    while($obFields = $dbElements->GetNext()){
      //$arFiles = [$obFields['PROPERTY_'.$FIELD.'_VALUE'][0]];
      $aElementID = $obFields['ID']; 
      foreach ($obFields['PROPERTY_'.$FIELD.'_VALUE'] as $iKeyValue => $sValue) {
        //if (in_array($sValue, $arFiles) && $obFields['PROPERTY_'.$FIELD.'_PROPERTY_VALUE_ID'][$iKeyValue] > 0) {
          $arDeleteList[$FIELD][$obFields['PROPERTY_'.$FIELD.'_PROPERTY_VALUE_ID'][$iKeyValue]] = [
            'VALUE' => [
              'del' => 'Y',
            ]
          ];
        //}
      }
      if (!empty($arDeleteList)) {
        foreach ($arDeleteList as $sPropForDelete => $arDeleteFiles) {
          CIBlockElement::SetPropertyValueCode(
            $aElementID,
            $sPropForDelete,
            $arDeleteFiles
          );
        }
      }

    }    
  }
  static function getSprtPhoto($userId, $status='sport'){
    $aUser=self::getUser($userId);
    $ret='';
    $firstFull='';
    if($status=='sud' and !empty($aUser['UF_PHOTO_SUD'])){
      $ret=$aUser['UF_PHOTO_SUD'];
      if(empty($firstFull))$firstFull=$aUser['UF_PHOTO_SUD'];
    }elseif($status=='sport' and !empty($aUser['UF_PHOTO_SPRT'])){
      $ret=$aUser['UF_PHOTO_SPRT'];
      if(empty($firstFull))$firstFull=$aUser['UF_PHOTO_SPRT'];
    }elseif($status=='org' and !empty($aUser['UF_PHOTO_ORG'])){
      $ret=$aUser['UF_PHOTO_ORG'];
      if(empty($firstFull))$firstFull=$aUser['UF_PHOTO_ORG'];
    }elseif($status=='trener' and !empty($aUser['UF_PHOTO_TREN'])){
      $ret=$aUser['UF_PHOTO_TREN'];
      if(empty($firstFull))$firstFull=$aUser['UF_PHOTO_TREN'];
    }elseif(!empty($aUser['UF_PHOTO_MAIN'])){
      $ret=$aUser['UF_PHOTO_MAIN'];
      if(empty($firstFull))$firstFull=$aUser['UF_PHOTO_MAIN'];
    }
    if(empty($ret))$ret=$firstFull;
    //v($ret);die();
    return $ret;
  }
  static function getWorkcompArr($s){
    $ret=explode(',', $s);
    foreach($ret as $k=>$v)$ret[$k]=trim($v);
    return $ret;
  }
  static function sortArrTblClass($nfield=0){
    $rt='';
    $sf='0';
    $desc='';    
    if(isset($_REQUEST['sort_field'])){
      $sf=intval($_REQUEST['sort_field']);
    }
    if(isset($_REQUEST['desc'])){
      $desc=intval($_REQUEST['desc']);
    }
    if($sf==$nfield)$ret='col_sort_active';
    if(!empty($desc))$ret.=' desc';
    return $ret;
  }
  static function sortArrTbl(&$arr){
    global $sf;
    $sf='0';
    $desc='';
    if(isset($_REQUEST['sort_field'])){
      $sf=intval($_REQUEST['sort_field']);
    }
    if(isset($_REQUEST['desc'])){
      $desc=intval($_REQUEST['desc']);
    }
    if(empty($desc)){
      usort($arr, function($a, $b){
        global $sf;
        if($a[$sf]==$b[$sf])return 0;
        return $a[$sf] < $b[$sf]?-1:1;
      });
    }else{
      usort($arr, function($a, $b){
        global $sf;
        if($a[$sf]==$b[$sf])return 0;
        return $a[$sf] > $b[$sf]?-1:1;
      });
    }
  }
  static function getSprt4trener($trenerId, $flt=false){
    $aUsers=UserTable::getList([
        'filter'=>['UF_TRENER_ID'=>$trenerId],
        'select'=>['*', 'UF_TRENER_DATE_ADD', 'UF_COMM', 'UF_DOPUSK', 'UF_REGION_SPR', 'UF_REGION', 'UF_GOROD', 'UF_REGION_STRANA', 'UF_TRENER_ID', 'UF_SUD_KAT', 'UF_RAZR', 'UF_PHOTO_MAIN', 'UF_PHOTO_SPRT', 'UF_PHOTO_ORG', 'UF_PHOTO_SUD', 'UF_PHOTO_TREN']
    ])->fetchAll();
    $aIds=array();
    foreach($aUsers as $k=>$aUser)$aIds[]=$aUser['ID'];
 
    $aOrder=['NAME'=>'ASC'];    
    $aFilter=['ACTIVE'=>'Y', 'IBLOCK_ID'=>6, 'PROPERTY_SPORTSMEN'=>$aIds];
    $aSprts=self::getIB($aFilter, $aOrder);
 
    foreach($aUsers as $k=>$aUser){
      foreach($aSprts as $sprt){
        if($aUser['ID']==$sprt['PROPERTIES']['SPORTSMEN']['VALUE']){
          if(!isset($aUser[$k]['sprts']))$aUser[$k]['sprts']=array();
          //$sprt['PROPERTIES']['REZULTATY_JSON']=json_decode($sprt['PROPERTIES']['REZULTATY_JSON']['~VALUE'], true);
          $aUsers[$k]['sprts'][]=$sprt;
        }
      }
    }

    return $aUsers;
  }
  static function getFirst(array $a, $returnKey=false){foreach($a as $k=>$v)if($returnKey)return $k;else return $v;}
  static function prepareSprtTblFromFilter($aSprts, $god=false, $disc_XML_ID=false){
    if(empty($aSprts))$aSprts=array();
    $aPrgsID=array();
    $aSprtTbl=array();
    foreach($aSprts as $sprt){
      $aSprtTbl[$sprt['ID']]=Aiplk::getSportsmenResults($sprt['ID']); 
      foreach($aSprtTbl[$sprt['ID']] as $prgId=>$dataTbl)$aPrgsID[]=$prgId;
    }
    $aOrder=['PROPERTY_VREMYA_NACH'=>'ASC', 'PROPERTY_VOZRAST_GRUPPA'=>'ASC'];   
    $aFilter=['IBLOCK_ID'=>5, 'ID'=>$aPrgsID];
    $aPrgs=self::getIB($aFilter, $aOrder);

    $aSelectGod=array();
    $aSelectDisc=array();    
    $aAllGod=array();
    $aAllDisc=array();
    $aAll=array();
    $aPrgInfo=array();

    foreach($aSprtTbl as $userId=>$aData){
      foreach($aData as $prgId=>$prgData){
        $timestamp=MakeTimeStamp($aPrgs[$prgId]['PROPERTIES']['VREMYA_NACH']['VALUE'], 'DD.MM.YYYY HH:MI:SS');
        $dateYear=date('Y', $timestamp);
        //фильтр
        $fFlt=false;
        if($god){
          if($dateYear!=$god)$fFlt=true;
        }
        if($disc_XML_ID){
          if($disc_XML_ID!=$aPrgs[$prgId]['PROPERTIES']['DISCIPLINA']['VALUE'])$fFlt=true;
        }

        $aAllGod[$dateYear]=$dateYear;
        $aAllDisc[$aPrgs[$prgId]['PROPERTIES']['DISCIPLINA']['VALUE']]=self::getDisciplina($aPrgs[$prgId]['PROPERTIES']['DISCIPLINA']['VALUE'])['NAME'];

        if($fFlt){
          $aSelectGod[$dateYear]=$dateYear;
          $aSelectDisc[$aPrgs[$prgId]['PROPERTIES']['DISCIPLINA']['VALUE']]=self::getDisciplina($aPrgs[$prgId]['PROPERTIES']['DISCIPLINA']['VALUE'])['NAME'];
          unset($aSprtTbl[$userId][$prgId]);
          continue;
        }    
        ///
        $aMesto=self::getMestoFromProgramma($aPrgs[$prgId]);
        $aSprtTbl[$userId][$prgId]=array(
          'GOD'=>$dateYear,
          'VREMYA_NACH'=>$aPrgs[$prgId]['PROPERTIES']['VREMYA_NACH']['VALUE'], 
          'DISCIPLINA'=>$aPrgs[$prgId]['PROPERTIES']['DISCIPLINA']['VALUE'],
          'MESTO'=>$aMesto[$userId][0],
          'OCHKOV'=>$aMesto[$userId][1],
        );
        $aSredPoZachSer=array();
        foreach($prgData as $kzs=>$zs)$aSredPoZachSer[$kzs]=array_sum($zs);
        $aSprtTbl[$userId][$prgId]['DATA']=$aSredPoZachSer;

        $_prgDataSum=0;
        foreach($prgData as $k1=>$row1)$_prgDataSum+=array_sum($row1);
        $aAll[$aPrgs[$prgId]['ID']]=array($_prgDataSum);
        $aPrgInfo[$aPrgs[$prgId]['ID']]=$aPrgs[$prgId];
      }
    }
    sort($aAllGod);
    asort($aAllDisc);
    return array('tbl'=>$aSprtTbl, 'filters'=>['GOD'=>$aSelectGod, 'DISC'=>$aSelectDisc], 'ALL'=>$aAll, 'PRG'=>$aPrgInfo, 'ALL_GOD'=>$aAllGod, 'ALL_DISC'=>$aAllDisc);
  }
  /*
  убираем все ненужные соревнования и программы(дисциплины) одного юзера
  */
  static function getSprtTblFromFilter(&$aSprtTbl, $iskl_prgid=[]){
    $aDataSer=array();
    //$aSprtTbl - из prepareSprtTblFromFilter() - сумма по каждой серии по каждой программе и соревнованию 
    foreach($aSprtTbl as $userId=>$aPrg){
      if(empty($aSprtTbl[$userId])){
        unset($aSprtTbl[$userId]);
        continue;
      }
      foreach($aPrg as $prgId=>$data){
        if(!in_array($prgId, $iskl_prgid))$aDataSer[]=$data['DATA'];   
      }
    }
    $ret=self::_sumNestedArraysWithFill($aDataSer);
    $ret=array_values($ret);
    return $ret;
  }
  static private function _sumNestedArraysWithFill($arrays) {
      $result = [];
      $allKeys = [];
      // Шаг 1. Собираем все возможные ключи из всех вложенных массивов
      foreach ($arrays as $subArray) {
          foreach (array_keys($subArray) as $key) {
              $allKeys[$key] = true;
          }
      }
      // Шаг 2. Инициализируем итоговый массив нулями для всех ключей
      foreach (array_keys($allKeys) as $key) {
          $result[$key] = 0;
      }
      // Шаг 3. Суммируем значения, подставляя 0 для отсутствующих ключей
      foreach ($arrays as $subArray) {
          foreach ($allKeys as $key => $dummy) {
              $result[$key] += $subArray[$key] ?? 0;
          }
      }
      return $result;
  }

  static function getSatisticSprt($data) {
      $numbers = [];
      // Извлекаем все числовые значения из многомерного массива
      foreach ($data as $prgId=>$subArray) {
          if (is_array($subArray)) {
              foreach ($subArray as $value) {
                  // Преобразуем строку в число и добавляем в общий массив
                 if($value>0)$numbers[] = (float)$value;
              }
          }
      }
      // Если массив чисел пуст, возвращаем ошибку
      if (empty($numbers)) {
          return false;
      }
      // Находим минимальное и максимальное значения
      $min = min($numbers);
      $max = max($numbers);
      // Вычисляем среднее значение
      $average = array_sum($numbers) / count($numbers);
      foreach ($data as $prgId=>$subArray) {
          if (is_array($subArray)) {
              foreach ($subArray as $value) {                 
                 if($value==$min)$minPrgId=$prgId;
                 if($value==$max)$maxPrgId=$prgId;
              }
          }
      }
      return [
          'minPrgId'=>$minPrgId,
          'maxPrgId'=>$maxPrgId,
          'min' => $min,
          'max' => $max,
          'average' => round($average, 0) // Округляем до 2 знаков после запятой
      ];
  }
  static function getMaxBallov($aPrg){
    $ret=$aPrg['PROPERTIES']['KOLVO_SERIY']['VALUE']*$aPrg['PROPERTIES']['KOLVO_BROSKOV']['VALUE']*60;
    return $ret;
  }
  static function getProcent($c, $all){
    if ($all == 0)return 0;
    return ($c / $all) * 100;
  }
}
?>