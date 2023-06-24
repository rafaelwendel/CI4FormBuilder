<?php

namespace CI4FormBuilder;

class Dropdown extends AbstractComponent
{
    public function __construct($data = '', $options = [], $selected = [], $extra = '')
    {
        parent::__construct();
        $this->name = (is_array($data))
                      ? $data['name']
                      : $data;
        $this->params = [
            'data'      => $data,
            'options'   => $options,
            'selected'  => $selected,
            'extra'     => $extra,
        ];
    }
    
    /**
     * @override
     * Use a CI4 function to return a new dropdown component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_dropdown($this->params['data'], $this->params['options'], $this->params['selected'], $this->params['extra']);
    }
}