<?php

namespace CI4FormBuilder;

class Upload extends AbstractComponent
{
    public function __construct($data = '', string $value = '', $extra = '')
    {
        parent::__construct();
        $this->name = (is_array($data))
                      ? $data['name']
                      : $data;
        $this->params = [
            'data'  => $data,
            'value' => $value,
            'extra' => $extra,
        ];
    }
    
    /**
     * @override
     * Use a CI4 function to return a new upload field component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_upload($this->params['data'], $this->params['value'], $this->params['extra']);
    }
}