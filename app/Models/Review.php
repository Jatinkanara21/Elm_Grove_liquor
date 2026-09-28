<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    protected $fillable = ['name', 'email', 'rating', 'body', 'status', 'ip_address'];

    protected function casts(): array
    {
        return ['rating' => 'integer'];
    }

    public function scopeApproved($q)
    {
        return $q->where('status', self::APPROVED);
    }

    public function scopePending($q)
    {
        return $q->where('status', self::PENDING);
    }
}