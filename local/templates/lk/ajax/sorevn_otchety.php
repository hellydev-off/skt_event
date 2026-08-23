<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if(!empty($id=intval($_REQUEST['get']))){
  include \Bitrix\Main\Loader::getDocumentRoot().'/include/sorevn/otchety_tpl.php';
  die();
}