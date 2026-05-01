<?php

/**
 * Bukti laporan berupa gambar JPG yang diverifikasi pembimbing sebagai bukti bahwa mahasiswa sudah menyelesaikan bab laporan tertentu.
 * Polymorphic ke: BabLaporan, SubBabLaporan, dll (buktiable_type, buktiable_id)
 * Relasi utama ke PesertaBimbingan (peserta_bimbingan_id) 
 * Terdapat gamified checklist yang dimanage dosen, wajib/optional diceklis oleh mhs
 */

return [

  'submitted' => [
    'label' => 'Submitted',
    'emoji' => '⏳',
    'color' => 'warning',
    'is_pending' => true,
  ],

  'in_review' => [
    'label' => 'In Review',
    'emoji' => '👀',
    'color' => 'info',
    'is_pending' => true,
    'allow_offline_discussion' => true,
  ],

  'revised' => [
    'label' => 'Revised',
    'emoji' => '⚠️',
    'color' => 'danger',
    'is_pending' => false,
  ],

  'approved' => [
    'label' => 'Approved',
    'emoji' => '✅',
    'color' => 'success',
    'is_pending' => false,
    'is_final' => true,
  ],

];
