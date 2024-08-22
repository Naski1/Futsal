<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_pemesanan',
        'user_id',
        'kode_pemesanan',
        'tgl_pemesanan',
        'total_durasi',
        'total_biaya',
        'sisa_biaya',
        'status_bayar',
        'status'
    ];

    protected $casts = [
        'id_pemesanan' => 'integer'
    ];

    /**
     * Get the user that owns the Pemesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Get all of the comments for the Pemesanan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pemesananDetail(): HasMany
    {
        return $this->hasMany(PemesananDetail::class, 'pemesanan_id', 'id_pemesanan');
    }
}
