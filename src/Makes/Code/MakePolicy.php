<?php


namespace Delosfei\Generator\Makes\Code;

class MakePolicy
{
    use MakerTrait;


    private function start()
    {
        $model = $this->scaffoldCommandObj->getObjName('Name');
        $policy_name = $model . 'Policy';
        $this->makePolicy('Policy', 'base_policy');
        $this->makePolicy($policy_name, 'policy');

        $this->registerPolicy($model, $policy_name);
    }

    protected function makePolicy($name, $stubname)
    {
        $path = $this->getPath($name, 'policy');

        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub($stubname));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

    protected function compileStub($filename)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/'.$filename.'.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        // $this->replaceValidator($stub);

        return $stub;
    }

    protected function registerPolicy($model, $policy_name)
    {
        $path = './app/Providers/AuthServiceProvider.php';
        $content = $this->files->get($path);

        if (strpos($content, $policy_name) === false) {
            $content = str_replace(
                'policies = [',
                "policies = [\n\t\t \App\Models\\$model::class => \App\Policies\\$policy_name::class,",
                $content
                );
            $this->files->put($path, $content);

            return $this->scaffoldCommandObj->info('+ ' . $path . ' (Updated)');
        }

        return $this->scaffoldCommandObj->comment("x " . $path . ' (Skipped)');
    }




}
