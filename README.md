# Permissions for RainLab.User plugin

This plugin extends the standard RainLab.User functionality by adding a comprehensive role and permission system for users and user groups. It provides flexible access control to different sections of your website and offers tools for permission checking in both code and templates.

## Requirements

The plugin requires [RainLab.User](http://octobercms.com/plugin/rainlab-user) to be installed and activated in your system before you can start configuring permissions. Make sure this dependency is properly installed before proceeding with setup.

## Features

- Extends user groups with permissions functionality for more flexible access control management across your application
- Provides individual permission settings for specific users, beyond just group-based permissions, allowing for fine-grained control
- Enables permission checking in both PHP code and Twig templates, simplifying the creation of conditional content based on user access rights
- Includes a permission check component for restricting access to pages without writing additional code
- Offers an Event for third-party plugins to register their own permission types and integrate with the permission system

## Usage Instructions

### Setting Up Permissions

Permission management is done through the October CMS administration panel. To configure permissions for a user group, navigate to the "Users" section and open the desired group. On the "Permissions" tab, you can set up the necessary access rights for that group. Additionally, if you need to configure individual permissions for specific users, you can do so by editing the user profile directly and adjusting their personal permission settings.

### Using the CheckPermission Component

The plugin provides a convenient component for restricting access to CMS pages based on permissions. To use this component, add it to your CMS page and configure the required permission along with an optional redirect page for users without the necessary permission. This approach eliminates the need for custom code to handle permission checks on page access.

```twig
[checkPermission]
permission = "dashboard"
redirect = "login"
==
```

### Checking Permissions in Twig Tags

For more complex scenarios where you need to conditionally display parts of a page based on user permissions, you can use the `hasPermission` Twig function directly in your templates. This allows for granular control over what content is visible to different users based on their permission set.

```twig
{% if hasPermission('dashboard') %}
    <div class="dashboard-panel">
        <!-- Content only accessible with dashboard permission -->
    </div>
{% endif %}
```

### Checking Permissions in PHP Code

When building custom functionality in PHP, you can check permissions programmatically using the `hasPermission` method on the user object. This integration makes it straightforward to implement permission-based logic throughout your application's backend code.

```php
$user = Auth::getUser();
if ($user && $user->hasPermission('dashboard')) {
    // Code requiring the permission
}
```

### Registering Custom Permissions

The plugin architecture allows other plugins to register their own permissions through the event system. To register custom permissions, add the following code to your plugin's `boot()` method. This extensibility makes it possible to integrate permission-based access control across all aspects of your October CMS application.

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

The plugin implements a hierarchical permission system using dot notation to create logical groupings of related permissions. For example, if a user has the `dashboard` permission, they automatically gain access to all child permissions such as `dashboard.view_profile` and `dashboard.manage_profile`. This hierarchical approach simplifies permission management by allowing you to grant broad access categories and then refine specific permissions as needed.