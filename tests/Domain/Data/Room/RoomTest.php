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
}
