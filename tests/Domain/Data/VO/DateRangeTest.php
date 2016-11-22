<?php
namespace tests\Domain\Data\VO;

use Carbon\Carbon;
use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;
use Lezhnev74\GymSoftware\Domain\Data\VO\Client;
use Lezhnev74\GymSoftware\Domain\Data\VO\Date;
use Lezhnev74\GymSoftware\Domain\Data\VO\DateRange;

class DateRangeTest extends \PHPUnit_Framework_TestCase
{

    function invalid_input()
    {
        return [
            [new Date(Carbon::now()->addDay()), new Date(Carbon::now())],
            [new Date(Carbon::now()), new Date(Carbon::now())]
        ];
    }


    /**
     * @dataProvider invalid_input
     */
    function test_range_raises_exception_on_invalid_input($start_date, $end_date)
    {
        $this->expectException(InvalidData::class);
        new DateRange($start_date, $end_date);
    }

    function test_range_works_as_expected()
    {
        $begin_date = new Date(Carbon::now());
        $end_date = new Date(Carbon::now()->addWeek());
        $in_range_date = new Date(Carbon::now()->addDay());
        $not_in_range_date = new Date(Carbon::now()->addYear());

        $vo = new DateRange($begin_date, $end_date);
        $this->assertTrue($vo->isInRange($in_range_date));
        $this->assertFalse($vo->isInRange($not_in_range_date));

    }
}
