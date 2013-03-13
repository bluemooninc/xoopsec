<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bluemooninc
 * Date: 2013/03/07
 * Time: 10:34
 * To change this template use File | Settings | File Templates.
 */
if (!function_exists('curl_init')) {
	throw new Exception('Controller_JsonApi needs the CURL PHP extension.');
}
class Model_cURL
{
	protected $ch;
	protected $result;
	protected $fp;

	function __construct(){
		$this->result = array(
			'header' => '',
			'body' => '',
			'curl_error' => '',
			'http_code' => '',
			'last_url' => ''
		);
		$this->fp = null;
	}
	/**
	 * get Instance
	 * @param none
	 * @return object Instance
	 */
	public function &forge()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new Model_cURL();
		}
		return $instance;
	}
	private function _setUrl($targetUrl)
	{
		$this->ch = curl_init();
		$agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		curl_setopt($this->ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($this->ch, CURLOPT_URL,$targetUrl);
		curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
		curl_setopt($this->ch, CURLOPT_HEADER,0);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_FILE, $this->fp);
	}
	/**
	 * Make curl request
	 *
	 * @return array  'header','body','curl_error','http_code','last_url'
	 */
	public function &execute($targetUrl, $writeToFile=true)
	{
		$this->_setUrl($targetUrl);
		$response = @curl_exec($this->ch);
		$error = curl_error($this->ch);
		if ( $error!="" ) {
//			echo PHP_EOL . "cURL error number:" .curl_errno($this->ch);
//			echo PHP_EOL . "cURL error:" . curl_error($this->ch);
			$this->result['curl_error'] = $error;
			return $this->result;
		}
		$header_size = curl_getinfo($this->ch,CURLINFO_HEADER_SIZE);
		$this->result['header'] = substr($response, 0, $header_size);
		$this->result['body'] = substr( $response, $header_size );
		$this->result['http_code'] = curl_getinfo( $this->ch, CURLINFO_HTTP_CODE);
		$this->result['last_url'] = curl_getinfo( $this->ch, CURLINFO_EFFECTIVE_URL);
		curl_close($this->ch);
		return $response;
	}
}
