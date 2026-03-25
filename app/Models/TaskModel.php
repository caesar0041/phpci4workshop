<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
   // Which database table to use
   protected $table            = 'tasks';
   protected $primaryKey       = 'id';
   protected $useAutoIncrement = true;
   protected $returnType       = 'array';
   protected $useSoftDeletes   = false;
   protected $protectFields    = true;

   //  Only these fields can be mass-assigned (security!)
   protected $allowedFields    = [
      'title',
      'description',
      'status',
      'due_date',
      'user_id'
   ];

   // Dates

   //  Auto-fill created_at / updated_at fields
   protected $useTimestamps = false;
   protected $dateFormat    = 'datetime';
   protected $createdField  = 'created_at';
   protected $updatedField  = 'updated_at';
   // Validation

   //  Validate data before insert/update
   protected $validationRules      = [
      'title' => 'required|min_length[3]|max_length[255]',
      'status' => 'required|in_list[pending,in-progress,completed]',
   ];

}
