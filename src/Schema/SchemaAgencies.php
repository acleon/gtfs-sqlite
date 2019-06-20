<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaAgencies
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('agency');
        $table->addColumn('agency_id', 'string', ['notnull' => false]);
        $table->addColumn('agency_name', 'string');
        $table->addColumn('agency_url', 'string');
        $table->addColumn('agency_timezone', 'string');
        $table->addColumn('agency_lang', 'string', ['notnull' => false]);
        $table->addColumn('agency_phone', 'string', ['notnull' => false]);
        $table->addColumn('agency_fare_url', 'string', ['notnull' => false]);
        $table->addColumn('agency_email', 'string', ['notnull' => false]);
        $table->setPrimaryKey(['agency_id']);

        return $schema;
    }
}
