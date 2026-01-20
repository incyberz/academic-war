<?php

namespace App\ViewModels;

use Illuminate\Support\Facades\Auth;
use App\Models\PesertaBimbingan;
use App\Models\SesiBimbingan;

class PesertaBimbinganView
{
  public function __construct(
    public readonly PesertaBimbingan $peserta
  ) {}

  public function configStatusPeserta()
  {
    return config('status_peserta_bimbingan');
  }

  public function namaBimbingan()
  {
    return $this->peserta->bimbingan->jenisBimbingan->nama;
  }

  public function namaPeserta()
  {
    return $this->peserta->mhs->nama_lengkap;
  }

  public function namaPembimbing()
  {
    return $this->peserta->bimbingan->pembimbing->dosen->user->name;
  }

  public function isMe()
  {
    return $this->peserta->mhs->user->id === Auth::id();
  }

  public function isMyBimbingan()
  {
    return $this->peserta->bimbingan->pembimbing->dosen->user->id === Auth::id();
  }

  public function pageTitle(): string
  {
    if ($this->isMe()) {
      return 'My Sesi Bimbingan';
    }

    if ($this->isMyBimbingan()) {
      return 'Sesi Bimbingan Mahasiswa';
    }

    return 'Sesi Bimbingan';
  }

  public function pageSubtitle(): string
  {
    if ($this->isMe()) {
      return 'Riwayat dan progres bimbingan skripsi Anda';
    }

    if ($this->isMyBimbingan()) {
      return 'Pantau dan review progres bimbingan mhs';
    }

    return 'Informasi sesi bimbingan';
  }


  /** ======================
   * CHECK KONTRIBUSI
   * ====================== */

  public function hasUploadAndMessage(SesiBimbingan $sesi): bool
  {
    return filled($sesi->file_bimbingan) && filled($sesi->pesan_mhs);
  }

  public function hasFeedbackReview(SesiBimbingan $sesi): bool
  {
    return filled($sesi->pesan_dosen) && filled($sesi->feedback_mhs);
  }

  public function hasRating(SesiBimbingan $sesi): bool
  {
    return !is_null($sesi->rating_sesi);
  }

  /** ======================
   * PROGRESS
   * ====================== */

  public function sessionProgressPercent(SesiBimbingan $sesi): int
  {
    $percent = 0;

    if ($this->hasUploadAndMessage($sesi)) $percent += 70;
    if ($this->hasFeedbackReview($sesi))  $percent += 20;
    if ($this->hasRating($sesi))          $percent += 10;

    return $percent;
  }

  /** ======================
   * UI HELPERS
   * ====================== */

  public function checkIcon(bool $done): string
  {
    return $done
      ? '✅'
      : '⬜';
  }

  public function sessionMotivation(SesiBimbingan $sesi): string
  {
    return match (true) {
      !$this->hasUploadAndMessage($sesi)
      => '📄 Unggah laporan dan tulis pesan untuk memulai sesi.',
      filled($sesi->file_bimbingan) && !filled($sesi->pesan_dosen)
      => '🔍 Dosen sedang melakukan review.',
      !$this->hasFeedbackReview($sesi)
      => '💬 Berikan feedback atas review dosen.',
      !$this->hasRating($sesi)
      => '⭐ Beri rating sesi untuk menyelesaikan kontribusi.',
      default
      => '🎉 Terima kasih, kontribusi Anda pada sesi ini sudah lengkap.',
    };
  }
}
