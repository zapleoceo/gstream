<?php
class SmsFlyC {
    private $baseurl = 'http://sms-fly.com/api/api.php';
    private $login;
    private $password;
    private $source;

    public function __construct($login, $password, $source="InfoCentr")
    {
        $this->login = $login;
        $this->password = $password;
        if ($source == "") {
            $this->source = "InfoCentr";
        } else {
            $this->source = htmlspecialchars($source);
        }

    }

    public function sfSendSms($settings, $debugmode = false)
    {
        $source         = $this->source;
        $recipient      = preg_replace("/[^0-9+]/",'', $settings['SMSFLY_PHONE']);
        $text           = htmlspecialchars($settings['SMSFLY_TEXT']);
        $start_time     = 'AUTO';
        $end_time       = 'AUTO';
        $rate           = 1;
        $lifetime       = 4;
        $description    = '';
        $version        = 'wordpress 1.1';
        $textQuery 	 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $textQuery 	.= "<request>";
        $textQuery 	.= "<operation>SENDSMS</operation>";
        $textQuery 	.= '		<message start_time="'.$start_time.'" end_time="'.$end_time.'" lifetime="'.$lifetime.'" rate="'.$rate.'" desc="'.$description.'" source="'.$source.'" version="'.$version.'">'."\n";
        $textQuery 	.= "		<body>".$text."</body>";
        $textQuery 	.= "		<recipient>".$recipient."</recipient>";
        $textQuery 	.=  "</message>";
        $textQuery 	.= "</request>";

        $obj = $this->sfQuery($textQuery);

        if ($obj) {
            return $this->sfParser($obj,'code');
        } else {
            return false;
        }
    }

    public function sfBalance()
    {
        $textQuery 	 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $textQuery 	.= "<request>";
        $textQuery 	.= "<operation>GETBALANCE</operation>";
        $textQuery 	.= "</request>";

        $obj = $this->sfQuery($textQuery);

        if ($obj) {
            return $this->sfParser($obj,'balance');
        } else {
            return false;
        }
    }

    private function sfQuery ($textQuery)
    {
        $auth = $this->login.':'.$this->password;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD , $auth);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $this->baseurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $textQuery);
        $result = curl_exec($ch);
        curl_close($ch);

        if (isset($result)) {
            return $result;
        }
        return false;
    }

    private function sfParser ($obj, $child, $attribut=null) {
        if ($obj === 'Access denied! Incorrect login or password.') {
            return "Неверные учетные данные!";
        }

        try {
            $xml = new SimpleXMLElement($obj);

            if ($child === 'balance') {
                return "У Вас на счету ".(string)$xml->balance. " грн. ";
            }

            if ($child === 'code') {
                $code = (string)$xml->state['code'];
                switch ($code) {
                    case 'ERRPHONES': $text = "Неправильный номер получателя!"; break;
                    case 'ACCEPT': $text = "Сообщение отправлено."; break;
                    case 'ERRTEXT': $text = "Текст сообщения не может быть пустым."; break;
                    default: error_log($obj); return false;
                }

                return $text;
            }
        } catch (Exception $e) {
            error_log($obj);
            return false;
        }
    }
}