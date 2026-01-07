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
        
        // --- VARIASI NAMA (Agar aman jika DB pakai 'nama' atau 'nama_kost') ---
        'nama',            
        'nama_kost',       

        'alamat',
        'harga',
        
        // --- VARIASI TIPE ---
        'tipe',            
        'tipe_kost',       

        'fasilitas',       // JSON
        'foto',            // JSON (Fallback jika tidak pakai tabel kost_images)
        'status',          // pending, diterima, ditolak
        'deskripsi',
        'alasan_penolakan',

        // --- LOKASI (Sesuai Controller Admin) ---
        'kota',
        'kecamatan',
        'kelurahan',
        
        // --- FITUR IKLAN ---
        'is_promoted',          // Status apakah sedang diiklankan (true/false)
        'promoted_start_date',  // Tanggal mulai iklan
        'promoted_end_date',    // Tanggal selesai iklan
        
        // --- FITUR REKOMENDASI ADMIN ---
        'is_recommended',       // Checkbox rekomendasi manual admin
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'fasilitas' => 'array',
        'foto'      => 'array',
        'harga'     => 'integer',
        
        // Casting untuk Iklan & Rekomendasi
        'is_promoted'     => 'boolean',
        'is_recommended'  => 'boolean', // Baru
        'promoted_start_date' => 'datetime', 
        'promoted_end_date'   => 'datetime', 
    ];

    // Agar atribut tambahan ini ikut muncul saat model di-convert ke JSON/Array
    protected $appends = ['is_recommendable', 'recommendation_issues', 'promotion_status_label', 'data_completeness'];

    /*
    |--------------------------------------------------------------------------
    | RELASI DATABASE
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Pemilik (User)
     */
    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    /**
     * Alias 'user' agar kompatibel dengan Controller lama
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
     * Relasi ke Kost Images (PERBAIKAN UTAMA)
     * Mengatasi error "Call to undefined relationship [kostImages]"
     */
    // public function kostImages()
    // {
    //     return $this->hasMany(KostImage::class);
    // }

    /**
     * Relasi ke Views Counter
     */
    public function views()
    {
        return $this->hasMany(\App\Models\KostView::class);
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

        // Kriteria 1: Foto minimal 3 (Cek JSON atau Relasi)
        $hasImages = false;
        // Cek JSON
        if (!empty($this->foto) && is_array($this->foto) && count($this->foto) >= 3) {
            $hasImages = true;
        } 
        // Cek Relasi kostImages (Jika JSON kosong)
        elseif ($this->relationLoaded('kostImages') && $this->kostImages->count() >= 3) {
            $hasImages = true;
        }
        
        if ($hasImages) $score++;

        // Kriteria 2: Alamat Lengkap
        if (!empty($this->alamat) && strlen($this->alamat) > 10) $score++;

        // Kriteria 3: Harga & Tipe terisi
        if ($this->harga > 0 && (!empty($this->tipe) || !empty($this->tipe_kost))) $score++;

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
               $this->data_completeness >= 80; // Ambang batas toleransi 80%
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
        
        // Cek foto
        $fotoCount = 0;
        if (is_array($this->foto)) $fotoCount = count($this->foto);
        if ($this->relationLoaded('kostImages')) $fotoCount = max($fotoCount, $this->kostImages->count());

        if ($fotoCount < 3) $issues[] = "Foto kurang dari 3";

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
}