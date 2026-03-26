<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TaskModel;

class TaskApiController extends ResourceController
{
   protected $modelName = TaskModel::class;
   protected $format = 'json ';
   public function index()
   {
      // return $this->respond($this->model->findAll());

      $status = $this->request->getGet('status');
      $userId = session('user_id');

      $builder = $this->model->where('user_id', $userId);

      if ($status && $status !== 'all') {
         $builder->where('status', $status);
      }

      $tasks = $builder->findAll();

      $events = array_map(function ($task) {
         return [
            'id' => $task['id'],
            'title' => $task['title'],
            'start' => $task['due_date'] ?? date('Y-m-d'),
            'end' => $task['due_date'] ?? null,
            'extendedProps' => [
               'status' => $task['status'],
               'description' => $task['description']
            ]
         ];
      }, $tasks);

      return $this->respond($events);
   }

   public function show($id = null)
   {
      $task = $this->model->find($id);
      return $task ? $this->respond($task) : $this->failNotFound('Task not found!');
   }

   public function create($id = null){
      $data = $this->request->getJSON(true);
      if (! $this->model->insert($data))
         return $this->failValidationErrors($this->model->errors());
      $data['id'] = $this->model->getInsertID();
      return $this->respondCreated($data, 'Task created.');
   }
   public function update($id = null) {
      $data = $this->request->getJSON(true);
      if (! $this->model->find($id)) return $this->failNotFound('Task not found.');
      $this->model->update($id, $data);
      return $this->respond(['id' => $id, 'message' => 'Task updated.']);
   }
   public function delete($id = null) {
      if (! $this->model->find($id)) return $this->failNotFound('Task not found.');
      $this->model->delete($id);
      return $this->respondDeleted(['id' => $id, 'message' => 'Task deleted.']);
   }
}
