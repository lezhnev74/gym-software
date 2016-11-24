<?php
namespace tests\Domain\Data\Room;

use Carbon\Carbon;
use Lezhnev74\GymSoftware\Domain\Data\Room\Exception\RoomIsOvercrowded;
use Lezhnev74\GymSoftware\Domain\Data\Room\Room;
use Lezhnev74\GymSoftware\Domain\Data\VO\Client;
use Lezhnev74\GymSoftware\Domain\Data\VO\Date;
use Lezhnev74\GymSoftware\Domain\Data\VO\DateRange;
use Lezhnev74\GymSoftware\Domain\Data\VO\TrainingSession;

class RoomTest extends \PHPUnit_Framework_TestCase
{
    function test_room_is_protected_from_being_overcrowded()
    {
        // Room won't allow more training sessions than it was designed for
        $this->expectException(RoomIsOvercrowded::class);

        // Prepare data
        $client = new Client("Alan", "Crugger", "19234567889");

        $training_session_1 = new TrainingSession(
            $client,
            new DateRange(new Date(Carbon::now()), new Date(Carbon::now()->addHour()))
        );
        $training_session_2 = new TrainingSession(
            $client,
            new DateRange(new Date(Carbon::now()->subHour()), new Date(Carbon::now()))
        );

        // Conduct trainings in the room
        $room = new Room("ID", "Room A", 1, []);
        $room->conductTrainingSession($training_session_1);
        $room->conductTrainingSession($training_session_2);

    }

    function test_room_is_protected_from_being_overcrowded_via_constructor()
    {
        // Room won't allow more training sessions than it was designed for
        $this->expectException(RoomIsOvercrowded::class);

        // Prepare data
        $client = new Client("Alan", "Crugger", "19234567889");

        $training_session_1 = new TrainingSession(
            $client,
            new DateRange(new Date(Carbon::now()), new Date(Carbon::now()->addHour()))
        );
        $training_session_2 = new TrainingSession(
            $client,
            new DateRange(new Date(Carbon::now()->subHour()), new Date(Carbon::now()))
        );

        // Conduct trainings in the room
        $room = new Room("ID", "Room A", 1, [
            $training_session_1,
            $training_session_2
        ]);


    }

    function test_room_calculates_performance_well()
    {
        // Prepare data
        $client1 = new Client("Alan", "Crugger", "19234567889");
        $client2 = new Client("Hugo", "Stiglitz", "19232322444");

        $training_session_1 = new TrainingSession(
            $client1,
            new DateRange(
                new Date(Carbon::parse("01.01.2016 06:00")),
                new Date(Carbon::parse("01.01.2016 07:30"))
            )
        );
        $training_session_2 = new TrainingSession(
            $client1,
            new DateRange(
                new Date(Carbon::parse("01.01.2016 18:00")),
                new Date(Carbon::parse("01.01.2016 19:20"))
            )
        );
        $training_session_3 = new TrainingSession(
            $client2,
            new DateRange(
                new Date(Carbon::parse("01.01.2016 12:00")),
                new Date(Carbon::parse("01.01.2016 14:00"))
            )
        );


        // Conduct trainings in the room
        $room = new Room("ID", "Room A", 1, [
            $training_session_1,
            $training_session_2,
            $training_session_3
        ]);

        $this->assertEquals(0.6, $room->calculatePerformanceForDate(
            new DateRange(
                new Date(Carbon::parse("01.01.2016 00:00:00")),
                new Date(Carbon::parse("01.01.2016 00:00:00")->endOfDay())
            )
        ));
    }
}
