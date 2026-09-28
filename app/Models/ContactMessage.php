<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUSES = ['unread', 'read', 'replied', 'archived'];

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address'];

    public function scopeUnread($q)
    {
        return $q->where('status', 'unread');
    }
}