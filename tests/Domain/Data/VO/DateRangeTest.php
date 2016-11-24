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

    function test_range_intersection_detected()
    {
        $range1 = new DateRange(
            new Date(Carbon::now()->subWeek()),
            new Date(Carbon::now())
        );
        $range2 = new DateRange(
            new Date(Carbon::now()->subDay()),
            new Date(Carbon::now()->addDay())
        );
        $range3 = new DateRange(
            new Date(Carbon::now()),
            new Date(Carbon::now()->addWeek())
        );
        $range4 = new DateRange(
            new Date(Carbon::now()->subYear()),
            new Date(Carbon::now()->subMonth())
        );
        $range5 = new DateRange(
            new Date(Carbon::now()->addDay()),
            new Date(Carbon::now()->addMonth())
        );

        $this->assertTrue($range1->isIntersectsWith($range2));
        $this->assertTrue($range1->isIntersectsWith($range3));
        $this->assertFalse($range1->isIntersectsWith($range4));
        $this->assertFalse($range1->isIntersectsWith($range5));

    }
}
