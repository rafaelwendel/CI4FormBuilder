<?php

namespace CI4FormBuilder;

class Hidden extends AbstractComponent
{
    protected $hasBeforeAndAfterComponent = false;

    public function __construct(string $name, $value = '', bool $recursing = false)
    {
        parent::__construct();
        $this->name = $name;
        $this->params = [
            'name'      => $name,
            'value'     => $value,
            'recursing' => $recursing,
        ];
    } 
    
    /**
     * @override
     * Use a CI4 function to return a new hidden component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_hidden($this->params['name'], $this->params['value'], $this->params['recursing']);
    }
}