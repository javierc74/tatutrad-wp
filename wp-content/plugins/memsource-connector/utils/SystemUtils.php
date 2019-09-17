<?php

namespace Memsource\Utils;


use ZipArchive;

class SystemUtils {

    const LOG_FILE_NAME = 'memsource.log';
    const ZIP_FILE_NAME = 'memsource.log.zip';
    const LOG_EMAIL_RECIPIENT = 'integrations@memsource.com';

    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARN = 'WARN';
    const ERROR = 'ERROR';

    const kB = 1024;
    const MB = 1048576;
    const GB = 1073741824;

    public static function getUpdateFolder($type) {
        return MEMSOURCE_PLUGIN_PATH . '/' . $type;
    }

    public static function getLogFilePath() {
        return MEMSOURCE_PLUGIN_PATH . '/' . self::LOG_FILE_NAME;
    }

    public static function getZipFilePath() {
        return MEMSOURCE_PLUGIN_PATH . '/' . self::ZIP_FILE_NAME;
    }

    public static function debug($message) {
        self::log(self::DEBUG, $message);
    }

    public static function info($message) {
        self::log(self::INFO, $message);
    }

    public static function warn($message) {
        self::log(self::WARN, $message);
    }

    public static function error($message) {
        self::log(self::ERROR, $message);
    }

    public static function log($level, $message) {
        global $appRegistry;
        if ($appRegistry->getOptions()->isDebugMode()) {
            $file = self::getLogFilePath();
            file_put_contents($file, '[' . date('r') . '] ' . $level . ' ', FILE_APPEND | LOCK_EX);
            file_put_contents($file, $message . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    public static function getLogFileSize() {
        $log_file = self::getLogFilePath();
        return file_exists($log_file) ? filesize($log_file) : 0;
    }

    public static function getLogFileSizeFormatted() {
        $size = self::getLogFileSize();
        if ($size) {
            if ($size > self::GB) {
                return number_format($size / self::GB, 2) . ' GB';
            } else if ($size > self::MB) {
                return number_format($size / self::MB, 2) . ' MB';
            } else if ($size > self::kB) {
                return number_format($size / self::kB, 2) . ' kB';
            } else {
                return $size . " bytes";
            }
        }
        return 0;
    }

    public static function zipAndEmailLogFile() {
        $log_file = self::getLogFilePath();
        $zip_file = self::getZipFilePath();
        $zip = new ZipArchive();
        if ($zip->open($zip_file, ZipArchive::CREATE)) {
            $zip->addFile($log_file, self::LOG_FILE_NAME);
            $zip->close();
            wp_mail(self::LOG_EMAIL_RECIPIENT,
                'Memsource plugin log file from ' . get_site_url(),
                'Memsource plugin log file from ' . get_site_url(),
                [],
                [$zip_file]);
            return self::ZIP_FILE_NAME;
        }
        return null;
    }

    public static function deleteLogFile() {
        $log_file = self::getLogFilePath();
        $zip_file = self::getZipFilePath();
        $log_deleted = file_exists($log_file) ? unlink($log_file) : false;
        $zip_deleted = file_exists($zip_file) ? unlink($zip_file) : false;
        $result = [];
        if ($log_deleted) {
            $result['logDeleted'] = self::LOG_FILE_NAME;
        }
        if ($zip_deleted) {
            $result['zipDeleted'] = self::ZIP_FILE_NAME;
        }
        return $result;
    }

    public static function logSystemInfo() {
        $wpmlPluginFile = ABSPATH . '/wp-content/plugins/sitepress-multilingual-cms/sitepress.php';

        $systemData = [
            'Memsource Connector Plugin Version' => MEMSOURCE_PLUGIN_VERSION,
            'WPML Version' => file_exists($wpmlPluginFile) ? get_plugin_data($wpmlPluginFile)['Version'] : 'unknown',
            'Wordpress Version' => get_bloginfo('version'),
            'PHP Version' => PHP_VERSION,
            'Server Software' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'unknown',
            'Installed PHP Extensions' => get_loaded_extensions(),
        ];

        self::info("Installed tools:\n" . json_encode($systemData, JSON_PRETTY_PRINT));
    }
}