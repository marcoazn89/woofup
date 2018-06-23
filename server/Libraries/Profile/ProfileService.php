<?php
namespace Woofup\Libraries\Profile;
use Pimple\{ServiceProviderInterface, Container};

class ProfileService
{
    public $age;
    public $breed;
    public $gender;
    public $name;
    public $homeLocation;
    public $size;
    public $weight;

    public function __construct()
    {
        $this->$breed = "doggo";
        $this->$name = "Vincent";
        $this->$location = "470 Park Ave S";
        $this->weight = 100;
    }

    public function getProfileData()
    {
        //$test = ['test', 'text'];
     // return $test;
        return $this->loadFromFile();
    }

    public function setProfile($data)
    {
        //$this->saveToFile("\ntest");
        $this->saveToFile($data);
        $this->saveToFile(",\n");
    }

    public function loadFromFile()
    {
        $fileData = file_get_contents(__DIR__ . '/../Repositories/woofup-data.txt', true);
        //die(var_dump($fileData));
        return json_decode($fileData, true);
    }

    public function saveToFile($data) {
        file_put_contents(__DIR__ . '/../Repositories/woofup-data.txt', $data, FILE_APPEND);
    }
}