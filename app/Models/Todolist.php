<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;

    protected  $table = "_to_do_list_test";

    protected $fillable = [

        'userid',
        'title',
        'description',
        'status',
    ];
}
