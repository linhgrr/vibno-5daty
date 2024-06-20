<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'post_id', 'name'];

    public static function create(array $array)
    {
        DB::table('comments')->insert($array);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
