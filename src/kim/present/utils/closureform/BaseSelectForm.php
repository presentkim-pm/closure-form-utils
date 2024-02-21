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

class BaseSelectForm implements Form{
	/** @var string[][] */
	protected array $buttons = [];

	/** @var \Closure[] */
	protected array $handlers = [];

	/**
	 * @param string                         $title
	 * @param string                         $content
	 * @param \Closure[]                     $buttons button_text => button_handler
	 *
	 * @phpstan-param array<string, Closure> $buttons
	 */
	public function __construct(
		private string $title,
		private string $content,
		array $buttons
	){
		foreach($buttons as $text => $handler){
			$this->buttons[] = ["text" => $text];
			$this->handlers[] = $handler;
		}
	}

	public function jsonSerialize() : array{
		return [
			"type" => "form",
			"title" => $this->title,
			"content" => $this->content,
			"buttons" => $this->buttons
		];
	}

	public function handleResponse(Player $player, mixed $data) : void{
		if($data === null){
			return;
		}
		($this->handlers[$data])($player, $data);
	}
}
