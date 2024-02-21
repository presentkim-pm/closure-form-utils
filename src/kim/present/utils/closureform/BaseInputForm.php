<?php

/**
 *
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the MIT License. see <https://opensource.org/licenses/MIT>.
 *
 * @author       PresentKim (debe3721@gmail.com)
 * @link         https://github.com/PresentKim
 * @license      https://opensource.org/licenses/MIT MIT License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 *
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\utils\closureform;

use pocketmine\form\Form;
use pocketmine\player\Player;

class BaseInputForm implements Form{
	/**
	 * @param string                                 $title
	 * @param string                                 $inputText
	 * @param \Closure                               $onSuccess
	 * @param \Closure|null                          $onCancel
	 *
	 * @phpstan-param \Closure(Player, mixed) : void $onSuccess
	 * @phpstan-param \Closure(Player) : void|null   $onCancel
	 */
	public function __construct(
		private string $title,
		private string $inputText,
		private \Closure $onSuccess,
		private \Closure|null $onCancel = null
	){}

	public function jsonSerialize() : array{
		return [
			"type" => "custom_form",
			"title" => $this->title,
			"content" => [
				["type" => "input", "text" => $this->inputText]
			]
		];
	}

	public function handleResponse(Player $player, mixed $data) : void{
		if($data === null || !isset($data[0])){
			if($this->onCancel){
				($this->onCancel)($player);
			}
			return;
		}
		($this->onSuccess)($player, trim($data[0]));
	}
}
