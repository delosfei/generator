<?php

namespace Delosfei\Generator\Commands\API;

use Delosfei\Generator\Commands\BaseCommand;
use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\API\APIPolicyGenerator;

class APIPoliciesGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ds.api:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an api policy command';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_API);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $PolicyGenerator = new APIPolicyGenerator($this->commandData);
        $PolicyGenerator->generate();

        $this->performPostActions();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return array_merge(parent::getArguments(), []);
    }
}
