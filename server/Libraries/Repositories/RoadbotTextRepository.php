<?php
namespace Roadbot\Libraries\Repositories;

//use Interfaces\RoadbotDbInterface;

class RoadbotTextRepository
{
	protected $dir;

	public function __construct(string $dir)
	{
		$this->dir = $dir;
	}

	public function get(int $userId, string $key): ?array
	{
		$data = $this->getUserData($userId);

        return $data[$key] ?? null;
	}

	public function set(int $userId, string $key, array $data): void
	{
		$userData = $this->getUserData($userId);

		$userData[$key] = $data;

		file_put_contents("{$this->dir}/{$userId}.json", json_encode($userData));
	}

	public function getUserData(int $userId): ?array
	{
		$data = file_get_contents("{$this->dir}/{$userId}.json");

		if (empty($data)) {
            return null;
        }

        $data = json_decode($data, true);

        return $data;
	}
}