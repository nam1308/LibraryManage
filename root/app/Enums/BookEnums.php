<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OPTION_ONE()
 * @method static static OPTION_TWO()
 * @method static static OPTION_THREE()
 */
final class BookEnums extends Enum
{
    const ZERO = 0;
    const ONE = 1;
    const OPTION_TWO = 1;
    const OPTION_THREE = 2;
    const PARAM_RULE_BOOK_CD = 'book_cd';
    const PARAM_RULE_NAME = 'name';
    const IS_DETAIL = 1;
    const CATE_BOOK_LIMIT = 3;

}
