<?php
namespace Roadbot\Libraries\State;

use ChatFlow\StateRepositoryInterface;

class TextStateRepository implements StateRepositoryInterface
{
    protected $dir;

    public function __construct(string $dataDir)
    {
        $this->dir = $dataDir;
    }

    public function getStateData(int $userId): ?array
    {
        $dir = "{$this->dir}/{$userId}.json";
        $this->checkDir($dir);
        $data = file_get_contents($dir);

        if (empty($data)) {
            return null;
        }

        $data = json_decode($data, true);

        return $data['state_data'];
    }

    public function saveStateData(int $userId, array $data): void
    {
        unset($data['data']);

        $userData = $this->getUserData($userId);

        $userData['state_data'] = $data;

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

    protected function checkDir(string $dir)
    {
        if (!file_exists($dir)) {
            file_put_contents($dir, null);
        }
    }
}