# PHP CRUD Application with Secure Input Handling Basic UI and MySQL

This is a PHP-based CRUD (Create, Read, Update, Delete) application with a basic UI built using Bootstrap and secure input handling to prevent SQL injection and other common vulnerabilities.

## Features

- Add, edit, delete, and view user records.
- Secure input handling to prevent SQL injection.
- Responsive UI using Bootstrap.
- CSRF protection.

## Requirements

- PHP 7.4 or later
- MySQL 5.7 or later
- Composer (for autoloading)

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/SaiKrishnaDaddala/php-crud-application-mysql.git
    cd php-crud-application-mysql
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Set up the database**

    Import the provided `crud.sql` file into your MySQL database.

    ```bash
    mysql -u yourusername -p yourdatabase < crud.sql
    ```

4. **Configure the database connection**

    On the first load, the application will prompt you to enter the database connection details.

## Usage

1. **Start the server**

    You can use PHP's built-in server for development purposes:

    ```bash
    php -S localhost:8000
    ```

2. **Open the application**

    Open your browser and navigate to `http://localhost:8000`.

3. **Interacting with the application**

    - Add a new user by clicking the "Add New" button.
    - Edit an existing user by clicking the pencil icon next to the user's name.
    - Delete a user by clicking the trash icon next to the user's name.
    - Delete multiple users by selecting the checkboxes next to the users' names and clicking the "Delete Selected" button.

## File Structure

- **index.php**: The main entry point for the application.
- **backend/save.php**: Handles the CRUD operations.
- **assets/ajax.js**: Contains the JavaScript for handling AJAX requests.
- **components**: Contains modal components for adding, editing, and deleting users.
- **autoload.php**: Handles the autoloading of classes.
- **database/Database.php**: Manages the database connection and table creation.

## Security

- Input validation and sanitization are implemented to prevent SQL injection.
- CSRF protection is implemented to prevent cross-site request forgery attacks.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request if you have any improvements or bug fixes.

## Author

- **Sai Krishna Daddala** - [SaiKrishnaDaddala](https://github.com/SaiKrishnaDaddala)

## Acknowledgments

- Inspired by various open-source projects and tutorials on PHP and Bootstrap.
- This project utilized the assistance of ChatGPT.
- Demo available at: [https://php-curd-app-demo.skd.xyz/](https://php-curd-app-demo.skd.xyz/)
