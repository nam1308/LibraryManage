<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CategoryEnums extends Enum
{
    const PARAM_RULE_ID = 'id';

    // Khai báo const cho trạng thái
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '0';
    const STATUS = [
        self::STATUS_ACTIVE => 'Đang hoạt động',
        self::STATUS_INACTIVE => 'Ngừng hoạt động',
    ];

    // Hàm xử lí cho lấy trạng thái
    public static function getStatusName($status)
    {
        switch ($status) {
            case '0':
                return  "<span class='text-danger'>" . CategoryEnums::STATUS[0] . "</span>";
                break;
            case '1':
                return "<span class='text-success'>" . CategoryEnums::STATUS[1] . "</span>";
                break;
            default:
                break;
        }
    }

}
