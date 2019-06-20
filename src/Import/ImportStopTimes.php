<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportStopTimes
{
    const FILENAME = 'stop_times.txt';

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
                $db->insert('stop_times', [
                    'trip_id' => $record['trip_id'],
                    'arrival_time' => $record['arrival_time'],
                    'departure_time' => $record['departure_time'],
                    'stop_id' => $record['stop_id'],
                    'stop_sequence' => (int) $record['stop_sequence'],
                ]);
            }
        });

        return $import;
    }
}
