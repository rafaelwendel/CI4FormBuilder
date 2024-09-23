<?php

namespace CI4FormBuilder;

abstract class AbstractComponent
{
    private $label = false;
    private $template = null;
    protected $name;
    protected $params;
    protected $extraKey; //the key of component on the Template object
    protected $errorValidationMessage = null;
    protected $hasBeforeAndAfterComponent = true;
    protected $output;

    abstract public function outputComponent();

    public function __construct()
    {
        helper('form');
    }

    /**
     * Returns the name of component
     * @access public
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the component value
     * @access public
     * @param string $value Value to be set on component
     * @return void
     */
    public function setValue($value)
    {
        if(! is_null($value)){
            ($this instanceof Dropdown || $this instanceof Multiselect)
            ? $this->params['selected'] = $value   
            : $this->params['value'] = $value;        
        }
    }

    /**
     * Set the message of error validation to be displayed with component
     * @access public
     * @return void
     */
    public function setErrorValidationMessage($errorValidationMessage) 
    {
        $this->errorValidationMessage = $errorValidationMessage;
    }

    /**
     * Returns the error validation message
     * @access public
     * @return string
     */
    public function getErrorValidationMessage()
    {
        return $this->errorValidationMessage;
    }

    /**
     * Set a label to component
     * @access public
     * @param $label Label 
     * @return void
     */
    public function setLabel(Label $label)
    {
        $this->label = $label;
    }

    /**
     * Returns the component label
     * @access public
     * @return Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set a template to component
     * @access public
     * @param $template Template
     * @return void
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Verify if component has a tamplate defined
     * @access public
     * @return bool
     */
    public function hasTemplate()
    {
        return ! is_null($this->template);
    }

    /**
     * Set if the component has before and after template (E.g. hidden components doesnt needs template)
     * @access public
     * @param $hasBeforeAndAfterComponent bool
     * @return void
     */
    public function setHasBeforeAndAfterComponent(bool $hasBeforeAndAfterComponent)
    {
        $this->hasBeforeAndAfterComponent = $hasBeforeAndAfterComponent;
    }

    /**
     * Add a template part to be concatenated with output
     * @access private
     * @param $part string the part name of template
     * @return string
     */
    private function addTemplatePart($part)
    {
        if(! is_null($this->template) && $this->hasBeforeAndAfterComponent) {
            if($this->template->has($part)) {
                return $this->template->get($part) . "\n";
            }
        }
        return '';
    }

    /**
     * Returns the error message formated to be displayed with output
     * @access private
     * @return string
     */
    private function outputErrorMessage()
    {
        $output = '';

        if(! is_null($this->errorValidationMessage)) {
            $output = "\t\t";
            if($this->template->has('beforeErrorMessage')) {
                $output .= $this->template->get('beforeErrorMessage');
            }

            $output .= $this->errorValidationMessage;

            if($this->template->has('afterErrorMessage')) {
                $output .= $this->template->get('afterErrorMessage');
            }

            $output .= "\n";
        }

        return $output;
    }

    /**
     * If there is no extra/attributes param defined, search in the Template object
     * @access protected
     * @return void
     */
    protected function checkExtraParam($check) 
    {
        if($check === 'extra' || $check === 'attributes') {
            $this->params[$check] = ($this->params[$check] === '' && isset($this->template->has($this->extraKey)))
                                 ? $this->template->get($this->extraKey)
                                 : '';
        }
    }

    /**
     * Returns the component code to be displayed at form (with template and error message validation)
     * @access public
     * @return string
     */
    public function display()
    {        
        //if there is no extra/attributes param defined, search in the Template object
        $this->checkExtraParam('extra');

        $this->output .= "\n";
        $this->output .= "\t" . $this->addTemplatePart('beforeComponent');
        $this->output .= ($this->getLabel())
                         ? $this->getLabel()->display()
                         : null;
        $this->output .= "\t\t" . $this->outputComponent() . $this->outputErrorMessage();
        $this->output .= "\t" . $this->addTemplatePart('afterComponent');
        
        return $this->output;
    }
}