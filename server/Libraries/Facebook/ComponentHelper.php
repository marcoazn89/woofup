<?php
namespace Roadbot\Libraries\Facebook;

use Messenger\Objects\{Message, Recipient, QuickReply};

class ComponentHelper
{
	public function getMessage(string $userId): Message
	{
		$recipient = new Recipient();
		$recipient->setId($userId);

		$msg = new Message();
		$msg->setRecipient($recipient);

		return $msg;
	}

	public function getTextQuickreply(string $title, string $payload): QuickReply
	{
		$qr = new QuickReply(QuickReply::TEXT);
		$qr->setTitle($title);
		$qr->setPayload($payload);

		return $qr;
	}
}