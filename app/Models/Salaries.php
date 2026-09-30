<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    protected $table = 'salary';
    protected $fillable = [
        'user_id',
        'name_month',
        'salary_month',
        'salary_remaining',
        'salary_amount',
        'date',
        'date_salary_payment',
        'fund_type',
        'created_at',
        'updated_at'
    ];
}
