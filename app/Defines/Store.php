<?php

namespace App\Define;

Class Store {
    const STATUS_WAITING 	= "WAITING";
    const STATUS_CANCELED 	= "CANCELED";
    const STATUS_PROCESSING = "PROCESSING";
    const STATUS_COMPLETED 	= "COMPLETED";

    public static function getLabelStatus($status)
    {
        switch ($status) {
            case self::STATUS_WAITING:
                return 'info';
            case self::STATUS_CANCELED:
                return 'danger';
            case self::STATUS_PROCESSING:
                return 'warning';
            case self::STATUS_COMPLETED:
                return 'success';
            default:
                return 'info';
        }
        return [self::STATUS_WAITING, self::STATUS_CANCELED, self::STATUS_PROCESSING, self::STATUS_COMPLETED];
    }

    public static function getAllStatus()
    {
        return [self::STATUS_WAITING, self::STATUS_CANCELED, self::STATUS_PROCESSING, self::STATUS_COMPLETED];
    }

    public static function getAllStatusForOptions()
    {
        return [self::STATUS_WAITING => trans("stores.status.". self::STATUS_WAITING), self::STATUS_CANCELED => trans("stores.status.". self::STATUS_CANCELED), self::STATUS_PROCESSING => trans("stores.status.". self::STATUS_PROCESSING), self::STATUS_COMPLETED => trans("stores.status.". self::STATUS_COMPLETED)];
    }

	public static function getStatusByRole()
    {
        return [self::STATUS_WAITING, self::STATUS_PROCESSING, self::STATUS_COMPLETED];
    }

    public static function getStatusByRoleForOptions()
    {
        return [self::STATUS_WAITING => trans("stores.status.". self::STATUS_WAITING), self::STATUS_PROCESSING => trans("stores.status.". self::STATUS_PROCESSING), self::STATUS_COMPLETED => trans("stores.status.". self::STATUS_COMPLETED)];
    }
}
