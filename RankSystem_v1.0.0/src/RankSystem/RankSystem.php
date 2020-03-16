<?php


namespace RankSystem;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;

use RankSystem\listener\EventListener;

use SJob\JobAPI;

class RankSystem extends PluginBase
{
	
	private static $instance = null;
	
	public static $prefix = "§l§b[알림]§r§7 ";
	
	public $config, $db;
	
	protected $arr1 = [
		"삼등병" => 0,
		"이등병" => 300,
		"일등병" => 600,
		"하사" => 900,
		"중사" => 1400,
		"상사" => 2100,
		"소위" => 2800,
		"중위" => 3800,
		"대위" => 4900,
		"소령" => 6600,
		"중령" => 8800,
		"대령" => 11600,
		"준장" => 15100,
		"소장" => 19600,
		"중장" => 25200,
		"대장" => 41300,
		"원수" => 67100,
		"해군" => 108300
	];
	
	protected $arr2 = [
		"혁명군" => 0,
		"지부 간부" => 4900,
		"지부 사령관" => 8800,
		"간부" => 25200,
		"군대장" => 41300,
		"참모총장" => 67100,
		"총사령관" => 108300
	];
	
	protected $arr3 = [
		"해적" => 0,
		"흉악범" => 1600,
		"루키" => 4900,
		"슈퍼루키" => 15100,
		"초신성" => 25200,
		"사황" => 52700,
		"해적왕" => 108300
	];
	
	protected $arr4 = [
		"CP-1" => 0,
		"CP-2" => 400,
		"CP-3" => 900,
		"CP-4" => 1600,
		"CP-5" => 2400,
		"CP-6" => 4900,
		"CP-7" => 8800,
		"CP-8" => 15100,
		"CP-9" => 67100,
		"CP-0" => 108300
	];
	
	
	public static function getInstance (): RankSystem
	{
		return self::$instance;
	}
	
	public function onLoad (): void
	{
		if (self::$instance === null)
			self::$instance = $this;
	}
	
	public function onEnable (): void
	{
		if (!file_exists ($this->getDataFolder ())) {
			@mkdir ($this->getDataFolder ());
		}
		$this->config ["rank"] = new Config ($this->getDataFolder () . "rank.yml", Config::YAML, [
			"해군" => [
				"전군 총수" => [
					"player" => [],
					"max" => 1
				],
				"원수" => [
					"player" => [],
					"max" => 1
				],
				"대장" => [
					"player" => [],
					"max" => 3
				],
				"중장" => [
					"player" => [],
					"max" => 7
				],
				"대령" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"중령" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"소령" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"대위" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"중위" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"소위" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"상사" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"중사" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"하사" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"일등병" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"이등병" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"삼등병" => [
					"player" => [],
					"max" => PHP_INT_MAX
				]
			],
			"혁명군" => [
				"총사령관" => [
					"player" => [],
					"max" => 1
				],
				"참모총장" => [
					"player" => [],
					"max" => 1
				],
				"군대장" => [
					"player" => [],
					"max" => 4
				],
				"간부" => [
					"player" => [],
					"max" => 5
				],
				"지부장 사령관" => [
					"player" => [],
					"max" => 3
				],
				"지부장 간부" => [
					"player" => [],
					"max" => 10
				],
				"혁명군" => [
					"player" => [],
					"max" => PHP_INT_MAX
				]
			],
			"해적" => [
				"해적왕" => [
					"player" => [],
					"max" => 1
				],
				"사황" => [
					"player" => [],
					"max" => 4
				],
				"초신성" => [
					"player" => [],
					"max" => 5
				],
				"슈퍼루키" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"흉악범" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"해적" => [
					"player" => [],
					"max" => PHP_INT_MAX
				]
			],
			"싸이퍼폴" => [
				"CP-0" => [
					"player" => [],
					"max" => 5
				],
				"CP-9" => [
					"player" => [],
					"max" => 7
				],
				"CP-8" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-7" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-8" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-7" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-6" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-5" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-4" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-3" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-2" => [
					"player" => [],
					"max" => PHP_INT_MAX
				],
				"CP-1" => [
					"player" => [],
					"max" => PHP_INT_MAX
				]
			]
		]);
		$this->db ["rank"] = $this->config ["rank"]->getAll ();
		$this->config ["player"] = new Config ($this->getDataFolder () . "player.yml", Config::YAML);
		$this->db ["player"] = $this->config ["player"]->getAll ();
		$this->getServer ()->getPluginManager ()->registerEvents (new EventListener ($this), $this);
	}
	
	public function onDisable (): void
	{
		if ($this->config ["rank"] instanceof Config) {
			$this->config ["rank"]->setAll ($this->db ["rank"]);
			$this->config ["rank"]->save ();
		}
		if ($this->config ["player"] instanceof Config) {
			$this->config ["player"]->setAll ($this->db ["player"]);
			$this->config ["player"]->save ();
		}
	}
	
	public function getRank (string $name): string
	{
		if (isset ($this->db ["player"] [$name])) {
			return $this->db ["player"] [$name] ["rank"];
		}
		return "알 수 없음";
	}
	
	public function getPoint (string $name): int
	{
		return isset ($this->db ["player"] [$name]) ? (int) $this->db ["player"] [$name] ["point"] : 0;
	}
	
