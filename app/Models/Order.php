<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'total',
        'currency',
        'name',
        'email',
        'phone',
        'address'
    ];


    /**
     * Converts a digital status code to a string.
     * (Accessor)
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 0:
                $status = "In processing";
                break;
            case 1:
                $status = "Delivered";
                break;
            default:
                $status = "Unknown";
                break;
        }

        return $status;
    }
}
