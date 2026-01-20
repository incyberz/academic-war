<?php

namespace App\Enums;

enum StatusSesiBimbingan: int
{
  case DITOLAK_SISTEM = -100;
  case BELUM          = -2;
  case DIBATALKAN     = -1;
  case DIAJUKAN       = 0;
  case DISETUJUI      = 1;
  case REVISI         = 2;
  case SELESAI        = 3;
  case FINAL          = 100;

  public function label(): string
  {
    return match ($this) {
      self::DITOLAK_SISTEM => 'Ditolak Sistem',
      self::BELUM          => 'Belum Pernah Pengajuan',
      self::DIBATALKAN     => 'Dibatalkan',
      self::DIAJUKAN       => 'Diajukan',
      self::DISETUJUI      => 'Disetujui',
      self::REVISI         => 'Perlu Revisi',
      self::SELESAI        => 'Selesai',
      self::FINAL          => 'Final',
    };
  }

  public function emoji(): string
  {
    return match ($this) {
      self::BELUM   => '‼️',
      self::DIAJUKAN   => '🕒',
      self::REVISI     => '✏️',
      self::SELESAI,
      self::FINAL     => '✅',
      self::DIBATALKAN,
      self::DITOLAK_SISTEM => '❌',
      default         => '📌',
    };
  }
}
