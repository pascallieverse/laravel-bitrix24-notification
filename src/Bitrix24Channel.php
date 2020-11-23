<?php

namespace PascalLieverse\Bitrix24;

use PascalLieverse\Bitrix24\api\Bitrix24;
use PascalLieverse\Bitrix24\Exceptions\Bitrix24Exception;
use Illuminate\Notifications\Notification;

class Bitrix24Channel
{
	/**
	 * @var Bitrix24
	 */
	protected $bitrix24;

	/**
	 * Bitrix24Channel constructor.
	 * @param Bitrix24 $bitrix24
	 */
	public function __construct(Bitrix24 $bitrix24)
	{
		$this->bitrix24 = $bitrix24;
	}

	/**
	 * Send the given notification.
	 *
	 * @param  mixed  $notifiable
	 * @param  \Illuminate\Notifications\Notification  $notification
	 * @return void
	 * @throws
	 */
	public function send($notifiable, Notification $notification)
	{
		$message = $notification->toBitrix24($notifiable);

		if (is_object($notifiable)) {
			$notifiable = $notifiable->routeNotificationFor('bitrix24');
		}

		if (empty($notifiable)) {
			throw new Bitrix24Exception('Сhat id was not transferred');
		}

		$params = [
			'DIALOG_ID' => $notifiable,
			'MESSAGE' => $message->message
		];

		$this->bitrix24->sendMessage($params);
	}
}