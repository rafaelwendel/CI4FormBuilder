<?php

namespace CI4FormBuilder;

class Input extends AbstractComponent
{
    public function __construct($data = '', string $value = '', $extra = '', string $type = 'text')
    {
        parent::__construct();
        $this->extraKey = 'inputExtra';

        $this->name = (is_array($data))
                      ? $data['name']
                      : $data;
        $this->params = [
            'data'  => $data,
            'value' => $value,
            'extra' => $extra,
            'type'  => $type,
        ];
    }
    
    /**
     * @override
     * Use a CI4 function to return a new input component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_input($this->params['data'], $this->params['value'], $this->params['extra'], $this->params['type']);
    }
}