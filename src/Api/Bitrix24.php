<?php

namespace PascalLieverse\Bitrix24\Api;

use PascalLieverse\Bitrix24\Exceptions\Bitrix24Exception;

class Bitrix24
{
	/**
	 * @var string Bitrix24 webhook url
	 */
	private $webhookUrl;

	/**
	 * @var string Bot CLIENT_ID
	 */
	private $botClientId;

	/**
	 * @var string System message
	 */
	private $systemMessage;

	/**
	 * @var string Url preview
	 */
	private $urlPreview;

	/**
	 * Bitrix24 constructor.
	 *
	 * @throws Bitrix24Exception
	 */
	public function __construct()
	{
		$this->webhookUrl = config('bitrix24.webhook_url');

		if (empty($this->webhookUrl)) {
			throw new Bitrix24Exception('Config error: Not found webhook_url in config/bitrix24');
		}

		$this->botClientId = config('bitrix24.bot_client_id');

		if (empty($this->botClientId)) {
			throw new Bitrix24Exception('Config error: Not found bot_client_id in config/bitrix24');
		}

		$this->systemMessage = config('bitrix24.system_message');

		if (empty($this->systemMessage)) {
			throw new Bitrix24Exception('Config error: Not found system_message in config/bitrix24');
		}

		$this->urlPreview = config('bitrix24.url_preview');

		if (empty($this->urlPreview)) {
			throw new Bitrix24Exception('Config error: Not found url_preview in config/bitrix24');
		}
	}

	/**
	 * Send a chatbot message
	 *
	 * @param array $params
	 * @return mixed
	 * @throws Bitrix24Exception
	 */
	public function sendMessage(array $params)
	{
		$params['SYSTEM'] = $this->systemMessage;
		$params['URL_PREVIEW'] = $this->urlPreview;
		$this->sendRequest($params, 'imbot.message.add.json');
	}

	/**
	 * Setup the bitrix24 api
	 *
	 * @param array $params
	 * @param string $api
	 * @return mixed
	 * @throws Bitrix24Exception
	 */
	private function sendRequest($params, $api){
		$headers = [
			"Accept-Language: en",
			"Content-Type: application/json; charset=utf-8"
		];

		$params['CLIENT_ID'] = $this->botClientId;

		$body = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


		$streamOptions = stream_context_create([
			'http' => [
				'method' => 'POST',
				'header' => $headers,
				'content' => $body
			],
		]);

		try {
			$result = file_get_contents($this->webhookUrl . '/' . $api, 0, $streamOptions);

			return $result;

		} catch (\Exception $e) {

			throw new Bitrix24Exception($e->getMessage());
		}
	}
}
