<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'fk_kelas', 'id');
    }

    public function teacher(){
        return $this->belongsTo("App\Models\Teachers", 'fk_teachers', 'id');
    }
}
