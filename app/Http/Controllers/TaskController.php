<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Repositories\TaskRepository;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * TaskController constructor.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->middleware('auth');
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->id();

        $tasks = $this->taskRepository->getByUserId($user_id);

        return response()->json([
            'tasks' => $tasks
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Add new task
     *
     * @param TaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request)
    {
        $request_data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id()
        ];

        $task = $this->taskRepository->create($request_data);

        return response()->json([
            'task' => $task,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, $id)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description
        ];

        $this->taskRepository->update($id, $data);

        return response()->json([
            'message' => 'Task updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->taskRepository->delete($id);

        return response()->json([
            'message' => 'Deleted task successfully'
        ], 200);
    }
}
