<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BorrowerEnums extends Enum
{
    const STATUS_ACTIVE = '0';

    const STATUS_INACTIVE = '1';

    const STATUS_EXTEND = '2';

    const STATUS_OVERDUE = '3';

    const RENEWAL_NONE = '0';
    const RENEWAL_ONE = '1';
    const RENEWAL_TWO = '2';


    const STATUS = [
        self::STATUS_ACTIVE => 'Đang mượn',
        self::STATUS_INACTIVE => 'Đã trả',
        self::STATUS_EXTEND => 'Gia Hạn',
        self::STATUS_OVERDUE => 'Quá hạn',
    ];

    public static function getStatusName($status)
    {
        switch ($status) {
            case '0':
                return  "<span class='text-info'>" . BorrowerEnums::STATUS[0] . "</span>";
                break;
            case '1':
                return "<span class='text-success'>" . BorrowerEnums::STATUS[1] . "</span>";
                break;
            case '2':
                return "<span class='text-warning'>" . BorrowerEnums::STATUS[2] . "</span>";
                break;
            case '3':
                return "<span class='text-danger'>" . BorrowerEnums::STATUS[3] . "</span>";
                break;
            default:
                break;
        }
    }

    const STATUSBORROW = [
        0 => 'Đang Mượn',
        1 => 'Đã Trả',
        2 => 'Gia Hạn',
    ];

    const OVERDUE_WARNING_DATE_FIRST = 1;
    const OVERDUE_WARNING_DATE_SECOND = 5;
    const OVERDUE_WARNING_DATE_THIRD = 10;
}
