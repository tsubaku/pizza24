<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    /**
     * Get image url
     *
     * @return string
     */
    public function getImageUrlPreparedAttribute()
    {
        $imgUrl = $this->image_url;
        if (empty($imgUrl)) {
            $imgUrl = 'not-available.png';
        }

        return $imgUrl;
    }
}
