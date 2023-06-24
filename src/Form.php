<?php

namespace CI4FormBuilder;

use stdClass;

class Form 
{
    private $template = null;
    private $components = [];
    private $formData;
    private $errorsValidation = '';
    private $output = '';

    /**
     * Construct method (Set the form params. Basically the same of CI4 "form_open" function)
     * @access public
     * @param string       $action     the URI segments of the form destination
     * @param array|string $attributes a key/value pair of attributes, or string representation
     * @param array        $hidden     a key/value pair hidden data
     * @param bool         $multipart  true if the form is multipart
     * @return void
     */
    public function __construct(string $action = '', $attributes = [], array $hidden = [], bool $multipart = false)
    {
        helper('form');
        $this->formData = new stdClass;
        $this->output .= (! $multipart)
                        ? form_open($action, $attributes, $hidden)
                        : form_open_multipart($action, $attributes, $hidden);
    }

    /**
     * Set the template of form (and components)
     * @access public
     * @param Template $template
     * @return void
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Set the form data to populate the components
     * @access public
     * @param array|object $formData An object or array returned by a model, or request data submited
     * @return void
     */
    public function setFormData($formData)
    {
        if(is_array($formData)) {
            foreach ($formData as $key => $value) {
                $this->formData->$key = $value;
            }
        }
        else if (is_object($formData)) {
            $this->formData = $formData;
        }
    }

    /**
     * Returns the data (value) of an specific component
     * @access public
     * @param string $componentName Name of component
     * @return string
     */
    public function getFormData($componentName)
    {
        return (isset($this->formData->$componentName))
               ? $this->formData->$componentName
               : null;
    }

    /**
     * Set the errors validation messages of components (Generally $validation->getErrors())
     * @access public
     * @param array $errorsValidation An array with errors (E.g. $validation->getErrors())
     * @return void
     */
    public function setErrorsValidation($errorsValidation)
    {
        $this->errorsValidation = $errorsValidation;
    }

    /**
     * Returns the error message of an specific component
     * @access public
     * @param string $componentName Name of component
     * @return string
     */
    public function getErrorValidationMessage($componentName)
    {
        return (isset($this->errorsValidation[$componentName]))
               ? $this->errorsValidation[$componentName]
               : null;
    }

    /**
     * Add a component (or a list of components) into form
     * @access public
     * @param array|AbstractComponent $components A component or array of components
     * @return Form
     */
    public function addComponent($components)
    {
        $components = (! is_array($components))
                      ? [$components]
                      : $components;
        
        foreach ($components as $component) {
            if ($component instanceof AbstractComponent) {
                $this->components[] = $component;
            }
        }

        return $this;
    }

    /**
     * Returns the form code to be displayed (with template and all components)
     * @access public
     * @param string $extra To use on CI4 form_close function
     * @return string
     */
    public function display(string $extra = '')
    {
        $this->template = is_null($this->template)
                          ? new Template()
                          : $this->template;

        if($this->template->has('beforeForm')) {
            $tempOutput = $this->output;
            $this->output = $this->template->get('beforeForm') . "\n";
            $this->output .= "\t" . $tempOutput;
        }
        if(count($this->components) > 0) {
            foreach ($this->components as $component) {
                if(! $component->hasTemplate() && ! is_null($this->template)) {
                    $component->setTemplate($this->template);
                }
                $component->setValue($this->getFormData($component->getName()));
                $component->setErrorValidationMessage($this->getErrorValidationMessage($component->getName()));
                $this->output .= $component->display();
            }
        }
        $this->output .= form_close($extra) . "\n";

        if($this->template->has('afterForm')) {
            $this->output .= $this->template->get('afterForm') . "\n";
        }
        return $this->output;
    }
}