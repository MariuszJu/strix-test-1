<?php

namespace StrixTask\Model\Helper;

final class Runtime
{

    private function __clone() {}
    private function __construct() {}
    private function __wakeup() {}

    /**
     * @return bool
     */
    public static function isCommandLineInterface()
    {
        if (strcasecmp(php_sapi_name(), 'cli') === 0) {
            return true;
        }
        if (defined('STDIN')) {
            return true;
        }
        if (array_key_exists('SHELL', $_ENV)) {
            return true;
        }
        if (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0) {
            return true;
        }
        if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public static function sapiName()
    {
        return strtolower(php_sapi_name());
    }

    /**
     * @return bool
     */
    public static function isWindows()
    {
        return strpos(self::os(), 'win') !== false;
    }

    /**
     * @return bool
     */
    public static function isLinux()
    {
        return strpos(self::os(), 'linux') !== false;
    }

    /**
     * @return string
     */
    public static function os()
    {
        return strtolower(PHP_OS);
    }

    /**
     * @return int
     */
    public static function maxUploadFileSize()
    {
        return max((int) ini_get('post_max_size'), (int) ini_get('upload_max_filesize'));
    }


}
