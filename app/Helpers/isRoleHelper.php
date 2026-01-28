<?php

/** 
 * isRoleHelper untuk Cek Role, input role name bukan role_id
 */

use Illuminate\Support\Facades\Auth;

function isRole($role_name)
{
  $roles = config('roles');
  if (!key_exists($role_name, $roles)) dd("Role name [$role_name] tidak ada di konfigurasi roles.");

  $user = Auth::user();
  if (!$user) return false;

  return $user->role->role_name === $role_name;
}


function isSuperAdmin()
{
  return isRole('super_admin');
}

function isDosen()
{
  return isRole('dosen');
}

function isMhs()
{
  return isRole('mhs');
}
