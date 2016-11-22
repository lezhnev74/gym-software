<?php
namespace tests\Domain\Data\VO;


use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;
use Lezhnev74\GymSoftware\Domain\Data\VO\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{

    function test_email_raise_exception_on_wrong_input()
    {

        $this->expectException(InvalidData::class);
        $email = "not@@email";
        new Email($email);


    }

    function test_email_allows_valid_emails()
    {

        $email = "good@email.com";
        $vo = new Email($email);
        $this->assertEquals($email, $vo->getEmail());

    }

}
