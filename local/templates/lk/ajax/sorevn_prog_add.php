<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!CSite::InGroup(array(1,9,7,12,11)))die('Нет доступа.');
CModule::IncludeModule('iblock');
use Bitrix\Main\Mail\Event;
if(!empty($id=intval($_REQUEST['get']))){
  include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/programmy_tpl.php';
  die();
}
//var_dump('<pre>',$_POST,'</pre>');die();
$ret=array('err'=>'', 'html'=>'');
try{
  if(empty($SOREVN_ID=intval($_REQUEST['ID_SOREVN'])))throw new Exception('Нет id мероприятия :(');
  if(empty($_REQUEST['prog']) or !is_array($_REQUEST['prog']))throw new Exception('Нет данных :(');
  if(Aiplk::getStartPage()=='sud' and !Aiplk::isGlavSud($SOREVN_ID))die('Нет доступа.');

  $sprVozrGruppa=Aiplk::getVozrastGuppa();
  $sprDisciplina=Aiplk::getDisciplina();
  $sprEtap=Aiplk::getEtap();
  $el=new CIBlockElement;
    //деактивируем все программы соревнования
    $aOrder=['VREMYA_NACH'=>'ASC', 'VOZRAST_GRUPPA'=>'ASC'];
    $aFilter=['IBLOCK_ID'=>5, 'PROPERTY_ID_SOREVN'=>$SOREVN_ID];
    $_aprg=Aiplk::getIB($aFilter, $aOrder);
    foreach($_aprg as $row){
    	$el->update($row['ID'], ['ACTIVE'=>'N']);
    	//$el->SetPropertyValuesEx($row['ID'], 5, ['VARETAP'=>$aItem['VARETAP'], 'VARSTEND'=>$aItem['VARSTEND']]);
    }
    ///
  $aItem=array();
  //v($_REQUEST['prog']);die();
  foreach($_REQUEST['prog'] as $item){

    $aItem['NAME']=$sprEtap[$item['ETAP']]['UF_NAME'].' - '.$sprVozrGruppa[$item['VOZRAST_GRUPPA']]['UF_NAME'].' - '.$sprDisciplina[$item['DISCIPLINA']]['UF_NAME'];
    $aItem['ID_SOREVN']=$SOREVN_ID;
    $aItem['VREMYA_NACH']=new \Bitrix\Main\Type\DateTime(date('d.m.Y H:i:s', strtotime($item['VREMYA_NACH1'].' '.$item['VREMYA_NACH2'])));
    unset($item['VREMYA_NACH1']);
    unset($item['VREMYA_NACH2']);
    $aItem=array_merge($aItem, $item);
    $id=intval($item['ID']);
    unset($aItem['ID']);
      $data=[
        'CREATED_BY'=>$GLOBALS['USER']->GetID(),
        'IBLOCK_SECTION_ID'=>false,
        'IBLOCK_ID'=>5,
        'NAME'=>$aItem['NAME'],
        'ACTIVE' => 'Y',
        'PROPERTY_VALUES'=>$aItem
      ];

    // v($data);
    // v($id);
    // continue;

    if(empty($id)){//новый

		  //есть ли такая? VOZRAST_GRUPPA DISCIPLINA
		  $aOrder=['NAME'=>'ASC'];
		  $aFilter=[
		  	'IBLOCK_ID'=>5,
		  	'PROPERTY_ID_SOREVN'=>$SOREVN_ID,
		  	'PROPERTY_VOZRAST_GRUPPA'=>addslashes($aItem['VOZRAST_GRUPPA']),
		  	'PROPERTY_DISCIPLINA'=>addslashes($aItem['DISCIPLINA']),
		  	'PROPERTY_ETAP'=>addslashes($aItem['ETAP'])
		  ];
		  $_ret=Aiplk::getIB($aFilter, $aOrder);
		  if(count($_ret)>0){
        $_ret=array_shift($_ret);
        if($_ret['ACTIVE']=='N'){//восстанавливаем не активную
          $el->update($_ret['ID'], $data);
          $el->SetPropertyValuesEx($_ret['ID'], 5, $aItem);
          if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
          continue;
        }else{//активная уже есть - ошибка
          $ret['err'].=$sprEtap[addslashes($aItem['ETAP'])]['NAME'].' '.
            $sprVozrGruppa[addslashes($aItem['VOZRAST_GRUPPA'])]['NAME'].' '.
            $sprDisciplina[addslashes($aItem['DISCIPLINA'])]['NAME'].' не сохранено, такая запись уже есть';
          continue;
        }
		  }
      $data['PROPERTY_VALUES']['SO_STENDA']=1;
      $data['PROPERTY_VALUES']['S_SERII']=1;
      if($aOrderId[]=$el->Add($data)){
        $ret['html']='Сохранено';
      }else throw new Exception('Новый - '.$el->LAST_ERROR);
    }else{//старый
      $el->update($id, $data);
      $el->SetPropertyValuesEx($id, 5, $aItem);
      if($el->LAST_ERROR)throw new Exception($el->LAST_ERROR);
    }
  }
}catch(Exception $e){
  $ret['err']=$e->getMessage();
}
die(json_encode($ret, JSON_UNESCAPED_UNICODE));