<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_jadwal',
        'lapangan_id',
        'jam_id',
        'status'
    ];

    protected $casts = [
        'id_jadwal' => 'integer'
    ];

    /**
     * Get all of the lapangan for the Jadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lapangan(): HasOne
    {
        return $this->hasOne(Lapangan::class, 'id_lapangan', 'lapangan_id');
    }

    /**
     * Get all of the jam for the Jadwal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jam(): HasOne
    {
        return $this->hasOne(Jam::class, 'id_jam', 'jam_id');
    }
}
