<?php

/**
 * Bukti laporan berupa gambar JPG yang diverifikasi pembimbing sebagai bukti bahwa mahasiswa sudah menyelesaikan bab laporan tertentu.
 * Polymorphic ke: BabLaporan, SubBabLaporan, dll (buktiable_type, buktiable_id)
 * Relasi utama ke PesertaBimbingan (peserta_bimbingan_id) 
 * Terdapat gamified checklist yang dimanage dosen, wajib/optional diceklis oleh mhs
 * 
 * Status: 
 * 0 - submitted (oleh mhs, belum dibuka dosen)
 * 1 - reviewed (opened by dosen),
 * 2 - revised
 * 3 - approved
 */

return [

  0 => [
    'key'   => 'submitted',
    'label' => 'Submitted',
    'emoji' => '⏳',
    'color' => 'warning',
    'ket' => 'bukti baru di-submit oleh mhs, belum dibuka dosen',
  ],

  1 => [
    'key'   => 'reviewed',
    'label' => 'Reviewed',
    'emoji' => '👀',
    'color' => 'info',
    'ket' => 'bukti sudah dibuka dan direview oleh dosen, belum ada feedback',
  ],

  2 => [
    'key'   => 'revised',
    'label' => 'Revised',
    'emoji' => '⚠️',
    'color' => 'danger',
    'ket' => 'bukti perlu revisi, dosen sudah memberikan catatan revisi',
  ],

  3 => [
    'key'   => 'approved',
    'label' => 'Approved',
    'emoji' => '✅',
    'color' => 'success',
    'ket' => 'bukti sudah disetujui dosen, tidak perlu revisi',
  ],


];
