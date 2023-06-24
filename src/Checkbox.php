<?php

namespace CI4FormBuilder;

class Checkbox extends AbstractComponent
{
    public function __construct($data = '', string $value = '', bool $checked = false, $extra = '')
    {
        parent::__construct();
        $this->name = (is_array($data))
                      ? $data['name']
                      : $data;
        $this->params = [
            'data'      => $data,
            'value'     => $value,
            'checked'   => $checked,
            'extra'     => $extra,
        ];
    } 
    
    /**
     * @override
     * Use a CI4 function to return a new checkbox component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_checkbox($this->params['data'], $this->params['value'], $this->params['checked'], $this->params['extra']);
    }
}