<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmItem extends Model
{
    use HasFactory;

    protected $table = 'stm_item';

    protected $fillable = [
        'stm_id',
        'kur_mk_id',
        'kelas_id',
        'course_id', // LMS Course
        'stm_mk_id',
        'kapasitas',
        'is_open',
        'sks_tugas',
        'sks_beban',
        'sks_honor',
    ];

    /**
     * Relasi: StmItem → KurMk (MK dalam kurikulum)
     */
    public function kurMk()
    {
        return $this->belongsTo(KurMk::class, 'kur_mk_id');
    }

    /**
     * Relasi: StmItem → Kelas aktual
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi: StmItem → STM Detail (dosen pengampu)
     * nullable → belum dijadwalkan
     */
    public function stmMk()
    {
        return $this->belongsTo(StmMk::class, 'stm_mk_id');
    }

    public function stm()
    {
        return $this->belongsTo(Stm::class, 'stm_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Relasi: StmItem -> SesiKelas
     * (daftar sesi real untuk kelas ini)
     */
    public function sesiKelass()
    {
        return $this->hasMany(SesiKelas::class, 'stm_item_id');
    }

    /**
     * Opsional: ambil Unit lewat Course
     * berguna untuk generate sesi_kelas otomatis
     */
    public function units()
    {
        return $this->hasMany(Unit::class, 'course_id', 'course_id');
    }
}
