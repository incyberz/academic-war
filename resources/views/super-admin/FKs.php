<?php

/**
 * FKs hasMany untuk konteks AI
 */

/*


jenis_bimbingan->bimbingan->pembimbing->dosen->user->id,
jenis_bimbingan->bimbingan->pesertaBimbingan->mhs->user->id,
jenis_bimbingan->bimbingan->pesertaBimbingan->buktiLaporan(),

jenis_bimbingan->bimbingan->pesertaBimbingan->sesiBimbingan(),
jenis_bimbingan->tahapanBimbingan->sesiBimbingan(),
jenis_bimbingan->babLaporan->sesiBimbingan(),


jenis_bimbingan->babLaporan->subBab,
bukti_laporan->buktiable_id, polymorphic to bab_laporan_id atau sub_bab_laporan_id 


*/