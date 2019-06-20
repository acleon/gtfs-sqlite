<?php

namespace ACLeon\Console;

use ACLeon\Import\ImportJob;
use ACLeon\Import\ImportPipeline;
use ACLeon\Schema\SchemaPipeline;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCommand extends Command
{
    public function configure()
    {
        $this->setName('gtfs:import');
        $this->setDescription('Convert GTFS file to SQLite');
        $this->addOption('in', null, InputOption::VALUE_REQUIRED);
        $this->addOption('out', null, InputOption::VALUE_REQUIRED);
        $this->addOption('dump-schema', null, InputOption::VALUE_NONE);
        $this->addOption('force', null, InputOption::VALUE_NONE);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // The "in" and "out" options are required. Raise an error if they're not set
        if (null === $input->getOption('in') || null === $input->getOption('out')) {
            $io->error('Require a GTFS zip file or folder to be supplied to the --in option and a file to create the database in supplied to the --out option');

            exit(255);
        }

        $file = new \SplFileInfo($input->getOption('in'));

        // If the input is not readable, then raise an error
        if (false === $file->isReadable()) {
            $io->error(sprintf('Could not find file / folder at %s', $file->getPath()));

            exit(255);
        }

        if ($file->isDir()) {
            $filesystemAdapter = new Local($file->getRealPath());
        } else {
            $filesystemAdapter = new ZipArchiveAdapter($file->getRealPath());
        }

        $databaseFile = new \SplFileInfo($input->getOption('out'));

        // If the database file already exists...
        if (true === $databaseFile->isFile()) {
            // ... and force is not set, then raise an error
            if (false === $input->getOption('force')) {
                $io->error('The output file already exists. Use --force to overwrite it.');

                exit(255);
            }

            // If force is set, remove the file so a new one can be created
            unlink($databaseFile->getPathname());
        }

        $filesystem = new Filesystem($filesystemAdapter);

        $dbParams = ['url' => 'sqlite:///'.$input->getOption('out')];
        $db = DriverManager::getConnection($dbParams, new Configuration());

        $schema = new Schema();
        $schemaPipeline = (new SchemaPipeline())->build();
        $schemaPipeline->process($schema);

        $schemaStatements = $schema->toSql($db->getDatabasePlatform());

        foreach ($schemaStatements as $statement) {
            if (true === $input->getOption('dump-schema')) {
                $io->writeln($statement);
            }

            $db->exec($statement);
        }

        $importJob = new ImportJob($filesystem, $db);

        $importPipeline = (new ImportPipeline())->build();
        $importPipeline->process($importJob);
    }
}
