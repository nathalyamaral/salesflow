<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Relationship: A seller has many sales.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'seller_id');
    }
}