	public function getSearchIndex (string $name, array $arr): int
	{
		$index = -1;
		foreach (array_keys ($arr) as $search) {
			$index ++;
			if ($name === $search)
				return $index;
		}
		return -1;
	}
	
	public function getNextRank (string $name, array $arr): string
	{
		$index = -1;
		$id = -1;
		foreach (array_keys ($arr) as $search) {
			$index ++;
			if ($name === $search) {
				$id = $index;
			}
		}
		foreach (array_keys ($arr) as $search) {
			$index ++;
			if ($index === ($id+1)) {
				return $search;
			}
		}
		return "Unkown";
	}
	
	public function upRank (string $name): void
	{
		$nowRank = $this->getRank ($name);
		$point = $this->getPoint ($name);
		
		$job = "";
		$sjob = JobAPI::getMainJob ($name);
		
		if (!isset ($this->db ["rank"] [$sjob])) {
			$sjob = JobAPI::getSubJob ($name);
			if (isset ($this->db ["rank"] [$sjob])) {
				$job = $sjob;
			}
		} else {
			$job = $sjob;
		}
		
		if ($job === "해군") {
			$arr = $this->arr1;
			if (isset ($arr [$nowRank])) {
				$index = $this->getSearchIndex ($nowRank, $arr);
				$rankPoint = $arr [$nowRank]; //현재 자신의 랭크의 포인트
				$nextRank = $this->getNextRank ($nowRank);
				if ($nextRank !== "Unkown") {
					if ($arr [$nextRank] <= $point) {
						if (count ($this->db ["rank"] [$arr [$nextRank]] ["player"]) < $this->db ["rank"] [$arr [$nextRank]] ["max"]) {
							$this->db ["rank"] [$arr [$nextRank]] ["player"] [$name] = true;
							unset ($this->db ["rank"] [$nowRank] ["player"] [$name]);
							$this->db ["player"] [$name] ["rank"] = $nextRank;
						}
					}
				}
			}
		}
		if ($job === "혁명군") {
			$arr = $this->arr2;
			if (isset ($arr [$nowRank])) {
				$index = $this->getSearchIndex ($nowRank, $arr);
				$rankPoint = $arr [$nowRank]; //현재 자신의 랭크의 포인트
				$nextRank = $this->getNextRank ($nowRank);
				if ($nextRank !== "Unkown") {
					if ($arr [$nextRank] <= $point) {
						if (count ($this->db ["rank"] [$arr [$nextRank]] ["player"]) < $this->db ["rank"] [$arr [$nextRank]] ["max"]) {
							$this->db ["rank"] [$arr [$nextRank]] ["player"] [$name] = true;
							unset ($this->db ["rank"] [$nowRank] ["player"] [$name]);
							$this->db ["player"] [$name] ["rank"] = $nextRank;
						}
					}
				}
			}
		}
		if ($job === "해적") {
			$arr = $this->arr3;
			if (isset ($arr [$nowRank])) {
				$index = $this->getSearchIndex ($nowRank, $arr);
				$rankPoint = $arr [$nowRank]; //현재 자신의 랭크의 포인트
				$nextRank = $this->getNextRank ($nowRank);
				if ($nextRank !== "Unkown") {
					if ($arr [$nextRank] <= $point) {
						if (count ($this->db ["rank"] [$arr [$nextRank]] ["player"]) < $this->db ["rank"] [$arr [$nextRank]] ["max"]) {
							$this->db ["rank"] [$arr [$nextRank]] ["player"] [$name] = true;
							unset ($this->db ["rank"] [$nowRank] ["player"] [$name]);
							$this->db ["player"] [$name] ["rank"] = $nextRank;
						}
					}
				}
			}
		}
		if ($job === "싸이퍼폴") {
			$arr = $this->arr4;
			if (isset ($arr [$nowRank])) {
				$index = $this->getSearchIndex ($nowRank, $arr);
				$rankPoint = $arr [$nowRank]; //현재 자신의 랭크의 포인트
				$nextRank = $this->getNextRank ($nowRank);
				if ($nextRank !== "Unkown") {
					if ($arr [$nextRank] <= $point) {
						if (count ($this->db ["rank"] [$arr [$nextRank]] ["player"]) < $this->db ["rank"] [$arr [$nextRank]] ["max"]) {
							$this->db ["rank"] [$arr [$nextRank]] ["player"] [$name] = true;
							unset ($this->db ["rank"] [$nowRank] ["player"] [$name]);
							$this->db ["player"] [$name] ["rank"] = $nextRank;
						}
					}
				}
			}
		}
	}
	
	public function addPlayerData (string $name): bool
	{
		if (!isset ($this->db ["player"] [$name])) {
			$this->db ["player"] [$name] = [
				"rank" => $this->getNewRank ($name),
				"point" => 0
			];
			return true;
		}
		return false;
	}
	
	public function getNewRank (string $name): string
	{
		$job = "";
		$sjob = JobAPI::getMainJob ($name);
		
		if (!isset ($this->db ["rank"] [$sjob])) {
			$sjob = JobAPI::getSubJob ($name);
			if (isset ($this->db ["rank"] [$sjob])) {
				$job = $sjob;
			}
		} else {
			$job = $sjob;
		}
		
		if ($job === "해군") {
			return "삼등병";
		} else if ($job === "혁명군") {
			return "혁명군";
		} else if ($job === "해적") {
			return "해적";
		} else if ($job === "싸이퍼폴") {
			return "CP-1";
		}
		return "";
	}
	
}