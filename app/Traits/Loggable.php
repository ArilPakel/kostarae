<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Loggable
{
    /**
     * Boot the trait. Listen for Eloquent events otomatis.
     */
    public static function bootLoggable()
    {
        // 1. Saat data baru DIBUAT (Created)
        static::created(function ($model) {
            self::logActivity('created', $model);
        });

        // 2. Saat data DIUPDATE (Updated)
        static::updated(function ($model) {
            self::logActivity('updated', $model);
        });

        // 3. Saat data DIHAPUS (Deleted)
        static::deleted(function ($model) {
            self::logActivity('deleted', $model);
        });
    }

    /**
     * Fungsi utama untuk menyimpan ke database
     */
    protected static function logActivity($action, $model)
    {
        if (app()->runningInConsole()) return;

        $user = Auth::user();
        
        $properties = [];
        if ($action === 'updated') {
            $properties = [
                'sebelum' => $model->getOriginal(),
                'sesudah' => $model->getAttributes(),
            ];
            // Hapus data sensitif
            unset($properties['sebelum']['password'], $properties['sesudah']['password']);
            unset($properties['sebelum']['remember_token'], $properties['sesudah']['remember_token']);
        }

        $className = class_basename($model);
        $dataName  = $model->name ?? $model->nama ?? $model->title ?? $model->nama_kost ?? '#' . $model->id;
        
        $description = match ($action) {
            'created' => "Menambahkan $className baru: $dataName",
            'updated' => "Memperbarui $className: $dataName",
            'deleted' => "Menghapus $className: $dataName",
            default   => "$action $className",
        };

        ActivityLog::create([
            'user_id'       => $user ? $user->id : null,
            'user_role'     => $user ? $user->role : 'system',
            'action'        => $action,
            'description'   => $description,
            'subject_type'  => get_class($model),
            'subject_id'    => $model->id,
            'properties'    => $properties,
            'ip_address'    => Request::ip(),
            'user_agent'    => Request::header('User-Agent'),
        ]);
    }
}