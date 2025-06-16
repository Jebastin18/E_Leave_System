# 🗓️ E-Leave Management System

A web-based Leave Management System that allows staff to apply for leave and admins to manage and approve requests. The system includes two separate dashboards: one for **Admins** and another for **Staff**.

---

## 🚀 Features

### 👤 Staff Panel
- Login and secure authentication
- Submit leave applications
- View leave status (approved/rejected/pending)
- Update personal information

### 🛠️ Admin Panel
- Login and secure authentication
- View all leave requests
- Approve or reject leave applications
- Manage staff information and leave history

---

## 🛠️ Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Styling**: Bootstrap 

---

## 🔑 Default Login Credentials

### 🔐 Admin
- **Username**: `admin`
- **Password**: `admin123`

### 👨‍💼 Staff
- **Username**: `staff`
- **Password**: `staff123`

> You can modify or add users directly in the MySQL database.

---

## 📁 Project Structure

/e-leave-system
│
├── index.php              # Login page
├── admin_dashboard.php    # Admin dashboard
├── staff_dashboard.php    # Staff dashboard
├── db.php                 # Database connection
├── logout.php             # Logout script

--------

⚙️ Setup Instructions
Clone or Download the Repository

bash
Copy
Edit
git clone https://github.com/Jebastin18/E_Leave_System.git
Import Database

Use phpMyAdmin or MySQL CLI to import eleave_db.sql.

Configure Database Connection

Update db.php:

php
Copy
Edit
$conn = new mysqli("localhost", "root", "", "eleave_db");
Run Locally

Place the project in your htdocs folder (if using XAMPP).

Start Apache & MySQL.

Access the system at http://localhost/E-LeaveSystem.

🧪 Modules Overview
Module	Description
Login	User authentication
Leave Apply	Staff can apply for leave
Leave Status	Staff can view past and current requests
Leave Management	Admin can view, approve, or reject leaves
User Management	Admin can manage staff users (optional)
---------
✍️ Author
Jebastin Raj
📧 Email: jebastinr817@gmail.com
📂 GitHub: github.com/Jebastin18
