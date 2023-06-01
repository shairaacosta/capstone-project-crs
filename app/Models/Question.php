<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function answers(){
       return $this->hasMany(Answer::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function course(){
        return $this->hasOne(Course::class);
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}

