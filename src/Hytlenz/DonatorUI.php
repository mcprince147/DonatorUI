<?php

namespace Hytlenz;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use pocketmine\Server;

use Hytlenz\forms_by_jojoe\{SimpleForm, CustomForm};

class DonatorUI extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getLogger()->info("DonatorUI - Service Connected..");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        @mkdir($this->getDataFolder());
	$this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);

    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool
    {
        switch($cmd->getName()){
        case "donator":
        if(!($sender instanceof Player)){
        	if($sender->hasPermission("donator.ui")){
                $sender->addTitle($this->cfg->getNested("error.title"), $this->cfg->getNested("error.subtitle"));
                return true;
        }
    }
        $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$sender->addTitle("§bThank You", "§aFor Using.");
                        break;
                    case 1:
                    	$sender->setHealth($sender->getMaxHealth());
                    	$sender->setFood(20);
                    	$sender->sendMessage($this->cfg->getNested("cure.msg"));
                    	$sender->addTitle($this->cfg->getNested("cure.title"), $this->cfg->getNested("cure.subtitle"));
			break;
		    case 2:
		    	$sender->removeAllEffects();
		        $sender->sendMessage($this->cfg->getNested("effect.msg"));
                    	$sender->addTitle($this->cfg->getNested("effect.title"), $this->cfg->getNested("effect.subtitle"));
                        break;
                    case 3:
                    	$this->FlyUI($sender);
                        break;
                    case 4:
                    	$this->VanishUI($sender);
                        break;
                    case 5:
                    	$this->LightsUI($sender);
                        break;
                    case 6:
                    	$this->GmUI($sender);
                        break;
                    case 7:
                    	$this->NickMainUI($sender);
                        break;
		    case 8:
			$this->CrawlUI($sender);
			break;
		    case 9:
			$this->TimeSetUI($sender);
			break;
		    case 10:
			$this->SizeUI($sender);
			break;
            }
        });
        $form->setTitle($this->cfg->getNested("donator.title"));
        $form->setContent($this->cfg->getNested("donator.content"));
        $form->addButton("§4Exit");
        $form->addButton($this->cfg->getNested("cure.btn"), $this->cfg->getNested("cure.img-type"), $this->cfg->getNested("cure.img-url"));
	$form->addButton($this->cfg->getNested("effect.btn"), $this->cfg->getNested("effect.img-type"), $this->cfg->getNested("effect.img-url"));
        $form->addButton($this->cfg->getNested("fly.btn"), $this->cfg->getNested("fly.img-type"), $this->cfg->getNested("fly.img-url")); 
        $form->addButton($this->cfg->getNested("vanish.btn"), $this->cfg->getNested("vanish.img-type"), $this->cfg->getNested("vanish.img-url"));
        $form->addButton($this->cfg->getNested("lights.btn"), $this->cfg->getNested("lights.img-type"), $this->cfg->getNested("lights.img-url")); 
        $form->addButton($this->cfg->getNested("gm.btn"), $this->cfg->getNested("gm.img-type"), $this->cfg->getNested("gm.img-url"));
        $form->addButton($this->cfg->getNested("nick.btn"), $this->cfg->getNested("nick.img-type"), $this->cfg->getNested("nick.img-url"));
	$form->addButton($this->cfg->getNested("crawl.btn"), $this->cfg->getNested("crawl.img-type"), $this->cfg->getNested("crawl.img-url"));
	$form->addButton($this->cfg->getNested("time.btn"), $this->cfg->getNested("time.img-type"), $this->cfg->getNested("time.img-url"));
	$form->addButton($this->cfg->getNested("size.btn"), $this->cfg->getNested("size.img-type"), $this->cfg->getNested("size.img-url"));
	//Soon Capes, Wings, Particles etc.
        $form->sendToPlayer($sender);     
	
        }
        return true;
    }
    
     public function VanishUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
			$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
			$sender->setNameTagVisible(false);
			$sender->addTitle($this->cfg->getNested("vanish.title"), $this->cfg->getNested("vanish.on"));
                    	$sender->sendMessage($this->cfg->getNested("vanish.on"));
                        break;
                    case 2:
                    	$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
			$sender->setNameTagVisible(true);
			$sender->addTitle($this->cfg->getNested("vanish.title"), $this->cfg->getNested("vanish.off"));
                    	$sender->sendMessage($this->cfg->getNested("vanish.off"));
                        break;
                    	
            }
        });
        $form->setTitle($this->cfg->getNested("vanish.title-form"));
        $form->setContent($this->cfg->getNested("vanish.content"));
        $form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("ui.on.btn"), $this->cfg->getNested("ui.on.img-type"), $this->cfg->getNested("ui.on.img-url"));
	$form->addButton($this->cfg->getNested("ui.off.btn"), $this->cfg->getNested("ui.off.img-type"), $this->cfg->getNested("ui.off.img-url"));
        $form->sendToPlayer($sender);
        }
        
      public function LightsUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
			break;
                    case 1:
                    	$sender->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), 99999999, 0, false));
                    	$sender->addTitle($this->cfg->getNested("lights.title"), $this->cfg->getNested("lights.on"));
                    	$sender->sendMessage($this->cfg->getNested("lights.on"));
                        break;
                    case 2:
                    	$sender->removeEffect(Effect::NIGHT_VISION);
                    	$sender->addTitle($this->cfg->getNested("lights.title"), $this->cfg->getNested("lights.off"));
			$sender->sendMessage($this->cfg->getNested("lights.off"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("lights.title-form"));
        $form->setContent($this->cfg->getNested("lights.content"));
        $form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("ui.on.btn"), $this->cfg->getNested("ui.on.img-type"), $this->cfg->getNested("ui.on.img-url"));
	$form->addButton($this->cfg->getNested("ui.off.btn"), $this->cfg->getNested("ui.off.img-type"), $this->cfg->getNested("ui.off.img-url"));
        $form->sendToPlayer($sender);
        }
        
      public function FlyUI($sender){
      	$form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                     	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
			break;
                    case 1:
                    	$sender->setAllowFlight(true);
                    	$sender->sendMessage($this->cfg->getNested("fly.on"));
                    	$sender->addTitle($this->cfg->getNested("fly.title"), $this->cfg->getNested("fly.on"));
                        break;
                    case 2:
                    	$sender->setAllowFlight(false);
                    	$sender->sendMessage($this->cfg->getNested("fly.off"));
                    	$sender->addTitle($this->cfg->getNested("fly.title"), $this->cfg->getNested("fly.off"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("fly.title-form"));
        $form->setContent($this->cfg->getNested("fly.content"));
	$form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("ui.on.btn"), $this->cfg->getNested("ui.on.img-type"), $this->cfg->getNested("ui.on.img-url"));
	$form->addButton($this->cfg->getNested("ui.off.btn"), $this->cfg->getNested("ui.off.img-type"), $this->cfg->getNested("ui.off.img-url"));
        $form->sendToPlayer($sender);
        }
        
    public function GmUI($sender){
	$form = new CustomForm(function (Player $sender, $data){
        	if( !is_null($data)) {
                 switch($data[1]) {
                case 0:
                	$sender->setGamemode(Player::SURVIVAL);
                	$sender->sendMessage($this->cfg->getNested("gm.gms"));
                    	break;
                case 1:
                	$sender->setGamemode(Player::CREATIVE);
                	$sender->sendMessage($this->cfg->getNested("gm.gmc"));
                    	break;
                case 2:
                	$sender->setGamemode(Player::SPECTATOR);
                	$sender->sendMessage($this->cfg->getNested("gm.gmsp"));
                    	break;
               	default:
                   	return;
            }
  }

    });
    $form->setTitle($this->cfg->getNested("gm.title-form"));
    $form->addLabel($this->cfg->getNested("gm.content"));
    $form->addDropdown("Gamemodes", ["Survival", "Creative", "Spectator"]);
    $form->sendToPlayer($sender);
    }
    
    public function NickMainUI($sender){
      $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
                    	$this->NickUI($sender);
                        break;
                    case 2:
                    	$sender->setDisplayName($sender->getName());
                    	$sender->setNameTag($sender->getName());
                    	$sender->sendMessage($this->cfg->getNested("nick.reset"));
                        break;
            }
        });
        $form->setTitle($this->cfg->getNested("nickmain.title"));
        $form->setContent($this->cfg->getNested("nickmain.content"));
        $form->addButton($this->cfg->getNested("ui.back.btn"), $this->cfg->getNested("ui.back.img-type"), $this->cfg->getNested("ui.back.img-url"));
        $form->addButton($this->cfg->getNested("nickmain.edit.btn"), $this->cfg->getNested("nickmain.edit.img-type"), $this->cfg->getNested("nickmain.edit.img-url"));
        $form->addButton($this->cfg->getNested("nickmain.reset.btn"), $this->cfg->getNested("nickmain.reset.img-type"), $this->cfg->getNested("nickmain.reset.img-url"));
        $form->sendToPlayer($sender);
        }
     
    public function NickUI($sender){
	    $form = new CustomForm(function (Player $sender, $data){
                    if($data !== null){
			$sender->setDisplayName("#$data[1]");
			$sender->setNameTag("#$data[1]");
			$sender->sendMessage($this->cfg->getNested("nick.msg"));
			$sender->addTitle("§b#$data[1]","§aSet");
		}
	});
	$form->setTitle($this->cfg->getNested("nick.title-form"));
	$form->addLabel($this->cfg->getNested("nick.label"));
	$form->addInput("Put your nick name here:", "Nickname");
	$form->sendToPlayer($sender);
	}
