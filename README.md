# Permissions for RainLab.User plugin

Extends RainLab.User plugin with roles and permissions for users and user groups.

## Requirements

[RainLab.User](http://octobercms.com/plugin/rainlab-user)

## Features

- Extends user groups with permissions functionality
- Individual permissions for users
- Permission checking in code and templates
- Permission check component for restricting access to pages
- Ability for third-party plugins to register their own permissions

## Usage Instructions

### Setting Up Permissions

1. Navigate to the "Users" section and open a user group
2. Go to the "Permissions" tab
3. Configure the required permissions for the group
4. If necessary, you can also set up individual permissions for specific users

### Using the CheckPermission Component

1. Add the "Check Permission" component to a CMS page
2. Select the permission you want to check
3. Optionally specify a redirect page in case the permission is not granted

```twig
[checkPermission]
permission = "dashboard"
redirect = "login"
==
```

### Checking Permissions in Twig Tags

```twig
{% if hasPermission('dashboard') %}
    <div class="dashboard-panel">
        <!-- Content only accessible with dashboard permission -->
    </div>
{% endif %}
```

### Checking Permissions in PHP Code

```php
$user = Auth::getUser();
if ($user && $user->hasPermission('dashboard')) {
    // Code requiring the permission
}
```

### Registering Custom Permissions

To register your own permissions, add the following code to your plugin's `boot()` method:

```php
\Event::listen('anikin.userpermissions.listPermissions', function () {
    return [
        [
            'code' => 'dashboard',
            'label' => 'Access Dashboard',
            'tab' => 'Frontend',
            'order' => 100,
        ],
        [
            'code' => 'dashboard.view_profile',
            'label' => 'View Profile',
            'tab' => 'Frontend',
            'order' => 200,
        ],
        [
            'code' => 'dashboard.manage_profile',
            'label' => 'Manage Profile',
            'tab' => 'Frontend',
            'order' => 300,
        ],
    ];
});
```

## Permission Hierarchy

Permissions can be organized hierarchically using dot notation. For example, if a user has the `dashboard` permission, they automatically gain access to child permissions such as `dashboard.view_profile`.
