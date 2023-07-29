<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Tag extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = "tags";
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'tag_cd',
        'name',
        'description',
    ];

    protected $appends = [ ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
