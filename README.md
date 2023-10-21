Here's an improved `README.md`:

---

# 🚀 Pexty: PHP Web Framework

Pexty is a modern, lightweight, and high-performance PHP framework tailored to streamline your web development process. Whether you're crafting a simple website or architecting a robust web application, Pexty's got your back!

## 🌟 Features

- **MVC Architecture**: Adopt a clean separation of concerns with the tried-and-true Model-View-Controller pattern.
- **Database ORM**: Fluidly interact with databases through our user-friendly Object-Relational Mapping system.
- **Middleware Support**: Seamlessly incorporate authentication, caching, and other layers to your request-response cycle.
- **Modularity**: Scale and customize Pexty with plugins, packages, and extensions that align with your project’s requirements.

## 🛠️ Requirements

- PHP 7.4 or higher

## 📦 Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/vugarsafarzada/php_framework.git
   ```

2. **Install Dependencies**:
   Navigate to your project directory:
   ```bash
   composer install
   ```

## 🚀 Quick Start

### **Creating an API Route**
```php
// Define an API route within the "api" folder, e.g., /api/v1/user/login.php

require_once $_SERVER['DOCUMENT_ROOT'].'/controllers/user/loginController.php'; // Import necessary controllers

function APP_ROUTER($Controller, $Actions): void
{
    $response = $Actions['RESPONSE'];
    $request = $Actions['REQUEST'];
    $Controller($details);  // Use data ($details) to invoke controller methods
}
```

### **Crafting a Controller**
```php
// Implement request methods like: <method name>_METHOD($request, $response, $details)

function POST_METHOD($Request, $Response, $details): void
{
    // $details that come from the router (login.php).

    $database = new Database();    // Initialize the database
    $body = $req['payload'];       // Extract request body
    // ... Your business logic ...
    $Response($result, ['status' => 200, 'content_type' => 'json']);  // Send back a response
}

// Implement other HTTP methods similarly:
function GET_METHOD($Request, $Response): void
{
 //...
}

function PUT_METHOD($Request, $Response): void
{
 //...
}

function PATCH_METHOD($Request, $Response): void
{
 //...
}

function DELETE_METHOD($Request, $Response): void
{
 //...
}

function HEAD_METHOD($Request, $Response): void
{
 //...
}

function OPTIONS_METHOD($Request, $Response): void
{
 //...
}
```

### **Working with Database Methods**
```php
// Example methods to interact with the database:

function GET_METHOD($Request, $Response): void
{
    $database = new Database();
    
    // Various CRUD operations, schema manipulations, and more...
     // 1. Select data from users table where firstname is John
    $result = $database->select("SELECT * FROM users WHERE firstname='John'");
    // Comment: Fetch data for users named John
    
    // 2. Insert new user into the users table
    $result = $database->insert('users', [
        "firstname" => 'Jane',
        "lastname"  => 'Smith',
        "email"     => 'janesmith@example.com',
        "reg_date"  => date("Y-m-d H:i:s")
    ]);
    // Comment: Add a new user named Jane Smith
    
    // 3. Update the email address of John Doe
    $result = $database->update('users', 
        ["email" => 'newemail@example.com'], 
        "firstname='John' AND lastname='Doe'"
    );
    // Comment: Update John Doe's email address
    
    // 4. Delete users with firstname John
    $result = $database->delete('users', "firstname='John'");
    // Comment: Remove all users named John
    
    // 5. Create a new table named 'orders' with specific columns
    $result = $database->createTable('orders', [
        "order_id INT AUTO_INCREMENT PRIMARY KEY",
        "user_id INT",
        "product_name VARCHAR(255)",
        "order_date DATE"
    ]);
    // Comment: Create a new table for storing order data
    
    // 6. Delete the 'orders' table
    $result = $database->deleteTable('orders');
    // Comment: Drop the orders table
    
    // 7. Get columns from users table
    $result = $database->getTableColumns('users');
    // Comment: Fetch column details for the users table
    
    // 8. Create a new schema named 'test_db'
    $result = $database->createSchema('test_db');
    // Comment: Create a new database named test_db
    
    // 9. Delete the 'test_db' schema
    $result = $database->deleteSchema('test_db');
    // Comment: Drop the test_db database
    
    // 10. Check if 'test_db' schema exists
    $result = $database->checkSchemeIsExists('test_db');
    // Comment: Check if the test_db database exists
    
    // 11. Check if 'users' table exists in the 'mydatabase' schema
    $result = $database->checkTableIsExists('users', 'mydatabase');
    // Comment: Check if the users table exists in mydatabase

    $Response($result, ['status' => 200, 'content_type' => 'json']);
}
```

## 📚 Documentation

Stay tuned! Our comprehensive documentation is on its way. We'll dive deeper into Pexty's capabilities and how you can make the most out of it.

## 🤝 Contributing

We cherish contributions from our community! If you're considering adding your touch, please go through our [contribution guidelines](LINK_TO_CONTRIBUTING.md) to ensure a smooth collaboration.

## 📜 License

Pexty operates under the [MIT License](LICENSE).

---

🙏 Thanks for exploring Pexty! We're excited to witness what you'll build. Keep an eye on this README for more updates and enhancements.

--- 

This improved version adopts a friendly tone, uses emojis for better visual appeal, and streamlines information for readability.
