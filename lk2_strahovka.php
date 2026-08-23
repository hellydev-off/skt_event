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
                        token: 'g3NJwswjYt9LG'
                     }
                )
         })
     })()
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
