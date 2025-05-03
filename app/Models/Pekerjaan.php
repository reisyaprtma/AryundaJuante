<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pekerjaan extends Model
{
    //
    use HasFactory;

    protected $table = 'pekerjaan';

    protected $fillable = [
        'nama', 'no_kontak', 'url_dokumen', 'deadline', 'status', 'ditangani','deskripsi','kategori','client','total','tanggal_tagihan'
    ];

    public function ditanganiUser()
    {
        return $this->belongsTo(User::class, 'ditangani');
    }

}
