<?php
namespace App\Helpers;

class CacheKeys
{
    const PHONE_CONFIRM_KEY = 'phone:confirm:';
    const PHONE_CONFIRM_TTL = 2;

    const PERMISSION_EMPLOYER_KEY = 'permission:user:';
    const PERMISSION_EMPLOYER_TTL = 1440;
}
