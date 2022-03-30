<?php

namespace Tests\Unit;

use App\Models\ToDo;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToDoTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     * @group unit
     * @group todo
     */
    public function checkAppendsComplete()
    {
        $toDo = ToDo::factory()->notCompleted()->make();
        $this->assertFalse($toDo->complete);
        $toDo->finished_at = $this->faker->dateTimeBetween('-1 year', 'now');
        $this->assertTrue($toDo->complete);
        $toDo->finished_at = null;
        $this->assertFalse($toDo->complete);
    }
}
