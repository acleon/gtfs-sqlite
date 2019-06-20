<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaShapes
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('shapes');
        $table->addColumn('shape_id', 'string');
        $table->addColumn('shape_pt_lat', 'float');
        $table->addColumn('shape_pt_lon', 'float');
        $table->addColumn('shape_pt_sequence', 'integer');
        $table->addColumn('shape_dist_traveled', 'integer', ['notnull' => false]);

        return $schema;
    }
}
