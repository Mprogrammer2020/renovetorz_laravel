<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Workspace;
use App\Models\OpenAIGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkspaceGroupType extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'workspace_group_types';

    protected $fillable = ['workspace_id', 'workspace_temp_type', 'workspace_item'];


    public function workspaces(){
        return $this->belongsTo(Workspace::class,'workspace_id');
    }
}
