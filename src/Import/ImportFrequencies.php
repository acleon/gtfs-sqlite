<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportFrequencies
{
    const FILENAME = 'frequencies.txt';

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
                $db->insert('frequencies', [
                    'trip_id' => $record['trip_id'],
                    'start_time' => $record['start_time'],
                    'end_time' => $record['end_time'],
                    'headway_secs' => (int) $record['headway_secs'],
                    'exact_times' => (int) $record['exact_times'],
                ]);
            }
        });

        return $import;
    }
}
