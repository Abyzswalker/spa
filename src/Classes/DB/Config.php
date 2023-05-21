<?php

namespace Abyzs\Spa\Classes\DB;

class Config
{
    public static function get(): array
    {
        if (file_exists(realpath('config.ini'))) {
            return parse_ini_file(realpath('config.ini'), true);
        } else {
            return [];
        }
    }
}