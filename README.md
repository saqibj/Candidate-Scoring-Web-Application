Here's the **updated `README.md`** with **developer name (`Saqib Jawaid`)** and **version (`1.0.1`)**.

---

## **📄 `README.md`**
```md
# Candidate Scoring System (PHP & MySQL) - v1.0.1

### 📌 Overview
The **Candidate Scoring System** is a **PHP web application** that enables organizations to **evaluate job candidates** efficiently. It provides **role-based dashboards**, **structured evaluations**, **report generation**, and **secure authentication**.

## **🚀 Features**
✅ **User Authentication**
- Secure login system (Admin, Interviewer, HR)
- Password hashing for security (bcrypt)
- Role-based access control (RBAC)

✅ **Candidate Management**
- Add, view, delete candidate profiles
- Resume upload & storage

✅ **Candidate Evaluations**
- Structured scoring system (Weighted Overall Score)
- Real-time evaluation submission
- Comments & feedback support

✅ **Reports & Analytics**
- **PDF Report Generation** (HR/Admin)
- **Dashboard analytics** (Candidate trends & scores)

✅ **Security & Optimization**
- SQL Injection protection (Prepared Statements)
- CSRF & XSS Prevention
- `.htaccess` file protection for sensitive data

---

## **📂 Project Folder Structure**
```
/candidate-scoring
│── /config
│   ├── database.php         # Database connection
│── /public
│   ├── index.php           # Entry point, redirects users
│── /auth
│   ├── register.php        # User Registration
│   ├── login.php           # User Login
│   ├── logout.php          # User Logout
│── /dashboard
│   ├── admin.php           # Admin Dashboard
│   ├── interviewer.php     # Interviewer Dashboard
│   ├── hr.php              # HR Dashboard
│── /candidates
│   ├── add.php             # Add Candidates
│   ├── view.php            # View Candidate List
│   ├── delete.php          # Delete Candidate
│── /evaluations
│   ├── evaluate.php        # Candidate Evaluation Form
│── /reports
│   ├── generate.php        # PDF Report Generation
│── /assets
│   ├── style.css           # CSS for UI styling
│── /libs
│   ├── tcpdf/              # Library for PDF Generation
│── .htaccess               # Security configurations
│── README.md               # Project Documentation
│── candidate_scoring.sql   # Database Schema
```

---

## **🛠️ Installation Guide**
### **🔹 1. Install XAMPP/WAMP**
Download and install **[XAMPP](https://www.apachefriends.org/download.html)** or **WAMP** for a **PHP & MySQL environment**.

### **🔹 2. Set Up MySQL Database**
1. Open `phpMyAdmin` or MySQL CLI.
2. Create a database:
   ```sql
   CREATE DATABASE candidate_scoring;
   ```
3. Import the database schema (`candidate_scoring.sql`):
   - In **phpMyAdmin**, select `candidate_scoring` → Import → Choose `candidate_scoring.sql`.

### **🔹 3. Configure Database Connection**
Edit `/config/database.php` and update database credentials:
```php
$host = "localhost";
$user = "root";         // Change if necessary
$password = "";         // Change if necessary
$database = "candidate_scoring";
```

### **🔹 4. Setup PDF Generation (TCPDF)**
1. **Download TCPDF**: [Get TCPDF](https://github.com/tecnickcom/TCPDF)
2. Extract it into `/libs/tcpdf/`

### **🔹 5. Start the Local Server**
1. Open XAMPP/WAMP and start:
   - **Apache** (for PHP)
   - **MySQL** (for the database)
2. Visit:
   ```
   http://localhost/candidate-scoring/public/
   ```
---

## **🔑 Default Credentials**
| Role         | Username     | Password    |
|-------------|-------------|-------------|
| **Admin**    | `admin`     | `password123` |
| **Interviewer** | `interviewer` | `password123` |
| **HR**       | `hr`        | `password123` |

⚠️ **Change passwords after first login!**

---

## **🔒 Security Best Practices**
- **Password Hashing**: All user passwords are securely stored using `bcrypt`.
- **Prepared Statements**: Prevents **SQL Injection** vulnerabilities.
- **Session-based Authentication**: Ensures secure user access.
- **File Access Restrictions (`.htaccess`)**:
  - Prevents direct access to `config/database.php`
  - Blocks access to `libs/`

---

## **📊 How to Use**
### **🔹 For Interviewers**
1. **Login as an Interviewer**.
2. Click **"Evaluate Candidates"**.
3. Fill out scores & comments.
4. Submit the evaluation.

### **🔹 For HR**
1. **Login as HR**.
2. View candidate reports.
3. Generate **PDF Reports**.
4. Monitor average candidate scores.

### **🔹 For Admin**
1. **Login as Admin**.
2. Manage users, candidates, and evaluations.

---

## **🛠️ Troubleshooting**
### **❌ Apache/MySQL Not Starting?**
- **Port Conflict?** Change Apache port from `80` to `8080` in **XAMPP Control Panel**.
- Run:
  ```
  netstat -ano | findstr :80
  ```
  If another process is using the port, **stop it** or change Apache's port.

### **❌ Blank Page / Errors?**
1. Enable PHP error reporting: Edit `php.ini` and set:
   ```ini
   display_errors = On
   ```
2. Restart Apache & refresh the page.

### **❌ Database Connection Failed?**
- Check `/config/database.php` and verify MySQL credentials.
- Ensure MySQL service is **running** in XAMPP/WAMP.

---

## **📌 Future Enhancements**
🚀 **Email Notifications**: Interview reminders & HR updates.  
🚀 **Interview Scheduling**: Integrated calendar for booking interviews.  
🚀 **Advanced Analytics**: AI-based resume screening & trend analysis.  

---

## **🎯 Author & License**
- **Developed by:** Saqib Jawaid  
- **Version:** 1.0.1  
- **License:** MIT  
```

---

### **📌 What's Improved?**
✅ **Version Updated:** `1.0.1`  
✅ **Security & Troubleshooting Section Improved**  
