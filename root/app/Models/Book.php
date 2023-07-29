<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Borrower;

class Book extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'books';

    protected $fillable = [
        'book_cd',
        'name',
        'quantity',
        'author',
        'slug',
        'image',
        'description'
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

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_book', 'book_id', 'category_id')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function borrowers()
    {
        return $this->hasMany(Borrower::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_book',
            'book_id',
            'user_id',
        )->withTimestamps();
    }
    public function reflections()
    {
        return $this->hasMany(Reflection::class);
    }
}
