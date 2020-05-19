<?php 


class System 
{
    // objects array
    private static $objects = [];

    /**
     * store objects
     * @param type $index
     * @param type $val
     * 
     */
    public static function Store($index,$val)
    {
        self::$objects[$index] = $val;
    }

    /**
     * get specific object
     * @param $index
     * return type 
     */
    public static function Get($index)
    {
        return self::$objects[$index];
    }
}