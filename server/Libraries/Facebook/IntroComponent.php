<?php
namespace Roadbot\Libraries\Facebook;

use Messenger\Objects\{Message, Text};

class IntroComponent extends ComponentHelper  implements FbComponent
{
	public function __invoke(array $data): Message
	{
		$msg = $this->getMessage($data['user_id']);

		$quickReplies = [];
		array_push($quickReplies, 
			$this->getTextQuickreply("Park", "park_tut"),
			$this->getTextQuickreply("Info", "info_tut"),
			$this->getTextQuickreply("Report Sign", "report_tut"),
			$this->getTextQuickreply("My Car", "my_car_tut"),
			$this->getTextQuickreply("Skip Intro", "skip_intro")
		);

		$msg->setText(new Text($data['message'], $quickReplies));

		return $msg;
	}
}