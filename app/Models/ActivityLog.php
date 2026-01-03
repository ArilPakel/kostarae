<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Prunable;

class ActivityLog extends Model
{
    use MassPrunable;

    protected $guarded = ['id'];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi polymorphic (subject)
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Data yang boleh di-prune
     * Hapus log yang lebih tua dari 1 tahun
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subYear());
    }

    public function getSeverityAttribute()
     {
     // 1. Critical: Hapus data atau Ganti Pemilik
     if ($this->action === 'deleted') return 'critical';
     if ($this->action === 'updated' && isset($this->properties['attributes']['user_id'])) return 'critical';

     // 2. Warning: Ubah Harga atau Status
     if ($this->action === 'updated') {
          $changedKeys = array_keys($this->properties['attributes'] ?? []);
          $riskyFields = ['harga', 'price', 'status', 'is_active', 'rekening'];
          
          // Cek irisan array (apakah ada field berisiko yang berubah)
          if (!empty(array_intersect($changedKeys, $riskyFields))) {
               return 'warning';
          }
     }

     // 3. Info: Sisanya (Login, Edit Deskripsi, Upload Foto)
     return 'info';
     }

     public function getHumanSummaryAttribute()
     {
     if ($this->action === 'login') return "Masuk ke sistem.";
     if ($this->action === 'logout') return "Keluar dari sistem.";
     if ($this->action === 'created') return "Menambahkan data baru.";
     if ($this->action === 'deleted') return "Menghapus data.";
     
     if ($this->action === 'updated') {
          $changes = [];
          
          // Ambil data perubahan (sesuaikan dengan key di DB Anda)
          $attributes = $this->properties['sesudah'] ?? $this->properties['attributes'] ?? [];
          $oldData    = $this->properties['sebelum'] ?? $this->properties['old'] ?? [];

          foreach ($attributes as $key => $newValue) {
               // 1. Skip field teknis dan media yang berat
               if (in_array($key, ['updated_at', 'created_at', 'id', 'foto'])) continue;

               $oldValue = $oldData[$key] ?? '-';
               
               // 2. Cek jika nilainya sama, skip
               if ($oldValue == $newValue) continue;

               // 3. PENANGANAN ERROR: Cek jika nilainya adalah Array (Solusi Error Anda)
               $oldDisplay = is_array($oldValue) ? json_encode($oldValue) : $oldValue;
               $newDisplay = is_array($newValue) ? json_encode($newValue) : $newValue;

               // 4. Format Mata Uang jika perlu
               if (str_contains($key, 'harga')) {
                    $oldDisplay = 'Rp' . number_format((float)$oldValue);
                    $newDisplay = 'Rp' . number_format((float)$newValue);
               }

               // 5. Masukkan ke daftar perubahan (Baris 95 yang tadi error)
               $changes[] = ucfirst(str_replace('_', ' ', $key)) . " ($oldDisplay ➝ $newDisplay)";
          }

          if (empty($changes)) return "Memperbarui data.";
          
          // Buat kalimat ringkas (maksimal 2 perubahan agar tidak berantakan)
          $summary = implode(', ', array_slice($changes, 0, 2));
          if (count($changes) > 2) $summary .= ", dan " . (count($changes) - 2) . " lainnya.";
          
          return "Mengubah: " . $summary;
     }

     return $this->description;
     }
}
