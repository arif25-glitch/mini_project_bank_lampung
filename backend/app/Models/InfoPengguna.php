<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfoPengguna extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'info_pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tanggal_lahir',
        'alamat_tempat_tinggal',
        'jenis_kelamin',
        'foto_profile',
    ];

    /**
     * Get the user that owns the info pengguna.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
