<?php

namespace PascalLieverse\Bitrix24\Tests;

use PascalLieverse\Bitrix24\Api\Bitrix24;
use PascalLieverse\Bitrix24\Bitrix24Channel;
use PascalLieverse\Bitrix24\Bitrix24Message;
use Mockery;
use PHPUnit\Framework\TestCase;
use Illuminate\Notifications\Notification;

class ChannelTest extends TestCase
{
	protected $bitrix24;

	protected $channel;

	public function setUp(): void
	{
		parent::setUp();

		$this->bitrix24 = Mockery::mock(Bitrix24::class);

		$this->channel = new Bitrix24Channel($this->bitrix24);
	}

	/** @test */
	public function it_can_send_a_notification()
	{
		self::expectNotToPerformAssertions();

		$this->bitrix24->shouldReceive('sendMessage')->with([
			'DIALOG_ID' => 1,
			'MESSAGE' => 'message'
		])->once();

		$this->channel->send('1', new TestNotification());


	}
}


class TestNotification extends Notification
{
	public function toBitrix24($notifiable)
	{
		return (new Bitrix24Message())
			->text('message');
	}
}