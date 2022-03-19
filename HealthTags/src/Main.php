<?php

declare(strict_types=1);

namespace ryo5828\HealthTags;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;

class Main extends PluginBase implements Listener
{
    /** Plugin有効時 */
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    /** server入室時 */
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $this->setHealthTag($player);
    }
    /** リスポーン時 */
    public function Respawn(PlayerRespawnEvent $event)
    {
        $player =$event->getPlayer();
        $this->setHealthTag($player);
    }

    /** Damageを受けた時 */
    public function onEntityDamege(EntityDamageEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) { // Playerならば
            $player = $entity->getPlayer();
            $this->setHealthTag($player);
        }
    }
    /** 回復した時 */
    public function RegainHealth(EntityRegainHealthEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) { // Playerならば
            $this->setHealthTag($entity);
        }
    }

    /** ネームタグをセット */
    public function setHealthTag($player)
    {
        $name = $player->getName();
        $health = $player->getHealth();
        $maxHealth = $player->getmaxHealth();
        $front = $this->getConfig()->get("front");
        $center = $this->getConfig()->get("center");
        $back = $this->getConfig()->get("back");
        $player->setNametag($name."\n".$front."".$health."".$center."".$maxHealth."".$back.""); // \nで改行しconfigで設定した値をセット
    }
}
