<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRoleEnum extends Enum
{
    public const USER = 1;
    public const MANAGER = 2;
    public const ADMIN = 3;

    public static function getDescriptions()
    {
        return [
            self::USER => 'Người dùng',
            self::MANAGER => 'Quản lý',
            self::ADMIN => 'Admin'
        ];
    }
}


