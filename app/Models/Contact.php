<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'contact_number', 'slug', 
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Query Scope
    public function scopeName($query, $search){
        if($search)
            return $query->where('first_name', 'LIKE', "%$search%");
    }

    public function scopeEmail($query, $search){
        if($search)
            return $query->where('email', 'LIKE', "%$search%");
    }
}
