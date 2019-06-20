<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportCalendarDates
{
    const FILENAME = 'calendar_dates.txt';

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
                $db->insert('calendar_dates', $record);
            }
        });

        return $import;
    }
}
