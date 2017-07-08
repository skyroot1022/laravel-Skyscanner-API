<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $connection = "mysql";

    protected $fillable = [
        'name', 'text', 'group_id'
    ];

    public function group()
    {
        $this->belongsTo(Group::class);
    }
}