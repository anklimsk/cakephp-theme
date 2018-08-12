# Using this plugin

## Install this plugin

1. Include components in your `AppController`:
```php
public $components = [
    'CakeTheme.Theme'
    'CakeTheme.ViewExtension',
    ...
];
```
2. Include helpers in your `AppController`:
```php
public $helpers = [
    'AssetCompress.AssetCompress',
    'CakeTheme.ActionScript',
    'CakeTheme.ViewExtension',
    'CakeTheme.Filter',
    'Form' => [
        'className' => 'CakeTheme.ExtBs3Form'
    ],
    ...
];
```

# Using features of this plugin

- [Using additional `JS` and `CSS` files in `main` layout](docs/ADDITIONAL_LAYOUT_FILES.md)
- [Retrieving list of specific `CSS` or `JS` files for action of controller](docs/ACTION_SCRIPT.md)
- [Rendering CakePHP Flash message using `Noty` or` Bootstrap`](docs/FLASH_MESSAGE.md)
- [Creating tour of the application](docs/APP_TOUR.md)
- [Filter for table data](docs/FILTER.md)
- [Pagination controls elements](docs/PAGINATION_CONTROLS.md)
- [Creation the links](docs/LINKS.md)
- [Creating forms and inputs](docs/FORMS.md)
- [Using `ViewExtension` helper](docs/VIEW_EXTENSION_HELPER.md)
- [Using `ViewExtension` component](docs/VIEW_EXTENSION_COMPONENT.md)
- [Creation main menu](docs/MAIN_MENU.md)
- [Updating libraries](docs/UPDATING_LIBRARIES.md)
- [Creating a collapsible tree and table with support for moving and drag and drop](docs/TREE.md)
