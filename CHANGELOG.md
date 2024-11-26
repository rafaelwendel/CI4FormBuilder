# Changes in CI4FormBuilder

## 0.0.3 - 2024-11-26

### Added

- Added `FormTypeAbstract` class, which allows the creation of forms as types, focusing at code organization and reuse

## 0.0.2 - 2024-09-23

### Added

- The option to create default (extra) templates for each form component has been added. This definition is made in the Template object options. The option consists of the component name concatenated with the Extra suffix (e.g. `inputExtra`, `dropdownExtra`, `submitExtra`, ...). Usage example: 
```php
$formTemplate['inputExtra'] = 'class="form-control"'; //string is available
$formTemplate['dropdownExtra'] = ['id' => 'myComp']; //array too =)
```