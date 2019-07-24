<?php

/**
 * Created by PhpStorm.
 * User: Djunehor
 * Date: 3/13/2019
 * Time: 3:47 PM
 */
class MobileNig
{
	protected $username, $password;
	private $phoneNumber, $network, $amount, $ref;

	/**
	 * @var \Exception
	 */
	public $httpError;

	/**
	 * Class Constructor
	 *
	 * @param $phoneNumber
	 * @param $network
	 * @param $amount
	 * @param $txnref
	 */
	public function __construct($phoneNumber, $network, $amount, $txnref)
	{
		$this->username = 'djunehor';
		$this->password = 'julianah';
		$this->phoneNumber = $this->numberFormat($phoneNumber);
		$this->network = $network;
		$this->amount = $amount;
		$this->ref = $txnref;
	}


	protected function numberFormat($number)
	{
		$number = (string)$number;
		$number = trim($number);
		$number = preg_replace("/\s|\+|-/", "", $number);
		return $number;
	}


	/**
	 * @param null $text
	 * @return bool
	 */
	public function send() : bool
	{

		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://mobilenig.net/api/data.php/");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
				'username' => $this->username,
				'password' => $this->password,
				'network' => $this->network,
				'phoneNumber' => $this->phoneNumber,
				'amount' => $this->amount,
				'ref' => $this->ref,
				'return_url' => $url = plugin_dir_url( 'callback.php' ),
			)));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			curl_close ($ch);

			if($server_output == 'OK') {
				return true;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}
}