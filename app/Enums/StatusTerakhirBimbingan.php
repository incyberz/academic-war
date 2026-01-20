<?php

namespace App\Enums;

enum StatusTerakhirBimbingan: int
{
  case BELUM  = 0;
  case ONTIME  = 1;
  case TELAT   = -1;
  case KRITIS  = -2;

  public function label(): string
  {
    return match ($this) {
      self::BELUM => 'Belum Pernah Bimbingan',
      self::ONTIME => 'Tepat Waktu',
      self::TELAT  => 'Terlambat',
      self::KRITIS => 'Kritis',
    };
  }

  public function emoji(): string
  {
    return match ($this) {
      self::BELUM => '🔴',
      self::ONTIME => '🟢',
      self::TELAT  => '🟡',
      self::KRITIS => '🔴',
    };
  }
}
