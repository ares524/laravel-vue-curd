<?php
/**
 * Created by PhpStorm.
 * User: oleg-m
 * Date: 27.10.17
 * Time: 17:34
 */

namespace App\Repositories;


use App\Task;

class TaskRepository implements BaseRepository
{
    /**
     * @var Task
     */
    private $model;

    /**
     * TaskRepository constructor.
     *
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Get all tasks
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Get task by id
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Create new task
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update task by id
     *
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    /**
     * Destroy task by id
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Get tasks by user id
     *
     * @param $user_id
     * @return mixed
     */
    public function getByUserId($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }
}