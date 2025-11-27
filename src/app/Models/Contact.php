<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNameOrEmailSearch($query, $name)
    {
        if (empty($name)) {
            return $query;
        }

        return $query->where(function ($q) use ($name) {
                $q->where('last_name', 'like', '%' . $name . '%')
                ->orWhere('first_name', 'like', '%' . $name . '%')
                ->orWhere('email', 'like', '%' . $name . '%');
        });

    }

    public function scopeGenderSearch($query, $gender)
    {
        if (empty($gender)) {
            return $query;
        }

        return $query->where('gender', $gender);
    }

    public function scopeCategoryFilter($query, $category_id)
    {
        if (empty($category_id)) {
            return $query;
        }

            return $query->where('category_id', $category_id);

    }
}
