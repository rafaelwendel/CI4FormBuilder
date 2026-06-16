<?php

namespace CI4FormBuilder\Commands\Generators;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\GeneratorTrait;

/**
 * FormTypeGenerator CLI Command
 *
 * Generates a new FormType file.
 */
class FormTypeGenerator extends BaseCommand
{
    use GeneratorTrait;

    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Generators';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:formtype';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new FormType file';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:formtype <name> [options]';

    /**
     * The Command's Arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [
        'name' => 'The FormType class name.',
    ];

    /**
     * The Command's Options
     *
     * @var array<string, string>
     */
    protected $options = [
        '--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".',
        '--suffix'    => 'Append the component title to the class name (e.g. User => UserFormType).',
        '--force'     => 'Force overwrite existing file.',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->component = 'Type';
        $this->directory = 'FormTypes';
        $this->templatePath = 'CI4FormBuilder\Commands\Generators\Views\formtype.tpl.php';
        $this->template  = 'formtype.tpl.php';

        // Always force suffixing to "Type"
        $params['suffix'] = true;

        $this->classNameLang = 'CLI.generator.className.formtype';
        $this->generateClass($params);
    }
}
