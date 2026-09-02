<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(!in_array(8, $arGroups))die();
$APPLICATION->SetTitle('Страховка');
?>
<div class="h1_cont">
  <h1>Страховка</h1>
  <div>&nbsp;</div>
</div>

<div id="eu-accident-knife-throwing"></div>
<script src="https://euro-ins.ru/front/dist/js/calc/accident/knife-throwing/calculator.js"></script>
<script>
     (function () {
         window.addEventListener('eCalcLoaded', function () {
            new AccidentKnifeThrowing(
                'eu-accident-knife-throwing',
                    {
                        token: '35e31f3d-e57a-433b-b588-7ad8bb3d3cd2'
                     }
                )
         })
     })()
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
