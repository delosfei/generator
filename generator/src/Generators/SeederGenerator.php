<?php

namespace Delosfei\Generator\Generators;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Utils\FileUtil;
use Illuminate\Support\Str;

/**
 * Class SeederGenerator.
 */
class SeederGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;
    private $fileName;
    private $database_seeder_file_path;
    private $model_seederData;
    private $existingDatabaseSeederContents;

    /**
     * ModelGenerator constructor.
     *
     * @param CommandData $commandData
     */
    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathSeeder;
        $this->fileName = $this->commandData->config->mPlural.'TableSeeder.php';

        $this->database_seeder_file_path = $this->path.'DatabaseSeeder.php';
        $this->existingDatabaseSeederContents = file_get_contents($this->database_seeder_file_path);
        $database_seeder_templateData = get_template('seeds.database_seeder', 'generator');
        $this->model_seederData = fill_template($this->commandData->dynamicVars, $database_seeder_templateData);
    }

    public function generate()
    {
        $templateData = get_template('seeds.model_seeder', 'generator');
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        FileUtil::createFile($this->path, $this->fileName, $templateData);
        $this->commandData->commandComment("\nSeeder created: ");
        $this->commandData->commandInfo($this->fileName);
        $this->addSeederToDatabase();
    }

    public function addSeederToDatabase()
    {
        if (Str::contains($this->existingDatabaseSeederContents, $this->model_seederData)) {
            $this->commandData->commandObj->info(substr($this->fileName, 0, -4).' is already exists in DatabaseSeeder.php, Skipping Adjustment.');

            return;
        }
        $this->existingDatabaseSeederContents = str_replace(
            infy_nl_tab().'}'.infy_nl().'}',
            infy_nl_tab(1, 2).$this->model_seederData.infy_nl_tab().'}'.infy_nl().'}',
            $this->existingDatabaseSeederContents
        );
        file_put_contents($this->database_seeder_file_path, $this->existingDatabaseSeederContents);

        $this->commandData->commandComment("\n".$this->fileName.'Seeder is added to DatabaseSeeder');

    }

    public function rollback()
    {
        if (Str::contains($this->existingDatabaseSeederContents, $this->model_seederData)) {
            $this->existingDatabaseSeederContents = str_replace(
                infy_nl_tab(1, 2).$this->model_seederData.infy_nl_tab().'}'.infy_nl().'}',
                infy_nl_tab().'}'.infy_nl().'}',
                $this->existingDatabaseSeederContents
            );
            file_put_contents($this->database_seeder_file_path, $this->existingDatabaseSeederContents);
            $this->commandData->commandComment(substr($this->fileName, 0, -4).'info deleted from DatabaseSeeder.php');
        }
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Seeder file deleted: '.$this->fileName);
        }
    }


}
