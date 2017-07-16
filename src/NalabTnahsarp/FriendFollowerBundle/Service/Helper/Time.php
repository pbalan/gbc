<?php
namespace NalabTnahsarp\FriendFollowerBundle\Service\Helper;

/**
 * Class Time
 * @package NalabTnahsarp\FriendFollowerBundle\Service\Helper
 */
class Time
{
    const TIME_FORMAT_DATE = 'Y-m-d';
    const TIME_FORMAT_DATETIME = 'Y-m-d h:i:s';
    const TIME_TIMEZONE_UTC = 'UTC';

    /**
     * @return \DateTime
     */
    public static function getUtcTime()
    {
        $date = new \DateTime('now', new \DateTimeZone(self::TIME_TIMEZONE_UTC));
        return $date;
    }
}
