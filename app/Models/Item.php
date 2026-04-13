<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'category_id', 'total', 'repair'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lendings()
    {
        return $this->hasMany(Lending::class);
    }

    public function getLendingTotalAttribute()
    {
        return $this->lendings()->whereNull('returned_at')->sum('total');
    }

    public function getAvailableAttribute()
    {
        return $this->total - $this->repair - $this->lending_total;
    }
}
