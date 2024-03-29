<?php

namespace Delosfei\Generator\Generators;

use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Utils\FileUtil;
use Illuminate\Support\Str;

/**
 * Class SeederGenerator.
 */
class ObserverGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;
    private $fileName;
    private $appServiceProviderFilePath;
    private $modelObserverData;
    private $existingAppServiceProviderContents;

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

        if (file_exists($this->path.$this->fileName) && !$this->commandData->commandObj->confirmOverwrite($this->fileName)) {
            return;
        }

        $this->commandData->commandComment($this->createFileAndShowInfo($this->path, $this->fileName, $templateData));

        $this->addSeederToDatabase();
    }

    public function addSeederToDatabase()
    {
        if (Str::contains($this->existingDatabaseSeederContents, $this->model_seederData)) {
            $this->commandData->commandInfo('+ '.$this->database_seeder_file_path.'(Skipping)');

            return;
        }
        $this->existingDatabaseSeederContents = str_replace(
            infy_nl_tab().'}'.infy_nl().'}',
            infy_nl_tab(1, 2).$this->model_seederData.infy_nl_tab().'}'.infy_nl().'}',
            $this->existingDatabaseSeederContents
        );
        file_put_contents($this->database_seeder_file_path, $this->existingDatabaseSeederContents);
        $this->database_seeder_file_path = Str::after($this->database_seeder_file_path, base_path());
        $this->commandData->commandInfo('+ '.$this->database_seeder_file_path.'(updated)');
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
            $this->database_seeder_file_path = Str::after($this->database_seeder_file_path, base_path());

            $this->commandData->commandInfo('- '.$this->database_seeder_file_path.'(updated)');
        }
        ($del_path = $this->rollbackFile($this->path, $this->fileName)) ? $this->commandData->commandComment($del_path) : false;
    }


}
