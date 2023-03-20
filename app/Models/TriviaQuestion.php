<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriviaQuestion extends Model
{
    use HasFactory;

    // public function setCategoryAttribute($value)
    // {
    //     $value = str_replace('/', ' ', $value); // replace slashes with spaces
    //     $value = str_replace('%', ' ', $value); // replace percentage signs with spaces
    //     $value = trim(preg_replace('/\s+/', ' ', $value)); // remove extra spaces and trim

    //     $this->attributes['category'] = $value;
    // }
}
