<?php

namespace Plate\RankShop;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use onebone\economyapi\EconomyAPI;

class Main extends PluginBase {

	public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {

		switch($cmd->getName()){
			case "rankshop":
			 if($sender instanceof Player){
			 	$this->rankUI($sender);
			 } else {
			 	$sender->sendMessage("What?");
			 }
			break;
		}
		return true;
	}

	public function rankUI($player){
		$form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function(Player $player, int $data = null){

			if($data === null){
				return true;
			}
			$money = EconomyAPI::getInstance()->myMoney($player);
			$papi = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
			$a = $papi->getGroup("VIP");
			$b = $papi->getGroup("MVP");
			$c = $papi->getGroup("UWU");
			switch($data){
				case 0:
					$papi = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
					$a = $papi->getGroup("VIP");
					$money = EconomyAPI::getInstance()->myMoney($player);
					if($money >= 110000){
						EconomyAPI::getInstance()->reduceMoney($player, "110000");
						$papi->setGroup($player, $a);
						$player->sendMessage("Purchase complete UwU enjoy your rank yay");
						$player->addTitle("Purchase!!!!", "You have been purchase VIP rank yay");
					} else {
						$player->sendMessage(" §9> §cYour money isnt enough yet.");
					}
				break;

				case 1:
				 if($money >= 6000){
				 	$papi->setGroup($player, $b);
				 	$player->addTitle("Purchase!!!!", "You have been purchase MVP rank yay");
				 	$player->sendMessage("Purchase complete UwU enjoy your rank yay");
				 } else {
				 	$player->sendMessage("Not enough money you need 6000 uwu");
				 }
				break;

				case 2:
				 if($money >= 9000){
				 	$papi->setGroup($player, $c);
				 	$player->addTitle("Purchase!!!!", "You have been purchase UWU rank yay");
				 	$player->sendMessage("Purchase complete UwU enjoy your rank yay");
				 } else {
				 	$player->sendMessage("Not enough money you need 9000 uwu");
				 }
				break;
			}
		});
		$form->setTitle("RankSHOP");
		$form->addButton("VIP RANK");
		$form->addButton("MVP RANK");
		$form->addButton("UWU RANK");
		$form->sendToPlayer($player);
		return $form;
	}

}