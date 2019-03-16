<?php

namespace Train;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

	public $n = 1;
	
	public function onEnable()
	{
     $this->getServer()->getPluginManager()->registerEvents($this,$this);
		if(!file_exists($this->getDataFolder()))
		{
			@mkdir($this->getDataFolder(), 0744, true);
		}
		$this->ts = new Config($this->getDataFolder() . "TrainS.yml", Config::YAML, array(
			'1' => '座標',
			'2' => '座標'
		));
		$this->te = new Config($this->getDataFolder() . "TrainE.yml", Config::YAML, array(
			'1' => '座標',
			'2' => '座標'
		));
		$this->tx = new Config($this->getDataFolder() . "TrainX.yml", Config::YAML, array(
			'1' => '座標',
			'2' => '座標'
		));
		$this->pn = new Config($this->getDataFolder() . "Player.yml", Config::YAML);

		//late

		$players = Server::getInstance()->getOnlinePlayers();
		foreach ($players as $p) {

			$name = $p->getName();

			$tspos = $this->ts->get("".$this->n.""); //Configより電車の片端の座標取得
			$spos = explode(",", $tspos); //各座標ごとに分割
			$x1 = (Int)$spos[1]; //Int型に変換
			$y1 = (Int)$spos[2];
			$z1 = (Int)$spos[3];

			$tepos = $this->te->get("".$this->n.""); //Configより電車の片端の座標取得
			$epos = explode(",", $tepos); //各座標ごとに分割
			$x2 = (Int)$epos[1]; //Int型に変換
			$y2 = (Int)$epos[2];
			$z2 = (Int)$epos[3];

			$txpos = $this->tx->get("".$this->n.""); //Configより中継電車の座標取得
			$xpos = explode(",", $txpos); //各座標ごとに分割
			$x3 = (Int)$xpos[1]; //Int型に変換
			$y3 = (Int)$xpos[2];
			$z3 = (Int)$xpos[3];

			$i = $this->n + 1;

			$ts2pos = $this->ts->get("".$i.""); //Configより電車の片端の座標取得
			$s2pos = explode(",", $ts2pos); //各座標ごとに分割
			$x4 = (Int)$s2pos[1]; //Int型に変換
			$y4 = (Int)$s2pos[2];
			$z4 = (Int)$s2pos[3];

			$px = $p->getX();
			$py = $p->getY();
			$pz = $p->getZ();

			if($x1<=$px && $x2>=$px && $z1>=$pz && $z2<=$pz)
			{
				$poss = new Position($x3, $y3, $z3, "town");
				$p->teleport($poss);
				$this->pn->set($name, "in");
				$this->pn->save();
			}

			//late

			if($this->pn->exists($name)){
				$pose = new Position($x4, $y4, $z4, "town");
				$p->teleport($pose);
				$this->pn->remove($name);
				$this->pn->save();
			}

			if($this->ts->exists($i)){
				$this->n++;
			}else{
				$this->n = 1;
			}

		}
	}
   
}
