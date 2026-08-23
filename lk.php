<?
//leaxxxwu.beget.tech
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$arGroups=CUser::GetUserGroup($GLOBALS['USER']->GetID());
if(in_array(11, $arGroups))require_once 'lk_ross.php';
elseif(in_array(12, $arGroups))require_once 'lk_region.php';
elseif(in_array(10, $arGroups))require_once 'lk2_trener.php';
else require_once 'lk_user.php';
?>

<script>
    $("#COMPANY_PHONE").mask("+7 999 999-99-99");
    $('.popup.popup-sent .popup__bgd, .popup.popup-sent .popup__close, .popup.popup-sent .popup__close_button').on('click', function () {
                $('.popup.popup-sent').removeClass('popup_open');
                //window.location = '/';
                location.reload();
    });
</script>

</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>