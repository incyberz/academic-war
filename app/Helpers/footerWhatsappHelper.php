<?php

if (! function_exists('footerWhatsapp')) {
  function footerWhatsapp(): string
  {
    $timestamp = date("D, M d, Y, H:i:s");
    return "\n\nFrom: \nAcademic War :: Sistem Bimbingan Online\n$timestamp";
  }
}
