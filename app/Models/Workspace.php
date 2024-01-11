<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkspaceGroupType;

class Workspace extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'user_id', 'name_space'];

    public function workspaceGroupType()
    {
        return $this->hasMany(WorkspaceGroupType::class);
    }
}
