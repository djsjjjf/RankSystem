<?php


namespace RankSystem\listener;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;

use RankSystem\RankSystem;

class EventListener implements Listener
{
	
	protected $plugin = null;
	
	
	public function __construct (RankSystem $plugin)
	{
		$this->plugin = $plugin;
	}
	
	public function onJoin (PlayerJoinEvent $event): void
	{
		$player = $event->getPlayer ();
		$name = $player->getName ();
		if (\Sjob\JobAPI::isPlayerData ($name)) {
  	if ($this->plugin->addPlayerData ($name)) {
			$player->sendPopup ("");
}
		}
	}
}