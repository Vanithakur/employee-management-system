# 👨‍💼 Employee Management System (with REST API)

A Laravel-based RESTful API project to manage employees, departments, and roles.

---

## ✅ Project Setup Steps

1. **Clone the Repository**

   git clone https://github.com/yourusername/employee-management-system.git
   cd employee-management-system

2. **Install Dependencies**

   composer install
   npm install
   npm run build

3. **Configure `.env` File**

   Update your `.env` file with appropriate DB credentials:
   If we are setup this project in our local system then add these

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

4. **Generate Application Key**

   php artisan key:generate

5. **Create Storage Link**

   php artisan storage:link

6. **Serve the Application**

   php artisan serve

---

## 🗃️ Database Migration and Seeding

7. **Run Migrations**

   php artisan migrate

8. **Run Seeders**

   php artisan db:seed

---

## 📑 API Documentation

All routes (except login/register) require Bearer Token Authorization.

### 🔐 Authentication

| Method | Endpoint        | Description                  |
| ------ | --------------- | ---------------------------- |
| POST   | `/api/register` | Register a user              |
| POST   | `/api/login`    | Login and get token          |
| POST   | `/api/logout`   | Logout user (token required) |

---

### 👤 Employees

| Method | Endpoint              | Description         |
| ------ | --------------------- | ------------------- |
| GET    | `/api/employees`      | List all employees  |
| GET    | `/api/employees/{id}` | Get employee by ID  |
| POST   | `/api/employees`      | Create new employee |
| PUT    | `/api/employees/{id}` | Update employee     |
| DELETE | `/api/employees/{id}` | Delete employee     |

---

### 🏢 Departments

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/departments`      | List all departments |
| POST   | `/api/departments`      | Create department    |
| DELETE | `/api/departments/{id}` | Delete department    |

---

### 🧑‍💼 Roles

| Method | Endpoint          | Description     |
| ------ | ----------------- | --------------- |
| GET    | `/api/roles`      | List all roles  |
| POST   | `/api/roles`      | Create new role |
| DELETE | `/api/roles/{id}` | Delete role     |
