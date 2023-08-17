
The TaskBar class is for creating a Task Bar navigation of actions available
to users. The base class will be used for setting the icon values, which will
then be used across the subclasses. Additional subclasses are provided for the
output of various task bar styles. You can extend the class for your own style.

Usage:

The icons should be set in an application configuration file prior to
instantiating a new TaskBar object.
```php
$icons = [
 'Edit' => 'fa-solid fa-pencil',
 'Reports' => 'fa-regular fa-file-lines',
 'Print' => 'fa-solid fa-print',
];

TaskBar:: setIcons($icons);

// Create an instance of TaskBarFontAwesome.
This is expecting font awesome class values for the icons.
$taskbar = new TaskBarFontAwesome();

// Set icon size (optional).
$taskbar->setIconSize('fa-lg');

// Set items at once.
$taskbar->setItems([
'Add New' => '/add-new',
'Reports' => [
   'Report Totals' => '/events/report/totals',
   'Registrants by Calendar' => '/events/report/series'
 ],
]);

// Add item.
$taskbar->addItem('Edit', "/edit/{$id}");

// Render the navbar.
$taskbar->render().
```
