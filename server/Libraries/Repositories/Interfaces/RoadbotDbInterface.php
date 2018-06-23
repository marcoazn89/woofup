<?php
namespace Roadbot\Libraries\Repositories\Interfaces;

interface RoadbotDbInterface
{
	public function getLocation(int $userId): array;

	public function setLocation(int $userId, array $coords): void;	
}