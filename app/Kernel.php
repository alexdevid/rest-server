<?php

use Components\Rest;
use Symfony\Component\Yaml\Yaml;
use ActiveRecord\Config as DbConfig;

/**
 * @author Alexander Devid <kerdevid@gmail.com>
 * @since 1.0
 */
class Kernel
{

	/**
	 * @var stdObject config params derivered from config.yml file
	 */
	public $config = null;

	public $request;

	/**
	 * @var Kernel application instance
	 */
	public static $app = null;

	/**
	 * @inheritdoc
	 */
	public function __construct()
	{

		//$this->router = new Router;
		Kernel::$app = $this;

		$this->parseConfig()
				->initConnection();

		new Rest($this->config->rest);

		if(!$this->request) {
			$this->end();
		}
	}

	/**
	 * Parse config from config.yml file
	 * After this config can be accesible via $this->config
	 * @return \App\Kernel
	 */
	private function parseConfig()
	{
		$configFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config/config.yml';
		$config = Yaml::parse(file_get_contents($configFile), true, true);
		$this->config = json_decode(json_encode($config));
		return $this;
	}

	/**
	 * @return \App\Kernel
	 */
	private function initConnection()
	{
		DbConfig::initialize(function($cfg) {
			$cfg->set_model_directory(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Models');
			$cfg->set_connections([
				'development' => 'mysql://' . $this->config->db->username . ':' .  $this->config->db->password . '@' . $this->config->db->host . '/' . $this->config->db->name . '?charset=utf8',
				'production' => 'mysql://' . $this->config->db->username . ':'  .  $this->config->db->password . '@' . $this->config->db->host . '/' . $this->config->db->name . '?charset=utf8',
			]);
		});
		return $this;
	}

	/**
	 *
	 * @return type
	 */
	public function end()
	{
		return die();
	}

}