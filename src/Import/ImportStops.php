<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportStops
{
    const FILENAME = 'stops.txt';

    public function __invoke(ImportJob $import): ImportJob
    {
        if (false === $import->getGtfs()->has(self::FILENAME)) {
            return $import;
        }

        $csv = $import->getGtfs()->read(self::FILENAME);
        $csv = Reader::createFromString($csv);
        $csv->setHeaderOffset(0);

        $db = $import->getDb();
        $db->transactional(function (Connection $db) use ($csv) {
            foreach ($csv->getRecords() as $record) {
                $db->insert('stops', [
                    'stop_id' => $record['stop_id'],
                    'stop_name' => $record['stop_name'],
                    'stop_lat' => (float) $record['stop_lat'],
                    'stop_lon' => (float) $record['stop_lon'],
                    'stop_code' => $record['stop_code'] ?? null,
                    'stop_desc' => $record['stop_desc'],
                    'stop_url' => $record['stop_url'],
                    'stop_timezone' => $record['stop_timezone'] ?? null,
                    'location_type' => $record['location_type'] ?? null,
                    'parent_station' => $record['parent_station'] ?? null,
                    'zone_id' => $record['zone_id'],
                ]);
            }
        });

        return $import;
    }
}
