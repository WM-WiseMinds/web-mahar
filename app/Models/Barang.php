<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $table = "barang";

    // Mendefinisikan atribut yang dapat diisi (fillable) oleh pengguna
    protected $fillable = [
        'nama_barang', // Ini adalah nama barang
        'keterangan', // Ini adalah keterangan atau deskripsi barang dalam bentuk teks
        'gambar', // Ini adalah nama file gambar barang
        'status', // Ini adalah status barang
    ];

    // Mendefinisikan tipe data untuk atribut 'keterangan' sebagai teks
    protected $casts = [];

    // Mendefinisikan hubungan "hasMany" dengan model Ukuran
    // Ini mengindikasikan bahwa satu barang memiliki banyak ukuran
    public function ukuran()
    {
        return $this->hasMany(Ukuran::class);
    }

    // Mendefinisikan relasi 'portfolio' dimana 'Barang' memiliki banyak 'Portfolio'.
    public function portfolio()
    {
        return $this->hasMany(Portfolio::class);
    }
}
