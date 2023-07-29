<?php

namespace App\Models;

use App\Enums\BorrowerEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrower extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'borrowers';

    protected $fillable = [
        'user_id',
        'book_id',
        'from_date',
        'to_date',
        'extended_date',
        'quantity',
        'status',
        'allowed_renewal',
        'note',
        'auto_renew',
    ];

    protected $appends = [
        'status_name',
    ];

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
        'from_date' => 'datetime',
        'to_date' => 'datetime',
        'extended_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_book',
            'book_id',
            'category_id'
        );
    }

    public function getStatusNameAttribute($value)
    {
        return BorrowerEnums::getStatusName($this->status);
    }

    public function borrow()
    {
	    return $this->hasMany(Borrower::class);
	}
}
