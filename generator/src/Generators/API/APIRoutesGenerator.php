<?php

namespace Delosfei\Generator\Generators\API;

use Illuminate\Support\Str;
use Delosfei\Generator\Common\CommandData;
use Delosfei\Generator\Generators\BaseGenerator;

class APIRoutesGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $routeContents;

    /** @var string */
    private $routesTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathApiRoutes;

        $this->routeContents = file_get_contents($this->path);

        if (!empty($this->commandData->config->prefixes['route'])) {
            $routesTemplate = get_template('api.routes.prefix_routes', 'generator');
        } else {
            $routesTemplate = get_template('api.routes.routes', 'generator');
        }

        $this->routesTemplate = fill_template($this->commandData->dynamicVars, $routesTemplate);
    }

    public function generate()
    {
        $this->routeContents .= infy_nl(1).$this->routesTemplate;
        $existingRouteContents = file_get_contents($this->path);
        if (Str::contains($existingRouteContents, "$this->routesTemplate")) {
            $this->commandData->commandInfo('+ '.$this->path.' (Skipping)');

            return;
        }

        file_put_contents($this->path, $this->routeContents);
        $this->path = Str::after($this->path, base_path());
        $this->commandData->commandInfo('+ '.$this->path.' (updated)');
    }

    public function rollback()
    {
        if (Str::contains($this->routeContents, $this->routesTemplate)) {
            $this->routeContents = str_replace($this->routesTemplate, infy_nl(1), $this->routeContents);
            file_put_contents($this->path, $this->routeContents);
            $this->path = Str::after($this->path, base_path());
            $this->commandData->commandInfo('- '.$this->path.' (updated)');
        }
    }
}
