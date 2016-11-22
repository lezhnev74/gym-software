<?php
namespace tests\Domain\Data\VO;

use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;
use Lezhnev74\GymSoftware\Domain\Data\VO\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    function wrong_input()
    {
        return [
            ['', '', ''],
            ['Dmitriy', '', ''],
            ['', 'Lezhnev', ''],
            ['Dmitriy', 'Lezhnev', '+7 (922) 23-74-557'],
            ['Dmitriy', 'Lezhnev', '7'],
        ];
    }

    function valid_input()
    {
        return [
            ['A', 'B', ''],
            ['Dmitriy', 'Lezhnev', ''],
            ['Dmitriy', 'Lezhnev', '79222364557'],
        ];
    }

    /**
     * @dataProvider wrong_input
     */
    function test_client_raises_exception_on_wrong_input($first_name, $last_name, $phone)
    {
        $this->expectException(InvalidData::class);
        new Client($first_name, $last_name, $phone);
    }

    /**
     * @dataProvider valid_input
     */
    function test_client_accepts_good_input($first_name, $last_name, $phone)
    {
        $vo = new Client($first_name, $last_name, $phone);
        $this->assertEquals($first_name, $vo->getFirstName());
        $this->assertEquals($last_name, $vo->getLastName());
        $this->assertEquals($phone, $vo->getPhone());
    }

}
