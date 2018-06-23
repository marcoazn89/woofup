<?php
namespace Roadbot\Libraries\Facebook;

use Messenger\Objects\{Message};

class Components
{
	protected $components;

	public function __construct(array $components)
	{
		$this->components = $components;
	}

	public function get(string $key, array $data): Message
	{
		return $this->components[$key]($data);
	}
}