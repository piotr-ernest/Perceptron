<?php

/**
 * Description of HandleRequest
 *
 * @author rnest
 */
require 'DBHandler.php';

class HandleRequest
{

    protected static $details;

    public static function handle()
    {
        try {
            $ip = $_SERVER['REMOTE_ADDR'];
            self::$details = $details = (array) json_decode(file_get_contents('http://ipinfo.io/' . $ip . '/json'));

            @$db = new DBHandler('localhost', 'root', '', 'hebbs');
            $db->setTable('visitors');
            @$db->insert($details);
        } catch (Exception $ex) {
            
        }
    }

}
