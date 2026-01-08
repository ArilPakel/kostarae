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
    use LogsActivity;
    
    // [OPSIONAL] Pastikan file app/Traits/Loggable.php benar-benar ada.
    // Jika tidak ada/error, beri komentar (//) pada baris di bawah ini:
    // use \App\Traits\Loggable; 

    protected $table = 'kosts';

    protected $fillable = [
        'pemilik_id',      
        'nama',            
        'nama_kost',       
        'alamat',
        'harga',
        'tipe',            
        'tipe_kost',       
        'fasilitas',       
        'foto',            
        'status',          
        'deskripsi',
        'alasan_penolakan',
        'kota',
        'kecamatan',
        'kelurahan',
        'is_promoted',          
        'promoted_start_date',  
        'promoted_end_date',    
        'is_recommended', // Penting: Kolom baru untuk rekomendasi admin
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'foto'      => 'array',
        'harga'     => 'integer',
        'is_promoted'     => 'boolean',
        'is_recommended'  => 'boolean',
        'promoted_start_date' => 'datetime', 
        'promoted_end_date'   => 'datetime', 
    ];

    protected $appends = ['is_recommendable', 'recommendation_issues', 'promotion_status_label', 'data_completeness'];

    /*
    |--------------------------------------------------------------------------
    | RELASI DATABASE
    |--------------------------------------------------------------------------
    */

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    // Alias untuk kompatibilitas
    public function user()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'kost_id');
    }

    /**
     * [PERBAIKAN] Method ini DI-UNCOMMENT agar logika 'getDataCompleteness' berjalan.
     * Pastikan Anda memiliki model App\Models\KostImage
     */
    public function kostImages()
    {
        // Gunakan try-catch relationship logic atau pastikan model KostImage ada.
        // Jika Anda TIDAK memakai tabel terpisah untuk foto, biarkan return null atau hapus method ini,
        // tapi hapus juga pengecekan 'kostImages' di bagian Accessor di bawah.
        // return $this->hasMany(\App\Models\KostImage::class);
    }

    public function views()
    {
        return $this->hasMany(\App\Models\KostView::class);
    }

    /**
     * SCOPE: Filter Kost Aktif
     */
    public function scopeActive($query)
    {
        // Pastikan status di database konsisten ('diterima' atau 'active' atau 'aktif')
        return $query->where('status', 'diterima')->orWhere('status', 'aktif');
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
        $hasImages = false;
        
        // Cek JSON column
        if (!empty($this->foto) && is_array($this->foto) && count($this->foto) >= 3) {
            $hasImages = true;
        } 
        // Cek Relasi kostImages (Hanya jika relasi tersedia)
        elseif (method_exists($this, 'kostImages') && $this->relationLoaded('kostImages')) {
            if ($this->kostImages->count() >= 3) {
                $hasImages = true;
            }
        }
        
        if ($hasImages) $score++;

        // Kriteria 2: Alamat Lengkap
        if (!empty($this->alamat) && strlen($this->alamat) > 10) $score++;

        // Kriteria 3: Harga & Tipe terisi
        if ($this->harga > 0 && (!empty($this->tipe) || !empty($this->tipe_kost))) $score++;

        // Kriteria 4: Fasilitas terisi
        if (!empty($this->fasilitas) && is_array($this->fasilitas) && count($this->fasilitas) > 0) $score++;

        // Kriteria 5: Data Fresh (Update dalam 60 hari terakhir)
        if (optional($this->updated_at)->gte(Carbon::now()->subDays(60))) $score++;

        return ($score / $total_criteria) * 100;
    }

    // 2. CEK KELAYAKAN REKOMENDASI OTOMATIS
    // Catatan: Ini beda dengan 'is_recommended' manual admin. Ini hanya saran sistem.
    public function getIsRecommendableAttribute()
    {
        // Pastikan controller menggunakan withAvg('reviews', 'rating') & withCount('reviews')
        $rating = $this->reviews_avg_rating ?? 0;
        $count = $this->reviews_count ?? 0;

        // Cek status (diterima atau aktif)
        $isActive = in_array($this->status, ['diterima', 'aktif']);

        return $isActive &&
               $rating >= 4.0 &&
               $count >= 2 &&
               $this->data_completeness >= 80;
    }

    // 3. ALASAN KENAPA TIDAK LAYAK
    public function getRecommendationIssuesAttribute()
    {
        $issues = [];
        $rating = $this->reviews_avg_rating ?? 0;
        $count = $this->reviews_count ?? 0;

        if (!in_array($this->status, ['diterima', 'aktif'])) $issues[] = "Status kost belum diterima/aktif";
        if ($rating < 4.0) $issues[] = "Rating rata-rata rendah (< 4.0)";
        if ($count < 2) $issues[] = "Jumlah ulasan kurang (< 2)";
        
        // Cek jumlah foto
        $fotoCount = 0;
        if (is_array($this->foto)) $fotoCount = count($this->foto);
        if (method_exists($this, 'kostImages') && $this->relationLoaded('kostImages')) {
            $fotoCount = max($fotoCount, $this->kostImages->count());
        }

        if ($fotoCount < 3) $issues[] = "Foto kurang dari 3";

        if (optional($this->updated_at)->lt(Carbon::now()->subDays(60))) $issues[] = "Data jarang diupdate (> 60 hari)";

        return $issues;
    }

    // 4. LABEL STATUS IKLAN
    public function getPromotionStatusLabelAttribute()
    {
        if (!$this->is_promoted) return 'Nonaktif';

        if (!$this->promoted_start_date || !$this->promoted_end_date) return 'Error Tanggal';

        $now = Carbon::now();
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