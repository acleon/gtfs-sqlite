<?php

namespace ACLeon\Import;

use League\Pipeline\Pipeline;

class ImportPipeline
{
    public function build(): Pipeline
    {
        return (new Pipeline())
            ->pipe(new ImportAgencies())
            ->pipe(new ImportRoutes())
            ->pipe(new ImportStops())
            ->pipe(new ImportCalendar())
            ->pipe(new ImportCalendarDates())
            ->pipe(new ImportShapes())
            ->pipe(new ImportTrips())
            ->pipe(new ImportFrequencies())
            ->pipe(new ImportStopTimes())
            ->pipe(new ImportFareAttributes())
            ->pipe(new ImportFareRules());
    }
}
