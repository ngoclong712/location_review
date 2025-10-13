<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserStatusEnum extends Enum
{
    public const UNVERIFIED = 0;
    public const VERIFIED = 1;
    public const SUSPENDED = 2;
    public const BLOCKED = 3;
    public const DELETED = 4;

    public static function getDescriptions()
    {
        return [
            self::UNVERIFIED => 'Chưa xác minh',
            self::VERIFIED => 'Đã xác minh',
            self::SUSPENDED => 'Tạm khoá',
            self::BLOCKED => 'Bị cấm vĩnh viễn',
            self::DELETED => 'Đã xoá',
        ];
    }
}
