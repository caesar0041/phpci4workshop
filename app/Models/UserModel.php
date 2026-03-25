<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
      'name', 'email', 'password'
    ];

protected $beforeInsert = ['hashPassword'];
   protected $beforeUpdate = ['hashPassword'];
   protected function hashPassword(array $data): array
   {
      if (isset($data['data']['password'])) {
         $data['data']['password'] = password_hash(
            $data['data']['password'],
            PASSWORD_DEFAULT
         );
      }
      return $data;
   }


   // Dates
   protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
}
