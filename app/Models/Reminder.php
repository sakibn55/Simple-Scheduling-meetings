<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Reminder extends Model
{
    use HasFactory;
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }



    public function student(){
        return $this->belongsTo(User::class, 'student_id' ,'id');
    }

    public function advisor(){
        return $this->belongsTo(User::class, 'advisor_id' ,'id');
    }

}
