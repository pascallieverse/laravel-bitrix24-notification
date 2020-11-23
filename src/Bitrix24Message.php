<?php


namespace PascalLieverse\Bitrix24;


class Bitrix24Message
{
	public $message;

	/**
	 *
	 *
	 * @param string $message
	 * @return $this
	 */
	public function text(string $message)
	{
		$this->message = $message;

		return $this;
	}
}