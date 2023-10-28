<?php

namespace Terpz710\RenameUI\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

class RenameCommand extends Command {
    public function __construct() {
        parent::__construct("rename", "Rename an item", "/rename");
        $this->setPermission("renameui.cmd");
    }

    public function execute(CommandSender $sender, string $label, array $args) {
        if ($sender instanceof Player) {
            $this->sendRenameForm($sender);
        }
    }

    public function sendRenameForm(Player $player) {
        $form = new SimpleForm(function (Player $player, ?int $data = null) {
            if ($data === null) return;
            if ($data === 0) {
                $this->sendCustomRenameForm($player);
            }
        });

        $form->setTitle("Rename Item");
        $form->setContent("Click the button to rename the item.");
        $form->addButton("Rename");
        $form->sendToPlayer($player);
    }

    public function sendCustomRenameForm(Player $player) {
        $form = new CustomForm(function (Player $player, ?array $data = null) {
            if ($data === null) return;
            $newName = $data["new_name"];
            if (!empty($newName)) {
                $this->renameItem($player, $newName);
            } else {
                $player->sendMessage("Please enter a valid name to rename the item.");
            }
        });

        $form->setTitle("Rename Item");
        $form->addInput("New Name", "Enter the new name here", "", "new_name");
        $form->sendToPlayer($player);
    }

    public function renameItem(Player $player, string $itemName) {
        $inventory = $player->getInventory();
        $heldItem = $inventory->getItemInHand();
        $heldItem->setCustomName($itemName);
        $inventory->setItemInHand($heldItem);
        $player->sendMessage("Item renamed to $itemName");
    }
}
