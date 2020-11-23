<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Chat bot
	|--------------------------------------------------------------------------
	|
	| The webhook url given by Bitrix24 to call the rest api
	|
	*/
	'webhook_url' => env('BITRIX_WEBHOOK_URL', 'http://example.bitrix24.com/rest/secret/code'),

	/*
	| Bot client id
	|
	 */
	'bot_client_id' => env('BITRIX_BOT_CLIENT_ID', ''),

	/*
	| System message, defined with 'Y' or 'N'
	|
	 */
	'system_message' => 'N',

	/*
	| Url preview, defined with 'Y' or 'N'
	|
	 */
	'url_preview' => 'N'

];