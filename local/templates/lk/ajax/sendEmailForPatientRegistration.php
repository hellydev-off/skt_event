<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Mail\Event;
// global $USER;
$user_email = trim(addslashes($_POST["USER"]["EMAIL"]));
$session = \Bitrix\Main\Application::getInstance()->getSession();
$session->set('registration_sms_time', time());
$email_code = rand(11111, 99999);
$session->set('registration_sms_code', $email_code);
$to = $user_email;

      $result=Event::send(array(
            'EVENT_NAME' => 'EMAIL_CODE',
            'LID' => SITE_ID,
            'C_FIELDS' => [
                'EMAIL' => $user_email,
                'EMAIL_CODE' => $email_code
            ],
        ));

        if (!$result->isSuccess()) {
          echo json_encode( ['error' => "Ошибка отправки кода ".$result->getErrorMessages()]);
        } else {
          echo json_encode(['mail_number' => $user_email, 'mail_code'=>$email_code]);
        }
// $subject = 'Код подтверждения для сайта '.SITE_SERVER_NAME;
// $message = 'Код:' . $email_code;
// $headers = 'From: info@skt-event.com' . "\r\n" .
//     'Reply-To: info@skt-event.com' . "\r\n" .
//     'X-Mailer: PHP/' . phpversion();
// $success = mail($to, $subject, $message, $headers);
// if ($success) {
     //echo json_encode(['mail_number' => $user_email, 'mail_code'=>$email_code]);
// } else {
//     $errorMessage = error_get_last()['message'];
// 	echo json_encode( ['error' => "Ошибка отправки кода"]); //$errorMessage
// };

// //eockimizaudtazfw

// file_put_contents("post.log", print_r($_POST, true), FILE_APPEND);


die();