<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for the sales table.
 */
class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'seller_id',
        'amount',
        'commission',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Relationship: A sale belongs to a seller.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
