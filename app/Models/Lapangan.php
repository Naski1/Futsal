<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lapangan extends Model
{
    use HasFactory;
    protected $table = 'lapangan';
    protected $primaryKey = 'id_lapangan';

    protected $fillable = [
        'id_lapangan',
        'nama_lapangan',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'id_lapangan' => 'integer'
    ];

    /**
     * Get the jadwal that owns the Jam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'id_lapangan', 'lapangan_id');
    }
}
