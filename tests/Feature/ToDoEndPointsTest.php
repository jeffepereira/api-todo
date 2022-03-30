<?php

namespace Tests\Feature;

use App\Models\ToDo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Str;

class ToDoEndPointsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public const DEFAULT_HEADERS = [
        'accept' => 'application/json'
    ];

    public const FORMAT_RESSOURCE = [
        'id',
        'type',
        'attributes' => [
            'title',
            'description',
            'finished_at',
            'complete',
            'created_at',
            'updated_at',
        ]
    ];

    public const FORMAT_PAGINATE =  [
        "links" => [
            "first",
            "last",
            "prev",
            "next",
        ],
        "meta" => [
            "current_page",
            "from",
            "last_page",
            "links" => [
                [
                    "url",
                    "label",
                    "active",
                ]
            ],
            "path",
            "per_page",
            "to",
            "total",
        ]
    ];

    /**
     * @test
     * @group to-do
     * @group store
     */
    public function toDoEndPointStore()
    {
        $response = $this->post(
            route('api.todo.store'),
            [
                'title' => 'title',
                'description' => 'description',
            ],
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(['data' => self::FORMAT_RESSOURCE]);
    }

    /**
     * @test
     * @group to-do
     * @group store
     */
    public function toDoEndPointStoreValidation()
    {
        $initialData = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
        ];
        $dataValidation = [
            'title' => '',
            'title' => Str::random(256),
            'description' => Str::random(501)
        ];


        $response = $this->post(route('api.todo.store'), $initialData, self::DEFAULT_HEADERS);
        $response->assertStatus(Response::HTTP_CREATED);


        foreach ($dataValidation as $key => $value) {
            $response = $this->post(route('api.todo.store'), array_merge($initialData, [$key => $value]), self::DEFAULT_HEADERS);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $this->assertCount(1, $response->json('errors'));
        }
    }

    /**
     * @test
     * @group to-do
     * @group update
     */
    public function toDoEndPointUpdate()
    {
        $toDo = ToDo::factory()->create([
            'title' => 'Title before update',
            'description' => 'Description before update',
        ]);
        $this->assertEquals('Title before update',  $toDo->title);
        $this->assertEquals('Description before update',  $toDo->description);

        $response = $this->put(
            route('api.todo.update', $toDo->id),
            [
                'title' => 'Title after update',
                'description' => 'Description after update',
            ],
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $toDo->refresh();
        $this->assertEquals('Title after update', $toDo->title);
        $this->assertEquals('Description after update', $toDo->description);
    }

    /**
     * @test
     * @group to-do
     * @group update
     */
    public function toDoEndPointUpdateWithValidation()
    {

        $initialData = [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
        ];
        $dataValidation = [
            'title' => '',
            'title' => Str::random(256),
            'description' => Str::random(501)
        ];


        $toDo = ToDo::factory()->create([
            'title' => 'Title before update',
            'description' => 'Description before update',
        ]);
        $this->assertEquals('Title before update',  $toDo->title);
        $this->assertEquals('Description before update',  $toDo->description);

        $response = $this->put(
            route('api.todo.update', $toDo->id),
            [
                'title' => 'Title after update',
                'description' => 'Description after update',
            ],
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $toDo->refresh();
        $this->assertEquals('Title after update', $toDo->title);
        $this->assertEquals('Description after update', $toDo->description);

        foreach ($dataValidation as $key => $value) {
            $response = $this->put(
                route('api.todo.update', $toDo->id),
                array_merge($initialData, [$key => $value]),
                self::DEFAULT_HEADERS
            );
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $this->assertCount(1, $response->json('errors'));
        }
    }

    /**
     * @test
     * @group to-do
     * @group complete
     */
    public function toDoEndPointComplete()
    {
        $toDo = ToDo::factory()->notCompleted()->create();
        $this->assertNull($toDo->finished_at);

        $response = $this->put(
            route('api.todo.complete', $toDo->id),
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $toDo->refresh();
        $this->assertNotNull($toDo->finished_at);
    }

    /**
     * @test
     * @group to-do
     * @group index
     */
    public function toDoEndPointIndex()
    {
        $numberOfToDos = rand(10, 30);
        $toDos = ToDo::factory($numberOfToDos)->create();

        $response = $this->get(
            route('api.todo.index'),
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => [self::FORMAT_RESSOURCE]]);
        $response->assertJsonCount($numberOfToDos, 'data');
        $this->assertEquals($toDos->first()->title, $response->json('data.0.attributes.title'));
    }

    /**
     * @test
     * @group to-do
     * @group index
     * @group index-paginate
     */
    public function toDoEndPointIndexWithPaginate()
    {
        $toDos = ToDo::factory(200)->create();

        $response = $this->get(
            route('api.todo.index') . "?paginate=10",
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(
            array_merge(
                ['data' => [self::FORMAT_RESSOURCE]],
                self::FORMAT_PAGINATE
            )
        );
        $response->assertJsonCount(10, 'data');
        $this->assertEquals($toDos->first()->title, $response->json('data.0.attributes.title'));
    }

    /**
     * @test
     * @group to-do
     * @group show
     */
    public function toDoEndPointShow()
    {
        $toDo = ToDo::factory()->create();
        $response = $this->get(
            route('api.todo.show', $toDo->id),
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => self::FORMAT_RESSOURCE]);
        $this->assertEquals($toDo->title, $response->json('data.attributes.title'));
    }

    /**
     * @test
     * @group to-do
     * @group delete
     */
    public function toDoEndPointDelete()
    {
        $toDo = ToDo::factory()->create();
        $response = $this->delete(
            route('api.todo.destroy', $toDo->id),
            self::DEFAULT_HEADERS
        );
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(ToDo::find($toDo->id));
    }
}
