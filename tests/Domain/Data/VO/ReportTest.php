<?php
namespace tests\Domain\Data\VO;

use Carbon\Carbon;
use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;
use Lezhnev74\GymSoftware\Domain\Data\Room\Room;
use Lezhnev74\GymSoftware\Domain\Data\VO\Client;
use Lezhnev74\GymSoftware\Domain\Data\VO\Date;
use Lezhnev74\GymSoftware\Domain\Data\VO\DateRange;
use Lezhnev74\GymSoftware\Domain\Data\VO\Report;
use Lezhnev74\GymSoftware\Domain\Data\VO\TrainingSession;

class ReportTest extends \PHPUnit_Framework_TestCase
{

    private function seedRooms()
    {
        $client1 = new Client("Alan", "Smith", "12345678901");
        $client2 = new Client("Chris", "Tucker", "23456789012");
        $client3 = new Client("Jane", "Taylor", "34567890123");

        $sessions = [];
        $sessions[] = new TrainingSession($client1, new DateRange(
            new Date(Carbon::parse("01.02.2016 13:00")),
            new Date(Carbon::parse("01.02.2016 14:00"))
        ));
        $sessions[] = new TrainingSession($client1, new DateRange(
            new Date(Carbon::parse("10.02.2016 09:00")),
            new Date(Carbon::parse("10.02.2016 10:30"))
        ));
        $sessions[] = new TrainingSession($client2, new DateRange(
            new Date(Carbon::parse("02.03.2016 06:00")),
            new Date(Carbon::parse("02.03.2016 07:00"))
        ));
        $sessions[] = new TrainingSession($client3, new DateRange(
            new Date(Carbon::parse("12.02.2016 14:30")),
            new Date(Carbon::parse("12.02.2016 15:00"))
        ));

        $room1 = new Room("ID", "Room 1", 1);
        $room1->conductTrainingSession($sessions[0]);
        $room1->conductTrainingSession($sessions[3]);

        $room2 = new Room("ID", "Room 2", 1);
        $room2->conductTrainingSession($sessions[1]);

        $room3 = new Room("ID", "Room 3", 1);
        $room3->conductTrainingSession($sessions[2]);

        return [$room1, $room2, $room3];

    }

    function test_report_returns_total_sessions()
    {
        $rooms = $this->seedRooms();

        $report = new Report(
            new DateRange(new Date(Carbon::parse("01.02.2016 00:00:00")),
                new Date(Carbon::parse("01.02.2016 00:00:00")->endOfMonth())),
            $rooms
        );

        $this->assertEquals(3, count($report->getTotalSessions()));
    }


}
