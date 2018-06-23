<?php
namespace Roadbot\Libraries\Facebook;

use Messenger\Objects\{Message};

interface FbComponent
{
	public function __invoke(array $data): Message;
}