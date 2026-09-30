<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySaving extends Model
{
    protected $table = 'salary_saving';

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
}
