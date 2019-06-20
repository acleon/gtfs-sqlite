<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaFareAttributes
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('fare_attributes');
        $table->addColumn('fare_id', 'string');
        $table->addColumn('price', 'integer');
        $table->addColumn('currency_type', 'string');
        $table->addColumn('payment_method', 'integer');
        $table->addColumn('transfers', 'integer', ['notnull' => false]);
        $table->addColumn('agency_id', 'string', ['notnull' => false]);
        $table->addColumn('transfer_duration', 'integer', ['notnull' => false]);
        $table->addForeignKeyConstraint('agency', ['agency_id'], ['agency_id']);

        return $schema;
    }
}
