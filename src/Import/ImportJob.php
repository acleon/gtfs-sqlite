<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Flysystem\Filesystem;

class ImportJob
{
    private $gtfs;
    private $db;

    public function __construct(Filesystem $gtfs, Connection $db)
    {
        $this->gtfs = $gtfs;
        $this->db = $db;
    }

    public function getGtfs(): Filesystem
    {
        return $this->gtfs;
    }

    public function getDb(): Connection
    {
        return $this->db;
    }
}
