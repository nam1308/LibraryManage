<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class HomeEnums extends Enum
{
    // Khai báo const cho trạng thái
    const FILTER_DATE = '0';
    const FILTER_MONTH = '1';
    const FILTER_QUARTER = '2';
    const FILTER = [
        self::FILTER_DATE => 'Ngày',
        self::FILTER_MONTH => 'Tháng',
        self::FILTER_QUARTER => 'Quý',
    ];

}