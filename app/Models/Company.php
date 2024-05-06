<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Company;

class Company extends Model
{
    protected $fillable = ['name', 'email', 'logo', 'website'];
    use HasFactory;

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
