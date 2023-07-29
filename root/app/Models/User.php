<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserEnums;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'email',
        'password',
        'name',
        'gender',
        'birthday',
        'address',
        'avatar',
        'note',
        'department_id',
        'remember_token',
        'status',
        'reason',
        'is_first'
    ];

    protected $appends = [
        'gender_name',
        'department_name',
        'status_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'tokens',
        'password',
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
        'birthday' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Hàm so sánh lấy giới tính
    public function getGenderNameAttribute($value)
    {
        return UserEnums::getGenderName($this->gender);
    }

    // Hàm so sánh lấy bộ phận người dùng
    public function getDepartmentNameAttribute($value)
    {
        return UserEnums::getDepartmentName($this->department_id);
    }

    // Hàm so sánh lấy trạng thái tài khoản người dùng
    public function getStatusNameAttribute($value)
    {
        return UserEnums::getStatusName($this->status);
    }
    public function borrow()
    {
        return $this->hasMany(Borrower::class);
    }

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'user_book',
            'user_id',
            'book_id');
    }

    public function user_book()
    {
        return $this->hasMany(UserBook::class);
    }
}