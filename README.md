# CI4FormBuilder

Library to build and manage forms in a CodeIgniter 4 projects (Object-Oriented way).

## Content

- [Instalation & Loading](#instalation-&-loading)
- [Components](#components)
- [How to use](#how-to-use)
    - [Basic Usage](#basic-usage)
    - [Using a Template](#using-a-template)
    - [Setting Form Data](#setting-form-data)
    - [Setting Error Messages](#setting-error-messages)
    - [Bonus: Form Types](#form-types)

## Instalation & Loading

CI4FormBuilder is available on [Packagist](https://packagist.org/packages/rafaelwendel/ci4formbuilder), and instalation via [Composer](https://getcomposer.org) is the recommended way to install it. Add the follow line to your `composer.json` file:

```json
"rafaelwendel/ci4formbuilder" : "^0.0.1"
```

or run

```sh
composer require rafaelwendel/ci4formbuilder
```

## Components

The following form components are available to use.
- `Button`
- `Checkbox`
- `Dropdown`
- `Hidden`
- `Input`
- `Label`
- `Multiselect`
- `Password`
- `Radio`
- `Reset`
- `Submit`
- `Textarea`
- `Upload`

## How to use

### Basic Usage

The cited components can be instantiated and added to a Form.

```php
<?php

namespace App\Controllers;

use CI4FormBuilder\Form;
use CI4FormBuilder\Input;
use CI4FormBuilder\Label;
use CI4FormBuilder\Submit;

class Home extends BaseController
{
    public function index()
    {
        $form = new Form(); //the same constructor params of CI4 "form_open" function can be used

        //create an input to "firstname"
        $firstNameField = new Input('firstname'); //the same constructor params of CI4 "form_input" function
        //set a label to component
        $firstNameField->setLabel(new Label('First Name: ', 'firstName'));

        //create an input to "lastname"
        $lastNameField = new Input('lastname');
        $lastNameField->setLabel(new Label('Last Name: ', 'lastName'));

        $submitButton = new Submit('btnSave', 'Save');

        //add components to $form
        $form->addComponent($firstNameField)
             ->addComponent($lastNameField)
             ->addComponent($submitButton);

        //display form
        echo $form->display();
    }
}
```

The above code prints the following result

```html
<form action="http://localhost:8080/" method="post" accept-charset="utf-8">
    <label for="firstName">First Name: </label>
    <input type="text" name="firstname" value="">

    <label for="lastName">Last Name: </label>
    <input type="text" name="lastname" value="">

    <input type="submit" name="btnSave" value="Save">
</form>
```

Another example using more components

```php
<?php

namespace App\Controllers;

use CI4FormBuilder\Checkbox;
use CI4FormBuilder\Dropdown;
use CI4FormBuilder\Form;
use CI4FormBuilder\Input;
use CI4FormBuilder\Label;
use CI4FormBuilder\Password;
use CI4FormBuilder\Submit;

class Home extends BaseController
{
    public function index()
    {
        $form = new Form();

        //create an input to "firstname"
        $nameField = new Input('name'); 
        $nameField->setLabel(new Label('Name: ', 'name'));

        //create an input type email to "email"
        $emailField = new Input('email', '', '', 'email'); //last param is type of input
        $emailField->setLabel(new Label('Email: ', 'email'));

        $genderField = new Dropdown('gender', ['M' => 'Male', 'F' => 'Female']);
        $genderField->setLabel(new Label('Gender: ', 'gender'));

        $passField = new Password('password');
        $passField->setLabel(new Label('Password: ', 'password'));

        $checkTerms = new Checkbox('terms', 'Accept');
        $checkTerms->setLabel(new Label('Agree the terms', 'terms'));

        $submitButton = new Submit('btnSave', 'Save');

        //add components to $form (pass an array with all components)
        $form->addComponent([$nameField, $emailField, $genderField, $passField, $checkTerms, $submitButton]);

        //display form
        echo $form->display();
    }
}
```

Output:

```html
<form action="http://localhost:8080/" method="post" accept-charset="utf-8">

    <label for="name">Name: </label>
    <input type="text" name="name" value="">
	
    <label for="email">Email: </label>
    <input type="email" name="email" value="">
	
    <label for="gender">Gender: </label>
    <select name="gender">
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>
	
    <label for="password">Password: </label>
    <input type="password" name="password" value="">

    <label for="terms">Agree the terms</label>
    <input type="checkbox" name="terms" value="Accept">

    <input type="submit" name="btnSave" value="Save">
</form>
```
### Using a Template

With the `Template` class it is possible to define a default layout for a Form and its components. The following options are available for use

- `beforeForm` : code to insert before the `<form>` tag
- `afterForm` : code to insert after the `</form>` close tag
- `beforeComponent` : code to insert before each component
- `afterComponent` : code to insert after each component
- `beforeErrorMessage` : code to insert before a component error message (like validation) 
- `afterErrorMessage` : code to insert after a component error message
- `buttonExtra` : extra attributes (`class`, `id`, `onclick`, etc.) to buttons (can use array, object or string)
- `checkboxExtra` : extra attributes to checkboxes
- `dropdownExtra` : extra attributes to dropdowns
- `hiddenExtra` : extra attributes to hiddens
- `inputExtra` : extra attributes to inputs
- `labelExtra` : extra attributes to labels
- `multiselectExtra` : extra attributes to multiselects
- `passwordExtra` : extra attributes to passwords
- `radioExtra` : extra attributes to radios
- `resetExtra` : extra attributes to resets
- `submitExtra` : extra attributes to submits
- `textareaExtra` : extra attributes to textareas
- `uploadExtra` : extra attributes to uploads

Example

```php
<?php

namespace App\Controllers;

use CI4FormBuilder\Form;
use CI4FormBuilder\Input;
use CI4FormBuilder\Label;
use CI4FormBuilder\Password;
use CI4FormBuilder\Submit;
use CI4FormBuilder\Template;

class Home extends BaseController
{
    public function index()
    {
        $form = new Form();

        //lets set the Template options
        $template = new Template([
            'beforeForm' => '<div class="form-login">',
            'afterForm' => '</div>',
            'beforeComponent' => '<div class="form-field">',
            'afterComponent' => '</div>',
            'inputExtra' => 'class="form-input"', //pass extra in a string
            'submitExtra' => ['id' => 'btnLogin', 'class' => 'btn'], //pass extra in an array 
        ]);

        //define the Form template
        $form->setTemplate($template);

        //create an input to "username"
        $usernameField = new Input('username'); 
        $usernameField->setLabel(new Label('Username: ', 'username'));

        //create an input to "password"
        $passField = new Password('password');
        $passField->setLabel(new Label('Password: ', 'password'));

        $submitButton = new Submit('btnLogin', 'Login');

        //add components to $form
        $form->addComponent([$usernameField, $passField, $submitButton]);

        //display form
        echo $form->display();
    }
}
```

Output:

```html
<div class="form-login">
	<form action="http://localhost:8080/" method="post" accept-charset="utf-8">

        <div class="form-field">
            <label for="username">Username: </label>
            <input type="text" name="username" value="" class="form-input">
        </div>

        <div class="form-field">
            <label for="password">Password: </label>
            <input type="password" name="password" value="">
        </div>

        <div class="form-field">
            <input type="submit" name="btnLogin" value="Login" id="btnLogin" class="btn">
        </div>
    </form>
</div>
```

### Setting Form Data

You can pass the value of a component in the constructor itself. Like:

```php
$nameField = new Input('name', 'Michael Jordan'); 
$nameField->setLabel(new Label('Name: ', 'name'));

$emailField = new Input('email', 'mjordan@nba.com', '', 'email'); //last param is type of input
$emailField->setLabel(new Label('Email: ', 'email'));

/*
    Output:
    <label for="name">Name: </label>
    <input type="text" name="name" value="Michael Jordan">

    <label for="email">Email: </label>
    <input type="email" name="email" value="mjordan@nba.com">
*/
```

However, it is also possible to pass an `array` or `object` containing the data to be set through the `setFormData` method in `$form` instance. Data can be provide from a model or a request.

```php

$form = new Form(); 

//Customers form
$firstNameField = new Input('firstname'); /
$firstNameField->setLabel(new Label('First Name: ', 'firstName'));

$lastNameField = new Input('lastname');
$lastNameField->setLabel(new Label('Last Name: ', 'lastName'));

$submitButton = new Submit('btnSave', 'Save');

//add components to $form
$form->addComponent($firstNameField)
        ->addComponent($lastNameField)
        ->addComponent($submitButton);

//set data from db
$customerToEdit = model('CustomerModel')->find(1); //an object or array with "firstname" and "lastname" params/keys.
$form->setFormData($customerToEdit);

//to set data from request
$form->setFormData($this->request->getPost());

//display form
echo $form->display();
```

### Setting Error Messages

To include error messages (usually validation errors), just pass them to the `setErrorsValidation` method. In addition, also configure the template for displaying errors

```php

//define validation rules
$errors = [];
$validation = \Config\Services::validation();
if($this->request->is('post')) {
    $validation->setRules([
        'name'    => 'required|min_length[5]',
        'email'   => 'required|valid_email',
    ]);
    if(! $validation->run($this->request->getPost())) {
        $errors = $validation->getErrors();
    }
}

$form = new Form();

//set errors messages
$form->setErrorsValidation($errors);

//Template options to display errors
$template = new Template([
    'beforeErrorMessage' => '<span style="color: red">',
    'afterErrorMessage' => '</span>',
]);

//define the Form template
$form->setTemplate($template);

//create an input to "username"
$nameField = new Input('name'); 
$nameField->setLabel(new Label('Name: ', 'name'));

//create an input to "email"
$emailField = new Input('email', '', '', 'email');
$emailField->setLabel(new Label('Email: ', 'email'));


$submitButton = new Submit('btnSave', 'Save');

//add components to $form
$form->addComponent([$nameField, $emailField, $submitButton]);

//display form
echo $form->display();
```

Output

```html
<label for="name">Name: </label>
<input type="text" name="name" value="">
<span style="color: red">The name field is required.</span>

<label for="email">Email: </label>
<input type="email" name="email" value="">
<span style="color: red">The email field must contain a valid email address.</span>
```

### Bonus: Form Types

The `FormTypeAbstract` class provides a standard structure for creating `types` (objects) related to the form that will be created.

For example, let's implement a product form with `name` and `price` fields. To do this, we will create the `ProductType` (extending `FormTypeAbstract`) class in the `App/FormType` folder. (Note: we must implement the abstract `setComponents` method defined in the `FormTypeAbstract` class)

```php
<?php

namespace App\FormType;

use CI4FormBuilder\FormTypeAbstract;
use CI4FormBuilder\Hidden;
use CI4FormBuilder\Input;
use CI4FormBuilder\Label;
use CI4FormBuilder\Submit;

class ProductType extends FormTypeAbstract
{
    //implement the abastract method defined on super
    protected function setComponents()
    {
        $hiddenId = new Hidden('id');

        $inputName = new Input('name');
        $inputName->setLabel(new Label('Name: ', 'name'));

        $inputPrice = new Input('price');
        $inputPrice->setLabel(new Label('Price: ', 'price'));

        $submitButton = new Submit('btnSave', $this->getSubmitLabel());

        $this->addComponent([$hiddenId, $inputName, $inputPrice, $submitButton]);
    }
}
```

We will use this `ProductType` in the `Products` controller

```php
<?php

namespace App\Controllers;

use App\FormType\ProductType;

class Products extends BaseController
{
    /* ... 
        construct and others methods 
       ... 
    */

    public function add()
    {
        $productType = new ProductType();
        //set the submit label
        $productType->setSubmitLabel('Save');

        $data['form'] = $productType->display();

        return view('products_form', $data);
    }
}
```

Same type for edit action

```php

    public function edit($id)
    {
        $product = model('ProductModel')->find($id);

        $productType = new ProductType();
        //set the submit label
        $productType->setSubmitLabel('Edit/Update');
        //set data
        $productType->setFormData($product);

        $data['form'] = $productType;

        return view('products_form', $data);
    }
```

Finally, in the type constructor it is possible to pass the template option (discussed in [Using a Template](#using-a-template)) and the submit label.

```php

    $templateOptions = [
        'beforeForm'         => '<div class="form">',
        'afterForm'          => '</div>',
        'beforeComponent'    => '<div class="mb-3">',
        'afterComponent'     => '</div>',
        'inputExtra'         => 'class="form-control"',
        'labelExtra'         => ['class' => 'form-label'],
        'submitExtra'        => ['class' => 'btn btn-primary', 'id' => 'btn_save'],
        /* Other options .... */
    ];
    $submitLabel = 'Save'; //Or Edit, Update, ....

    $productType = new ProductType($templateOptions, $submitLabel);
```
