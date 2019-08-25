<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2017/6/15
 * Time: 13:59
 */

use Psr\Log\LoggerInterface;
class Log implements  LoggerInterface
{
    const LOG    = 'log';
    const ERROR  = 'error';
    const INFO   = 'info';
    const SQL    = 'sql';
    const NOTICE = 'notice';
    const ALERT  = 'alert';
    const DEBUG  = 'debug';

    static private $logger;


    /**
     * Log constructor.
     * @param $logger
     */
    public function __construct()
    {

    }

    /**
     * 错误信息
     * @param $message
     */
    public static function ERR($message){
        $str ="[". date("Y-m-d H:i:s") ."]" .Log::ERROR.":$message". PHP_EOL;
        file_put_contents(APP_PATH."Log/log.txt", $str,FILE_APPEND);
    }

    /**
     * 实时写入日志
     */
    public static function write($message,$type='log',$force=false){
        if ($force){
            //
        }else{
            $str ="[". date("Y-m-d H:i:s") ."]" .$type.":$message". PHP_EOL;
            file_put_contents(APP_PATH."Log/log.txt", $str,FILE_APPEND);
        }

    }


    /**
     * 日志会缓存一段时间,然后批量写入
     */
    public static function record($message,$type='log'){

    }


    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        // TODO: Implement emergency() method.
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        // TODO: Implement error() method.
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        // TODO: Implement warning() method.
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        // TODO: Implement notice() method.
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        // TODO: Implement info() method.
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        // TODO: Implement debug() method.
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}