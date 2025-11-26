# User Management, Roles, and Multi-language Translation System

## Overview

This project is a comprehensive management system built on Laravel with Livewire, providing user management, roles, permissions, and multi-language translations. The system is designed to be a powerful starting point for applications that require an advanced management system.

## Key Features

### 🔐 User and Role Management
- **User Management**: Create, edit, and delete users
- **Roles and Permissions System**: Comprehensive role and permission management using Spatie Permission
- **Activity Tracking**: Log all user activities using Activity Log
- **User Status**: Ability to activate/deactivate users

### 🌐 Multi-language Translation System
- **Language Management**: Add and modify supported languages
- **Translation Manager**: Easy-to-use interface for managing translations
- **RTL/LTR Support**: Full support for right-to-left languages
- **Import/Export Translations**: Ability to export translations to JSON files

### 🎨 User Interface
- **Livewire Flux**: Modern and attractive user interface
- **Tailwind CSS**: Responsive and beautiful design
- **Preline UI**: Advanced UI components
- **SweetAlert2**: Interactive notifications

## Technologies Used

### Backend
- **Laravel 12**: Advanced PHP framework
- **Livewire**: Interactive interface development without JavaScript
- **Livewire Volt**: Simplified Livewire components
- **Spatie Permission**: Role and permission management
- **Spatie Activity Log**: User activity logging
- **Laravel Passport**: API Authentication

### Frontend
- **Tailwind CSS 4**: Advanced CSS framework
- **Livewire Flux**: Livewire component library
- **Preline UI**: UI components
- **SweetAlert2**: Notification library
- **Vite**: Fast build tool

### Development Tools
- **Pest**: Testing framework
- **Laravel Pint**: Code formatter
- **Laravel Debugbar**: Development tools
- **Laravel Sail**: Development environment

## System Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL/PostgreSQL/SQLite
- Git

## Installation

### 1. Clone the Project
```bash
git clone <repository-url>
cd startar
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=startar
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Run basic seeders
php artisan db:seed

# Run roles and permissions seeder (Very Important)
php artisan db:seed --class=roles_permission
```

### 5. Build Assets
```bash
# Build assets for production
npm run build

# Or run in development mode
npm run dev
```

### 6. Run the Project
```bash
# Run the server
php artisan serve

# Or use Laravel Sail
./vendor/bin/sail up
```

## Default Login Credentials

After running the seeders, you can login using:

- **Email**: test@example.com
- **Password**: password

## Project Structure

```
app/
├── Http/Controllers/          # Controllers
├── Livewire/                 # Livewire components
│   ├── Actions/              # Actions
│   ├── Languages/            # Language management
│   ├── Logs/                 # Activity logs
│   ├── Permissions/          # Permission management
│   ├── Roles/                # Role management
│   ├── Translations/         # Translation management
│   └── Users/                # User management
├── Models/                   # Models
├── Policies/                 # Authorization policies
├── Services/                 # Services
└── Support/                  # Helper files

database/
├── migrations/               # Database files
└── seeders/                  # Initial data

resources/
├── css/                      # CSS files
├── js/                       # JavaScript files
└── views/                    # Blade templates
    ├── components/           # Components
    ├── livewire/             # Livewire templates
    └── flux/                 # Flux templates
```

## Advanced Features

### Translation System
- **Dynamic Management**: Add and modify translations from admin interface
- **Multi-language Support**: Unlimited language support
- **Automatic Export**: Export translations to JSON files
- **Smart Sync**: Sync translations with language files

### Permission System
- **Granular Permissions**: Precise permission control
- **Flexible Roles**: Create custom roles
- **Comprehensive Protection**: Protect all sensitive operations

### Activity Tracking
- **Comprehensive Logging**: Log all user activities
- **Detailed Information**: Detailed information about each activity
- **Advanced Filtering**: Search and filter capabilities in logs

## Helper Functions

The project includes custom helper functions in `app/Support/helpers.php`:

### Notification Function `notify()`
```php
/**
 * Unified and simple notification function
 *
 * @param string $message Notification message
 * @param string $type Notification type (success, error, warning, info)
 * @param bool $redirect Whether to show notification after redirect
 */
function notify(string $message, string $type = 'success', bool $redirect = true)
```

**Usage Examples:**
```php
// Success notification
notify('Saved successfully', 'success');

// Error notification
notify('An error occurred', 'error');

// Warning notification
notify('Please check the data', 'warning');

// Info notification
notify('Data updated', 'info');
```

### Delete Confirmation Function `confermeDelete()`
```php
/**
 * Delete confirmation function with user notification
 *
 * @param object $component Livewire component
 * @param string $title Confirmation title
 * @param string $message Confirmation message
 * @param mixed $itemId ID of item to be deleted
 */
function confermeDelete($component, $title, $message, $itemId)
```

**Usage Example:**
```php
// In Livewire component
public function delete($id)
{
    confermeDelete($this, 'Confirm Delete', 'Are you sure you want to delete this item?', $id);
}
```

## Roles and Permissions Seeder

The project includes a comprehensive seeder for setting up roles and permissions in `database/seeders/roles_permission.php`:

### Created Roles
- **Super Admin**: Main system administrator with all permissions

### Created Permissions

#### User Management Permissions
- `create user` - Create new user
- `edit user` - Edit user data
- `delete user` - Delete user
- `view users` - View users list
- `show user` - View user details

#### Role Management Permissions
- `create role` - Create new role
- `edit role` - Edit role
- `delete role` - Delete role
- `view roles` - View roles list

#### Permission Management Permissions
- `create permission` - Create new permission
- `edit permission` - Edit permission
- `delete permission` - Delete permission
- `view permissions` - View permissions list

#### Activity Logs Permissions
- `view activity logs` - View activity logs

#### Language Management Permissions
- `view languages` - View languages
- `create language` - Add new language
- `edit language` - Edit language
- `delete language` - Delete language
- `set default language` - Set default language

#### Translation Management Permissions
- `view translations` - View translations
- `edit translations` - Edit translations
- `import translations` - Import translations
- `export translations` - Export translations
- `publish translations` - Publish translations

### Default User
```php
Email: test@example.com
Password: password
Role: Super Admin
```

### Created Languages
- **English (en)**: Default language, LTR direction
- **Arabic (ar)**: RTL direction, active

### Imported Translations
Arabic translations are automatically imported from `database/seeders/ar.json` when running the seeder.

## Development

### Run Tests
```bash
php artisan test
```

### Format Code
```bash
./vendor/bin/pint
```

### Monitor Logs
```bash
php artisan pail
```

## Contributing

1. Fork the project
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Support

If you encounter any issues or have questions, please open an issue in the repository.

## Future Updates

- [ ] Notification system
- [ ] Advanced dashboard
- [ ] Complete RESTful API
- [ ] Backup system
- [ ] Multi-file support
- [ ] Advanced reporting system

---

**This project was developed using the latest Laravel and Livewire technologies to ensure performance, security, and ease of use.**
