<?php

namespace ACLeon\Import;

use Doctrine\DBAL\Connection;
use League\Csv\Reader;

class ImportFareAttributes
{
    const FILENAME = 'fare_attributes.txt';

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
                $db->insert('fare_attributes', [
                    'fare_id' => $record['fare_id'],
                    'price' => (int) $record['price'],
                    'currency_type' => $record['currency_type'],
                    'payment_method' => $record['payment_method'],
                    'transfers' => $record['transfers'],
                    'agency_id' => $record['agency_id'] ?? null,
                    'transfer_duration' => $record['transfer_duration'],
                ]);
            }
        });

        return $import;
    }
}
