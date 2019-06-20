<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportCalendar
{
    const FILENAME = 'calendar.txt';

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
                $db->insert('calendar', [
                    'service_id' => $record['service_id'],
                    'monday' => (int) $record['monday'],
                    'tuesday' => (int) $record['tuesday'],
                    'wednesday' => (int) $record['wednesday'],
                    'thursday' => (int) $record['thursday'],
                    'friday' => (int) $record['friday'],
                    'saturday' => (int) $record['saturday'],
                    'sunday' => (int) $record['sunday'],
                    'start_date' => $record['start_date'],
                    'end_date' => $record['end_date'],
                ]);
            }
        });

        return $import;
    }
}
