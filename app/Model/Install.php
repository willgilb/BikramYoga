<?php

declare(strict_types=1);

namespace Model;

use Core\Database;

use function file_exists;
use function file_get_contents;

class Install
{
	private object $db;

	public function __construct()
	{
		$pdo = new Database;
		$this->db = $pdo->getConnection();

		echo 'BikramYoga Installer';
	}

	public function fromFile(string $filename): bool
	{
		if (file_exists($filename)) {
			$query = file_get_contents($filename);
			$stmt = $this->db->prepare($query);
			return $stmt->execute();
		}
		return false;
	}

	public function fromString(string $query): bool
	{
		$stmt = $this->db->prepare($query);
		return $stmt->execute();
	}
}
