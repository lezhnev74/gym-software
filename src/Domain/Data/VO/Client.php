<?php
namespace Lezhnev74\GymSoftware\Domain\Data\VO;

use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;

class Client
{
    private $first_name;
    private $last_name;
    private $phone;

    function __construct(string $first_name, string $last_name, string $phone)
    {
        if (!strlen($first_name)) {
            throw new InvalidData("First name must not be empty");
        }
        if (!strlen($last_name)) {
            throw new InvalidData("Last name must not be empty");
        }

        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;

    }

    function getFullName()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    function getFirstName()
    {
        return $this->first_name;
    }

    function getLastName()
    {
        return $this->getLastName();
    }

    function getPhone()
    {
        return $this->phone;
    }
}