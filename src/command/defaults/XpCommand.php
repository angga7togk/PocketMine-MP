<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class XpCommand extends Command{

	public function __construct(){
		parent::__construct("xp", "Xp Command", "/xp help", ["lv"]);
		$this->setPermission("pocketmine.command.xp");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!isset($args[0])){
			$sender->sendMessage(self::getUsage());
			return false;
		}

		switch(strtolower($args[0])){
			case "help":
				$sender->sendMessage(
					TextFormat::GREEN."===== XP HELP =====\n".
					"/xp help\n".
					"/xp add <name> <xp>\n".
					"/xp reduce <name> <xp>"
				);
				break;
			case "add":
				if(!isset($args[1]) || !isset($args[2])){
					$sender->sendMessage("usage: /xp add <name> <xp>");
					return false;
				}

				if(!is_numeric($args[2])){
					$sender->sendMessage("please enter a number!");
					return false;
				}

				$player = Server::getInstance()->getPlayerByPrefix($args[1]) ?? Server::getInstance()->getPlayerExact($args[1]);
				$xp = (int) $args[2];

				if($player == null){
					$sender->sendMessage("player is not found!");
					return false;
				}
				$player->getXpManager()->addXp($xp);
				$sender->sendMessage("add xp ".$player->getName()." $xp");
				break;
			case "reduce":
				if(!isset($args[1]) || !isset($args[2])){
					$sender->sendMessage("usage: /xp reduce <name> <xp>");
					return false;
				}

				if(!is_numeric($args[2])){
					$sender->sendMessage("please enter a number!");
					return false;
				}

				$player = Server::getInstance()->getPlayerByPrefix($args[1]) ?? Server::getInstance()->getPlayerExact($args[1]);
				$xp = (int) $args[2];

				if($player == null){
					$sender->sendMessage("player is not found!");
					return false;
				}

				if($player->getXpManager()->getCurrentTotalXp() <= $xp){
					$sender->sendMessage("less xp player");
					return false;
				}

				$player->getXpManager()->subtractXp($xp);
				$sender->sendMessage("reduce xp ".$player->getName()." $xp");
				break;
		}

		return true;
	}
}
