<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportShapes
{
    const FILENAME = 'shapes.txt';

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
                $db->insert('shapes', [
                    'shape_id' => $record['shape_id'],
                    'shape_pt_lat' => (float) $record['shape_pt_lat'],
                    'shape_pt_lon' => (float) $record['shape_pt_lon'],
                    'shape_pt_sequence' => (int) $record['shape_pt_sequence'],
                    'shape_dist_traveled' => (float) $record['shape_dist_traveled'],
                ]);
            }
        });

        return $import;
    }
}
