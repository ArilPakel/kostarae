<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kost extends Model
{
    use HasFactory;
    use \App\Traits\Loggable; // Pastikan Trait ini ada di folder App\Traits
    use LogsActivity;

    protected $table = 'kosts';

    protected $fillable = [
        'pemilik_id',      // Relasi ke tabel users
        'nama',            // Nama Kost
        'alamat',
        'harga',
        'tipe',            // Putra/Putri/Campur
        'fasilitas',       // JSON
        'foto',            // JSON ["path1", "path2"]
        'status',          // pending, diterima, ditolak
        'deskripsi',
        'alasan_penolakan',
        
        // --- TAMBAHAN UNTUK FITUR IKLAN ---
        'is_promoted',          // Status apakah sedang diiklankan (true/false)
        'promoted_start_date',  // Tanggal mulai iklan
        'promoted_end_date',    // Tanggal selesai iklan
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'fasilitas' => 'array',
        'foto'      => 'array',
        'harga'     => 'integer',
        
        // Casting untuk Iklan
        'is_promoted' => 'boolean',
        'promoted_start_date' => 'datetime', 
        'promoted_end_date'   => 'datetime', 
    ];

    // Agar atribut tambahan ini ikut muncul saat model di-convert ke JSON/Array
    protected $appends = ['is_recommendable', 'recommendation_issues', 'promotion_status_label', 'data_completeness'];

    /**
     * Relasi ke Pemilik (User) - Menggunakan nama 'pemilik'
     */
    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    /**
     * [FIX ERROR ADMIN] 
     * Relasi Alias 'user' agar kompatibel dengan Controller Admin 
     * yang memanggil Kost::with('user')
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    /**
     * Relasi ke Review (Has Many)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'kost_id');
    }

    /**
     * SCOPE: Filter Kost Aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'diterima');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (LOGIKA PERHITUNGAN OTOMATIS)
    |--------------------------------------------------------------------------
    */

    // 1. HITUNG SKOR KELENGKAPAN DATA (0 - 100%)
    public function getDataCompletenessAttribute()
    {
        $score = 0;
        $total_criteria = 5; 

        // Kriteria 1: Foto minimal 3
        $fotos = $this->foto; 
        if (is_array($fotos) && count($fotos) >= 3) $score++;

        // Kriteria 2: Alamat Lengkap
        if (!empty($this->alamat) && strlen($this->alamat) > 10) $score++;

        // Kriteria 3: Harga & Tipe terisi
        if ($this->harga > 0 && !empty($this->tipe)) $score++;

        // Kriteria 4: Fasilitas terisi
        $fasilitas = $this->fasilitas;
        if (!empty($fasilitas) && is_array($fasilitas) && count($fasilitas) > 0) $score++;

        // Kriteria 5: Data Fresh
        if (optional($this->updated_at)->gte(Carbon::now()->subDays(60))) $score++;

        return ($score / $total_criteria) * 100;
    }

    // 2. CEK KELAYAKAN REKOMENDASI (Boolean: True/False)
    public function getIsRecommendableAttribute()
    {
        $rating = $this->reviews_avg_rating ?? 0;
        $count = $this->reviews_count ?? 0;

        return $this->status === 'diterima' &&
               $rating >= 4.0 &&
               $count >= 2 &&
               $this->data_completeness == 100;
    }

    // 3. ALASAN KENAPA TIDAK LAYAK (Untuk Admin Panel)
    public function getRecommendationIssuesAttribute()
    {
        $issues = [];
        $rating = $this->reviews_avg_rating ?? 0;
        $count = $this->reviews_count ?? 0;

        if ($this->status !== 'diterima') $issues[] = "Status kost belum diterima";
        if ($rating < 4.0) $issues[] = "Rating rata-rata rendah (< 4.0)";
        if ($count < 2) $issues[] = "Jumlah ulasan kurang (< 2)";
        
        $fotos = $this->foto;
        if (!is_array($fotos) || count($fotos) < 3) $issues[] = "Foto kurang dari 3";

        if (optional($this->updated_at)->lt(Carbon::now()->subDays(60))) $issues[] = "Data jarang diupdate (> 60 hari)";

        return $issues;
    }

    // 4. LABEL STATUS IKLAN
    public function getPromotionStatusLabelAttribute()
    {
        if (!$this->is_promoted) return 'Nonaktif';

        $now = Carbon::now();
        if (!$this->promoted_start_date || !$this->promoted_end_date) return 'Error Tanggal';

        $start = $this->promoted_start_date;
        $end = $this->promoted_end_date;

        if ($now->between($start, $end)) return 'Aktif';
        if ($now->lt($start)) return 'Akan Datang';
        if ($now->gt($end)) return 'Berakhir';
        
        return 'Nonaktif';
    }

    // 5. Konfigurasi Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Data Kost ini telah di-{$eventName}");
    }

    public function views()
    {
    return $this->hasMany(\App\Models\KostView::class);
    }


}