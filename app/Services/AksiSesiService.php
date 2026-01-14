<?php

namespace App\Services;

class AksiSesiService
{
  public static function get(string $role, int $status): array
  {
    $config = config("aksi_sesi.$role");

    if (!$config) dd("Role [$role] belum punya config aksi_sesi.");
    // if (!$config) return [];

    // status spesifik
    if (isset($config[$status])) {
      return $config[$status];
    }

    // status negatif
    if ($status < 0 && isset($config['negatif'])) {
      return $config['negatif'];
    }

    // wildcard
    return $config['*'] ?? [];
  }
}
