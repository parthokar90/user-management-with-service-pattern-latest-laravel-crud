

#### User Management System

**Description:**
The User Management System is a software application designed to facilitate the management of user data within an organization or system. It provides functionalities to create, read, update, and delete user records, along with additional features such as restoring deleted users and permanently deleting user data.

#### Key Features:
- Basic CRUD Operations: Users can be created, retrieved, updated, and deleted through the system's interface.

- Restore and Permanent Delete: The system allows users to restore previously deleted user records and permanently delete them if necessary.

- Advanced User Service Pattern: The implementation of a user service pattern enhances the codebase by providing a structured approach to managing user-related operations. This pattern helps improve code organization, scalability, and maintainability.

- Comprehensive Testing: The advanced feature branch includes comprehensive test cases for the user service class. These tests ensure the reliability and correctness of the user management functionalities, helping maintain software quality.

- Extended Feature - User Address Storage: The extended feature branch adds functionality to store user addresses within the system. Users can have multiple addresses associated with their profiles, creating a one-to-many relationship between users and addresses.

- Event Handling: Event listeners are implemented to manage address creation and updates. This ensures data consistency and integrity by automatically updating relevant user records when address information changes.

#### Php Version Requirement
 PHP ^8.2

#### Installation Procedure

#### Clone the Repository
Clone the repository to your local machine using the following command:

```bash
https://github.com/parthokar90/user-management-with-service-pattern-latest-laravel-crud.git
```
#### Install PHP Dependencies with Composer

```bash
composer install
```

#### Configure Environment Variables

```bash
cp .env.example .env
```
**update your database name from .env**

#### Database Migration

```bash
php artisan migrate
```

#### Database Seeding

```bash
php artisan db:seed
```
#### Start the Application 
Once the migration and seeding (if applicable) are complete, start the application:

```bash
php artisan serve
```
#### Access the Application
Open a web browser and navigate to the URL where the application is served

Open a web browser and navigate to the URL where the application is served (usually http://127.0.0.1:8000/ by default).

******************Thank You **********************

