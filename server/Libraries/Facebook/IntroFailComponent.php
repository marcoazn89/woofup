<?php
namespace Roadbot\Libraries\Facebook;

class IntroFailComponent extends ComponentHelper implements FbComponent
{
	public function get(array $data): Message
	{
		$msg = $this->getMessage($data['user_id']);

		$message = $data['input'];
		$msgType = $input->getType();

		if ($msgType === Message::TYPE_TEXT) {
			$text = $message->getReceivedText();
			$input = $text->getQuickReply() ?? $text->getText();
		}

		if ($input === 'skip_intro') {
			$msg->setText(new Text("No Problem"));
			$api->sendMessage($msg);

			$msg->setText(new Text('If you want to check the intro again just say "intro"'));
			$api->sendMessage($msg);
		} else {
			$msg->setText(new Text("I was only configured to understand parking...but I'm happy to repeat that intro anytime! Just say \"intro\"");
			$api->sendMessage($msg);
		}
	}
}