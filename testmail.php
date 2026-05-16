<?php

/* получатели */
$to= "Mary <fisherman.gstream@gmail.com>" . ", " ; //обратите внимание на запятую
$to .= "Kelly <zakaz@gstream.com.ua>";

/* тема/subject */
$subject = "Birthday Reminders for August";

/* сообщение */
$message = '
<html>
<head>
 <title>Birthday Reminders for August</title>
</head>
<body>
<p>Here are the birthdays upcoming in August!</p>
<table>
 <tr>
<th>Person</th><th>Day</th><th>Month</th><th>Year</th>
 </tr>
 <tr>
<td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
 </tr>
 <tr>
<td>Sally</td><td>17th</td><td>August</td><td>1973</td>
 </tr>
</table>
</body>
</html>
';

/* Для отправки HTML-почты вы можете установить шапку Content-type. */
$headers= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* дополнительные шапки */
$headers .= "From: Birthday Reminder <birthday@example.com>\r\n";
$headers .= "Cc: birthdayarchive@example.com\r\n";
$headers .= "Bcc: birthdaycheck@example.com\r\n";

/* и теперь отправим из */
mail($to, $subject, $message, $headers);

?>