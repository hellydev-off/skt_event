<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
die(Aiplk::setGroup(intval($_REQUEST['gid'])));
?>