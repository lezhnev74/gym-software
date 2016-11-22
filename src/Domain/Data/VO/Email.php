<?php

namespace Lezhnev74\GymSoftware\Domain\Data\VO;

use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;

class Email
{

    private $email;

    function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidData("E-mail is considered invalid");
        }

        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}