<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserEnums extends Enum
{
    // Khai báo const cho giới tính
    const GENDER = [
        0 => 'Nữ',
        1 => 'Nam',
        2 => 'Khác',
    ];

    // Khai báo const cho bộ phận phòng ban
    const DEPARTMENT = [
        1 => 'BOD',
        2 => 'BOM',
        3 => 'DX',
        4 => 'D3',
        5 => 'QA',
        6 => 'BO',
    ];

    const PARAM_RULE_ID = 'id';
    const IS_FIRST_LOGIN = 1;
    const IS_LAST_LOGIN = 0;

    // Khai báo const cho trạng thái
    const STATUS_INACTIVE = '0';
    const STATUS_ACTIVE = '1';
    const STATUS_BLOCK = '2';
    const STATUS = [
        self::STATUS_INACTIVE => 'Đã xóa',
        self::STATUS_ACTIVE => 'Đang hoạt động',
        self::STATUS_BLOCK => 'Đã khóa',
    ];

    const STATUS_BORROWING = '0';
    const STATUS_BORROWED = '1';
    const STATUS_RENEWAL = '2';
    const STATUSBORROW = [
        self::STATUS_BORROWING => 'Đang Mượn',
        self::STATUS_BORROWED => 'Đã Trả',
        self::STATUS_RENEWAL => 'Gia Hạn',
    ];


    // Hàm xử lí cho lấy giới tính
    public static function getGenderName($gender)
    {
        switch ($gender) {
            case '0':
                return UserEnums::GENDER[0];
                break;
            case '1':
                return UserEnums::GENDER[1];
                break;
            case '2':
                return UserEnums::GENDER[2];
                break;
            default:
                break;
        }
    }

    // Hàm xử lí cho lấy bộ phận phòng ban
    public static function getDepartmentName($department)
    {
        switch ($department) {
            case '1':
                return UserEnums::DEPARTMENT[1];
                break;
            case '2':
                return UserEnums::DEPARTMENT[2];
                break;
            case '3':
                return UserEnums::DEPARTMENT[3];
                break;
            case '4':
                return UserEnums::DEPARTMENT[4];
                break;
            case '5':
                return UserEnums::DEPARTMENT[5];
                break;
            case '6':
                return UserEnums::DEPARTMENT[6];
                break;
            default:
                break;
        }
    }

    // Hàm xử lí cho lấy trạng thái tài khoản người dụng
    public static function getStatusName($status)
    {
        switch ($status) {
            case '0':
                return  "<span class='text-danger'>" . UserEnums::STATUS[0] . "</span>";
                break;
            case '1':
                return "<span class='text-success'>" . UserEnums::STATUS[1] . "</span>";
                break;
            case '2':
                return "<span class='text-warning'>" . UserEnums::STATUS[2] . "</span>";
                break;
            default:
                break;
        }
    }
    // Hàm xử lí cho lấy trạng thái mượn trả sách
    public static function getStatusBorrowName($borrow)
    {
        switch ($borrow) {
            case '0':
                return UserEnums::STATUSBORROW[0];
                break;
            case '1':
                return UserEnums::STATUSBORROW[1];
                break;
            case '2':
                return UserEnums::STATUSBORROW[2];
                break;
            default:
                break;
        }
    }
    const DEFAULT_PAGE = 1;
}
