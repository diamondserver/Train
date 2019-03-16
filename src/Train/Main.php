<?php

namespace Train;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\level\Position;

class Main extends PluginBase implements Listener{

	public $n = 1;
	
	public function onEnable()
	{
     $this->getServer()->getPluginManager()->registerEvents($this,$this);
	}
   
}