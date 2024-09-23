<?php

namespace CI4FormBuilder;

class Submit extends AbstractComponent
{
    public function __construct($data = '', string $value = '', $extra = '')
    {
        parent::__construct();
        $this->extraKey = 'submitExtra';

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
     * Use a CI4 function to return a new submit button component
     * @access public
     * @return string
     */
    public function outputComponent()
    {
        return form_submit($this->params['data'], $this->params['value'], $this->params['extra']);
    }
}