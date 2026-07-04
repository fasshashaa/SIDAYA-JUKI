<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity',
        'model_type',
        'model_id',
        'before_changes',
        'after_changes',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'before_changes' => 'array',
        'after_changes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Penerapan ISO 27001 Kontrol A.8.15: Proteksi Integritas Log (Anti-Tampering)
    protected static function boot()
    {
        parent::boot();

        // Gagalkan segala bentuk upaya update data log yang sudah terekam
        static::updating(function ($model) {
            return false;
        });

        // Gagalkan segala bentuk upaya penghapusan log (bahkan oleh Superadmin via aplikasi)
        static::deleting(function ($model) {
            return false;
        });
    }
}