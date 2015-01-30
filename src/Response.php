<?php

namespace Alexdevid;

/**
 * Description of Response
 *
 * @author alexdevid
 */
class Response
{

	const DEFAULT_CONTENT_TYPE = 'application/json';
	const DEFAULT_RESPONSE_STATUS = "Forbidden";
	const DEFAULT_RESPONSE_CODE = 403;

	public static $statuses = [
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '(Unused)',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported'
	];

	/**
	 * @var string Response status
	 */
	public $status = self::DEFAULT_RESPONSE_STATUS;

	/**
	 * @var string Response status code
	 */
	public $code = self::DEFAULT_RESPONSE_CODE;

	/**
	 * @var string Content type
	 */
	public $contentType = self::DEFAULT_CONTENT_TYPE;

	/**
	 * @var array Allowed methods
	 */
	public $allowedMethods = [
		'GET', 'POST', 'PUT', 'DELETE'
	];

	/**
	 * @var string Response body
	 */
	public $content = "";

	/**
	 *
	 */
	public function __construct()
	{

	}

	/**
	 *
	 */
	public function setHeaders()
	{
		header("HTTP/1.1 $this->code $this->status");
		header('Content-type: ' . $this->contentType);
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: ' . $this->getAllowedMethodsString());
	}

	/**
	 * Generating string from Response::allowedMethods array
	 * @return string
	 */
	public function getAllowedMethodsString()
	{
		return implode(', ', $this->allowedMethods);
	}

	/**
	 * @param string $status
	 */
	public function setStatus($status = NULL)
	{
		$this->status = ($status) ? : $this->getStatusByCode($this->code);
	}

	/**
	 * @param integer $code
	 */
	public function setCode($code = self::DEFAULT_RESPONSE_CODE)
	{
		$this->code = $code;
		$this->setStatus($this->getStatusByCode($this->code));
	}

	/**
	 * @param array $methods
	 */
	public function setAllowedMethods(array $methods)
	{
		$this->allowedMethods = $methods;
	}

	/**
	 * @param integer $code
	 * @return string
	 */
	public function getStatusByCode($code)
	{
		return self::$statuses[$code];
	}

	/**
	 *
	 */
	public function send()
	{
		$this->setHeaders();
		echo $this;
	}

	public function __toString()
	{
		return $this->content;
	}

}