// MAMAYA NA
    public function CrawlUI($sender){
      $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$this->getServer()->getCommandMap()->dispatch($sender, "donator");
                        break;
                    case 1:
                    	$sender->setCanClimbWalls(true);
                    	$sender->sendMessage($this->cfg->getNested("crawl.on"));
                    	$sender->addTitle();
                        break;
                    case 2:
                    	$sender->setCanClimbWalls(false);
                    	$sender->sendMessage($this->cfg->getNested("crawl.off"));
                    	$sender->addTitle();
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("crawl.title"));
        $form->setContent($this->getConfig()->get("crawl.content"));
        $form->addButton("§lBack");
        $form->addButton("§l§2On");
        $form->addButton("§l§4Off");
        $form->sendToPlayer($sender);
       }
	
	public function TimeSetUI($sender){
	    $form = new CustomForm(function (Player $sender, $data){
              if( !is_null($data)) {
                 switch($data[1]) {
               	case 0:
                	$sender->getLevel()->setTime(0);
                	$sender->addTitle("§bDay", "§aTime");
                	$sender->sendMessage($this->getConfig()->get("time.day"));
                    	break;
                case 1:
			$sender->getLevel()->setTime(15000);
                	$sender->addTitle("§bNight", "§aTime");
                	$sender->sendMessage($this->getConfig()->get("time.night"));
                    	break;
               default:
                   return;
            }
    }

    });
    $form->setTitle($this->getConfig()->get("time.title"));
    $form->addLabel($this->getConfig()->get("time.content"));
    $form->addDropdown("Time Set", ["Day", "Night"]);
    $form->sendToPlayer($sender);
    }
	
	public function SizeUI($sender){
      	  $form = new SimpleForm(function (Player $sender, $data){
            $result = $data;
            if ($result == null) {
            }
            switch ($result) {
                    case 0:
                    	$command = "donator" ;
                    	$this->getServer()->getCommandMap()->dispatch($sender, $command);
                        break;
                    case 1:
                    	$sender->setScale(0.4);
                    	$sender->sendMessage($this->getConfig()->get("size.baby"));
                    	$sender->addTitle("§bBaby", "§aSize!");
                        break;
                    case 2:
                    	$sender->setScale(0.6);
                    	$sender->sendMessage($this->getConfig()->get("size.kid"));
                    	$sender->addTitle("§bKid", "§aSize!");
                        break;
		    case 3:
                    	$sender->setScale(0.8);
                    	$sender->sendMessage($this->getConfig()->get("size.teen"));
                    	$sender->addTitle("§bTeen", "§aDisabled!");
                        break;
		    case 4:
                    	$sender->setScale(1.0);
                    	$sender->sendMessage($this->getConfig()->get("size.default"));
                    	$sender->addTitle("§bDefault", "§aSize!");
                        break;
		    case 5:
                    	$sender->setScale(1.5);
                    	$sender->sendMessage($this->getConfig()->get("size.giant"));
                    	$sender->addTitle("§bGiant", "§aSize!");
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("size.title"));
        $form->setContent($this->getConfig()->get("size.content"));
        $form->addButton("§lBack");
	$form->addButton("§lBaby");
        $form->addButton("§lKid");
        $form->addButton("§lTeen");
	$form->addButton("§lDefault");
	$form->addButton("§lGiant");
        $form->sendToPlayer($sender);
       }

    public function onDisable(){
        $this->getLogger()->info("DonatorUI - Service Disconnected..");
    }
}
