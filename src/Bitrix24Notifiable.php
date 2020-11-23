<?php

namespace PascalLieverse\Bitrix24;

use Illuminate\Notifications\Notifiable;

class Bitrix24Notifiable
{
	use Notifiable;

	protected $channel;

	public function __construct($channel)
	{
		$this->channel = $channel;
	}

	public function routeNotificationForBitrix24(): string
	{
		return $this->channel;
	}

}