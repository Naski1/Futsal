<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jam extends Model
{
    use HasFactory;
    protected $table = 'jam';
    protected $primaryKey = 'id_jam';

    protected $fillable = [
        'id_jam',
        'nama_jam',
        'jam_awal',
        'jam_akhir',
        'durasi',
        'biaya',
        'status'
    ];

    protected $casts = [
        'id_jam' => 'integer'
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
