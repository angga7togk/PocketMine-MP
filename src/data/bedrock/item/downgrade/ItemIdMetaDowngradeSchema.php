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

namespace pocketmine\data\bedrock\item\downgrade;

use function mb_strtolower;

final class ItemIdMetaDowngradeSchema{

	/**
	 * @param string[]   $renamedIds
	 * @param string[][] $remappedMetas
	 * @phpstan-param array<string, string> $renamedIds
	 * @phpstan-param array<string, array{string, int}> $remappedMetas
	 */
	public function __construct(
		private array $renamedIds,
		private array $remappedMetas,
		private int $schemaId
	){}

	public function getSchemaId() : int{ return $this->schemaId; }

	public function renameId(string $id) : ?string{
		return $this->renamedIds[mb_strtolower($id, 'US-ASCII')] ?? null;
	}

	/**
	 * @return array{string, int}
	 */
	public function remapMeta(string $id) : ?array{
		return $this->remappedMetas[mb_strtolower($id, 'US-ASCII')] ?? null;
	}
}
