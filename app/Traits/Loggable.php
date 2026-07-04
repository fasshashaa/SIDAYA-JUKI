<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\App;

trait Loggable
{
    public static function bootLoggable()
    {
        // 1. Amankan Event saat Data Baru Dibuat (Create)
        static::created(function ($model) {
            $after = $model->getAttributes();
            // Sembunyikan field sensitif seperti password jika ada
            unset($after['password']); 
            
            self::saveAuditLog('CREATE_' . strtoupper(class_basename($model)), $model, null, $after);
        });

        // 2. Amankan Event saat Data Diubah (Update)
        static::updating(function ($model) {
            $changes = $model->getDirty();
            $before = [];
            
            foreach ($changes as $key => $value) {
                $before[$key] = $model->getOriginal($key);
            }

            // Jika yang berubah hanya timestamp updated_at (seperti tes tinker tadi), 
            // kita masukkan visualisasi ringkas agar inspeksi data tidak kosong mentah.
            if (count($changes) === 1 && isset($changes['updated_at'])) {
                $changes['info'] = 'Memicu perubahan eksternal / touch timestamp';
            }

            self::saveAuditLog('UPDATE_' . strtoupper(class_basename($model)), $model, $before, $changes);
        });

        // 3. Amankan Event saat Data Dihapus (Delete)
        static::deleted(function ($model) {
            self::saveAuditLog('DELETE_' . strtoupper(class_basename($model)), $model, $model->getAttributes(), null);
        });
    }

    protected static function saveAuditLog($activity, $model, $before, $after)
    {
        // Deteksi Otomatis Aktor Pengguna
        $userId = null;
        if (Auth::check()) {
            $userId = Auth::id();
        } elseif (App::runningInConsole()) {
            // Jika dieksekusi lewat php artisan tinker / cron job cpanel
            // Cari user Super Admin pertama di DB untuk dijadikan penanggung jawab sistem log terminal
            $superAdmin = \App\Models\User::where('role', 'superadmin')->orWhere('email', 'like', '%admin%')->first();
            $userId = $superAdmin ? $superAdmin->id : null;
        }

        AuditLog::create([
            'user_id' => $userId,
            'activity' => $activity,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'before_changes' => $before,
            'after_changes' => $after,
            'ip_address' => App::runningInConsole() ? '127.0.0.1 (CLI/Tinker)' : Request::ip(),
            'user_agent' => App::runningInConsole() ? 'Symfony/Console CLI' : Request::userAgent(),
        ]);
    }
}