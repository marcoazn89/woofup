<?php
namespace Roadbot\Libraries\Facebook;

use Messenger\Objects\{Message, Text};

class TextComponent extends ComponentHelper implements FbComponent
{
	public function __invoke(array $data): Message
	{
		$msg = $this->getMessage($data['user_id']);

		$msg->setText(new Text($data['message']));

		return $msg;
	}
}