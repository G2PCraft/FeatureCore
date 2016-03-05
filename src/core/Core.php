<?php

  /////////////
 //NOT READY//
/////////////
namespace FeatureCore;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Plugin;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\Server;

class Core extends PluginBase implements Listener{
	
	private $inGame = [];
	private $players = [];
	private $removep = [];
	
	public function OnEnable(){
		$tt = array();
		$time=0;
		$this->players=array();
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		$this->getLogger()->info(TextFormat::GOLD."FEATURECORE HAS BEEN ENABLED!");
		@mkdir($this->getDataFolder());
		$config = new Config($this->plugin->getDataFolder() . "config.yml");
		$messages = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML)
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallBackTask([$this, "game"]), 20);
		if(!$config->exists("prefix")){
			$config->set("prefix","Game");
			$config->set("time",120);
			$config->set("language","tr");
			$config->set("pos1",0);
			 $config->set("pos2",0);
			 $config->set("pos3",0);
			 $config->set("pos4",0);
			 $config->set("pos5",0);
			 $config->set("pos6",0);
			 $config->set("pos7",0);
			 $config->set("pos8",0);
		}
		if($messages->exists("messages:")){
			$messages->set("messages:");
			$messages->set("seconds", "saniye");
			 $messages->set("gamestarted", "Oyun Başladı!");
			 $messages->set("gamefinished", "Oyun Bitti.");
			 $messages->set("youarespectator", "İzleyici Moduna Gecildi!");
			 $messages->set("endingseconds", "saniye..");
			 $messages->set("youdeath", "Öldün.");
			 $messages->set("exitgame", "Oyundan Çıkılıyor..");
			 $messages->set("moreplayers", "Daha Fazla Oyuncu Gerekli");
		}
		$messages->save();
		$config->save();
	}
	
	public function OnDisable(){
		$this->getServer()->getLogger()->info("§cFeatureCore is Has Been Disabled!");
		$this->getLogger()->info("§7ConfigKaydediliyor..");
		$this->config->save;
		$this->getLogger()->info("§dConfig Kaydedildi!");
		$time=0;
		$this->players=array();
	}
	
	public function game(){
		foreach($this->players as $p){
			$p=$this->getServer()->getPlayer();
			if(count($this->players)<=1){
				$playerlang = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
			  $lang = new Config($this->plugin->getDataFolder() . "/lang.yml", Config::YAML);
			  $toUse = $lang->get($playerlang->get($p->getName()));
			  $p->sendPopUp(TextFormat::GOLD. "" .$toUse["moreplayers"]);
			}
			if(count($this->players)>=1){
				$time--;
				$time=120;
				$playermsg = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
			  $lang = new Config($this->plugin->getDataFolder() . "/lang.yml", Config::YAML);
				$toUse = $lang->get($playerlang->get($p->getName()));
				$p->sendTip(TextFormat::YELLOW . $time . " " . $toUse["seconds"]);
				if($time = 0){
					$p->sendMessage(TextFormat::GREEN. " " .$toUse["gamestarted"]);
				}
			}
		}
	}
}
?>
