<?php

/*

$$$$$$$$\  $$$$$$\   $$$$$$\  $$\   $$\  $$$$$$\  $$$$$$$\ $$$$$$\ 
\__$$  __|$$  __$$\ $$  __$$\ $$ | $$  |$$  __$$\ $$  __$$\\_$$  _|
   $$ |   $$ /  $$ |$$ /  \__|$$ |$$  / $$ /  $$ |$$ |  $$ | $$ |  
   $$ |   $$$$$$$$ |\$$$$$$\  $$$$$  /  $$$$$$$$ |$$$$$$$  | $$ |  
   $$ |   $$  __$$ | \____$$\ $$  $$<   $$  __$$ |$$  ____/  $$ |  
   $$ |   $$ |  $$ |$$\   $$ |$$ |\$$\  $$ |  $$ |$$ |       $$ |  
   $$ |   $$ |  $$ |\$$$$$$  |$$ | \$$\ $$ |  $$ |$$ |     $$$$$$\ 
   \__|   \__|  \__| \______/ \__|  \__|\__|  \__|\__|     \______|

   製作者: vardo
   Twitter: @o10ri3_

*/

namespace taskapi;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class Plan
{ 
    const ESSENTIAL_FILE = "TASKAPI_BY_VARDO.txt";

    public static $accept = false;
    public static $instance;
    public static $filePath;
    public static $worker=[];

    static function register(PluginBase $plugin)
    {
        self::$accept = true;
    }

    static function repeat(string $marker, array $array=[], int $every=1*20, ?string $path=null) : bool
    {
        if (!(self::$accept)) return false;
        if (self::exsist($marker)) return false;
        if ($path == null) {
            $path = self::$filePath;
        } else {
            $path = self::$filePath.$path;
        }
        $class = self::$filePath.$marker;
        $task = new $class(...$array);
        self::$instance->getScheduler()->scheduleRepeatingTask($task, $every);
        self::$worker[$marker] = $task;
        return true; 
    }

    static function delay(string $marker, array $array=[], int $delayTime, ?string $path=null) : bool
    {
        if (!(self::$accept)) return false;
        if (self::exsist($marker)) return false;
        if ($path == null) {
            $path = self::$filePath;
        } else {
            $path = self::$filePath.$path;
        }
        $class = self::$path.$marker;
        $task = new $class(...$array);
        self::$instance->getScheduler()->scheduleDelayedTask($task, $delayTime);
        self::$worker[$marker] = $task;
        return true; 
    }

    static function stop(string $marker) : bool
    {
        if (!(self::$accept)) return false;
        if (!(self::exsist($marker))) return false;
        $task = self::get($marker);
        $task->getHandler()->cancel();
        unset(self::$worker[$marker]);
        return true; 
    }

    static function exsist(string $marker) : bool
    {
        if (!(self::$accept)) return false;
        return (isset(self::$worker[$marker]));
    }

    static function get(string $marker) : ?Task
    {
        if (!(self::$accept)) return null;
        if (!(self::exsist($marker))) return null;
        return self::$worker[$marker];
    }

}