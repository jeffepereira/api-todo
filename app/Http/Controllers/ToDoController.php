<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoRequest;
use App\Http\Resources\ToDoCollection;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToDoController extends Controller
{
    public function index(Request $request): ToDoCollection
    {
        $toDos = $request->paginate ? ToDo::paginate($request->paginate) : ToDo::all();
        return new ToDoCollection($toDos);
    }

    public function store(ToDoRequest $request): JsonResponse
    {
        $toDo = ToDo::create($request->all());
        return (new ToDoResource($toDo))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ToDo $toDo): ToDoResource
    {
        return new ToDoResource($toDo);
    }

    public function update(ToDoRequest $request, ToDo $toDo): Response
    {
        $toDo->update($request->all());
        return response()->noContent();
    }

    public function destroy(ToDo $toDo): Response
    {
        $toDo->delete();
        return response()->noContent();
    }

    public function complete(ToDo $toDo): Response
    {
        $toDo->finished_at = now();
        $toDo->save();
        return response()->noContent();
    }
}
