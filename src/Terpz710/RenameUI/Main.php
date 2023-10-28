<?php

namespace Terpz710\RenameUI;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use Terpz710\RenameUI\Command\RenameCommand;

class Main extends PluginBase {
    public function onEnable(): void {
        $this->getServer()->getCommandMap()->register("rename", new RenameCommand($this->getServer()->getPluginManager()->getPlugin("FormAPI")));
    }
}
