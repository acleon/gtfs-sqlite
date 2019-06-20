<?php

namespace ACLeon\Schema;

use League\Pipeline\Pipeline;

class SchemaPipeline
{
    public function build(): Pipeline
    {
        return (new Pipeline())
            ->pipe(new SchemaAgencies())
            ->pipe(new SchemaRoutes())
            ->pipe(new SchemaStops())
            ->pipe(new SchemaCalendar())
            ->pipe(new SchemaCalendarDates())
            ->pipe(new SchemaShapes())
            ->pipe(new SchemaTrips())
            ->pipe(new SchemaFrequencies())
            ->pipe(new SchemaStopTimes())
            ->pipe(new SchemaFareAttributes())
            ->pipe(new SchemaFareRules());
    }
}
