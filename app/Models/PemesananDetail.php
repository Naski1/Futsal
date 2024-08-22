<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PemesananDetail extends Model
{
    use HasFactory;
    protected $table = 'detail_pemesanan';
    protected $primaryKey = 'id_detail_pemesanan';

    protected $fillable = [
        'id_detail_pemesanan',
        'pemesanan_id',
        'jadwal_id',
        'durasi',
        'biaya',
        'status'
    ];

    protected $casts = [
        'id_detail_pemesanan' => 'integer'
    ];

    /**
     * Get the user associated with the PemesananDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jadwal(): HasOne
    {
        return $this->hasOne(Jadwal::class, 'id_jadwal', 'jadwal_id');
    }
}
