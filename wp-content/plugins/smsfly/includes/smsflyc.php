<?php
class SMSflyC {
	private $baseurl = 'https://sms-fly.ua/api/v2/api.php';
	private $apikey, $balanceuah, $lastactionstatus = true;
	private $sourceList = ['sms' => [], 'viber' => []], $sourceSMS, $sourceViber;
	private $appversion = 'wordpress 2.0.1';
	private $response = [];

	const DEFAULT_ERROR = 'Unknown error';

	static private $flyObj = null;

	private function __construct($apikey) {
		$this->apikey = $apikey;
	}

	public function setSources($sourceSMS = null, $sourceViber = null) {
		$this->sourceSMS = $sourceSMS ?: $this->sourceList['sms'][0] ?? '';
		$this->sourceViber = $sourceViber ?: $this->sourceList['viber'][0] ?? '';
	}

	public function __get($name) {
		switch ($name) {
			case 'auth': return $this->lastactionstatus;
			case 'names':
				if ( count($this->sourceList['sms']) === 0 ) {
					$params = ["action" => "GETSOURCES", "data" => ["channels"=> ["sms", "viber"]]];

					$this->apiquery($params);

					$this->sourceList['sms'] = $this->response['data']['sms'] ?? [];
					$this->sourceList['viber'] = $this->response['data']['viber'] ?? [];
				}

				return $this->sourceList;
			case 'balance':
				if ( empty($this->balanceuah) ) {
					$params = ["action" => "GETBALANCE"];

					try {
						$this->apiquery($params);
						$this->balanceuah = $this->response['data']['balance']??0;
					} catch (Exception $e) {
						error_log($e->getMessage());
						return 0;
					}
				}

				return $this->balanceuah;
			case 'error':
				if ( $this->response['success'] == 1 ) return '';

				$errorCode = $this->response['error']['code']??self::DEFAULT_ERROR;
				switch ( $errorCode ) {
					case 'FORBIDDEN': $msg = "Access denied"; $this->lastactionstatus = false; break;
					case 'INSUFFICIENTFUNDS': $msg = "Insufficient funds"; break;
					case 'INVTEXT': $msg = "Empty text"; break;
					case 'INVROUTE': $msg = "Wrong destination number"; break;
					case 'INVSOURCE': $msg = "Wrong sender's name"; break;
					default: $msg = self::DEFAULT_ERROR; $this->lastactionstatus = false;
				}

				return $msg;
			default: return null;
		}
	}

	private function apiquery (array $params) {
		$params['auth'] = [
			'key' => $this->apikey,
			'appversion' => $this->appversion,
			'type' => 'flymodule'
			//'user_agent' => $_SERVER['HTTP_USER_AGENT']
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $this->baseurl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Accept: application/json"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE));
		$result = ($this->lastactionstatus) ? curl_exec($ch) : null;
		curl_close($ch);

		if ( !empty($result) && json_decode($result) ) {
			$this->response = json_decode($result, true);
		}

		if ($this->error) error_log('REQUEST: '.json_encode($params, JSON_UNESCAPED_UNICODE)."\r\nRESPONSE: ".$result);
	}

	public function sendSMS($phone, $text) {
		if ( empty($this->sourceSMS) ) {
			throw new Exception("INVSOURCE");
		}

		$params = [
			"action" => "SENDMESSAGE",
			"data" => [
				"recipient" => self::checkPhone($phone),
				"channels" => ["sms"],
				"sms" => [
					"source" => $this->sourceSMS,
					"text" => htmlspecialchars($text)
				]
			]
		];

		$this->apiquery($params);
	}

	public function sendViber($params) {
		if ( empty($this->sourceViber) ) {
			throw new Exception("Wrong sender's name");
		}

		if ( !isset( $params['text']) ) {
			throw new Exception('Empty text');
		}

		$params = [
			"action" => "SENDMESSAGE",
			"data" => [
				"recipient" => self::checkPhone($params['phone']),
				"channels" => ['viber'],
				"viber" => [
					"source" => $this->sourceViber,
					"text" => htmlspecialchars($params['text']),
					"button" => [
						"caption" => htmlspecialchars($params['btext']),
						"url" => $params['blink']
					],
					"image" => $params['image']
				]
			]
		];

		$alttext = isset($params['alttext']) ? $params['alttext'] : false;

		if ( $alttext ) {
			if ( empty($this->sourceSMS) ) {
				throw new Exception("Wrong sender's name");
			} else {
				array_push($params['data']['channels'], 'sms');
				$params['data']['sms'] = [
					"source" => $this->sourceSMS,
					"text" => htmlspecialchars($alttext)
				];
			}
		}

		$this->apiquery($params);
	}

	static function translit($text) {
		$text_arr = $arChar = preg_split('/(?<!^)(?!$)/u', $text);
		$abc =  Array(
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'д' => 'd',
			'е' => 'e',
			'ё' => 'jo',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'i',
			'й' => 'jj',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'kh',
			'ц' => 'c',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'shh',
			'ъ' => '"',
			'ы' => 'y',
			'ь' => "'",
			'э' => 'eh',
			'ю' => 'ju',
			'я' => 'ja',
			'А' => 'A',
			'Б' => 'B',
			'В' => 'V',
			'Г' => 'G',
			'Д' => 'D',
			'Е' => 'E',
			'Ё' => 'Jo',
			'Ж' => 'Zh',
			'З' => 'Z',
			'И' => 'I',
			'Й' => 'Jj',
			'К' => 'K',
			'Л' => 'L',
			'М' => 'M',
			'Н' => 'N',
			'О' => 'O',
			'П' => 'P',
			'Р' => 'R',
			'С' => 'S',
			'Т' => 'T',
			'У' => 'U',
			'Ф' => 'F',
			'Х' => 'Kh',
			'Ц' => 'C',
			'Ч' => 'Ch',
			'Ш' => 'Sh',
			'Щ' => 'Shh',
			'Ъ' => '""',
			'Ы' => 'Y',
			'Ь' => "''",
			'Э' => 'Eh',
			'Ю' => 'Ju',
			'Я' => 'Ja',
			'Є' => 'E',
			'є' => 'e',
			'і' => 'i',
			'І' => 'I',
			'ї' => 'i',
			'Ї' => 'I',
			'№' => '#'
		);
		$i = 0; $lat = '';

		while (isset($text_arr[$i])) {
			//$lat .= isset($abc[$text_arr[$i]]) ? $abc[$text_arr[$i]] : $text_arr[$i];
			$lat .= isset($abc[$text_arr[$i]]) ? $abc[$text_arr[$i]] : ((mb_ord($text_arr[$i]) > 255) ? '?' : $text_arr[$i]); // Вопросы вместо ASCII символов
			$i++;
		}

		return $lat;
	}

	static function checkPhone ($number) {
		$number = preg_replace("/\D/", '', $number);

		if (strlen($number) < 9) throw new Exception('INVROUTE');

		return $number;
	}

	static function sendToFly($source, $to, $mes) {
		try {
			self::inst()->setSources($source);
			self::inst()->sendSMS($to, $mes);
		} catch (Exception $e) {
			self::inst()->response = ['success' => 0, 'error' => ['code' => $e->getMessage()]];
		}
	}

	static function inst() {
		if (!self::$flyObj) {
			self::$flyObj = new SMSflyC(get_option('SMSFLY_apikey'));
		}

		return self::$flyObj;
	}
}