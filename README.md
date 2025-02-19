# **Candidate Scoring Web Application**

A **PHP-based web application** designed to streamline the candidate evaluation process during interviews. This application allows interviewers to submit scoring sheets, HR to generate reports, and admins to manage users and system settings. It includes role-based access control, a MySQL database for data storage, and features like weighted scoring, PDF/Excel report generation, and search functionality.

---

## **Features**

1. **Role-Based Access Control:**
   - **Admin:** Manage users, view all reports, and configure system settings.
   - **Interviewer:** Submit candidate scoring sheets and view their own reports.
   - **HR:** View all reports, generate PDF/Excel reports, and search/filter candidates.

2. **Candidate Scoring Sheet:**
   - Dynamic form for entering candidate details and scores.
   - Automatically calculates weighted overall scores.

3. **Reporting:**
   - Generate PDF or Excel reports for candidates.
   - Filter reports by date, interviewer, or position.

4. **Search and Filter:**
   - Search for candidates by name, position, or interview date.

5. **User Authentication:**
   - Secure login/logout functionality with password hashing.
   - Password reset feature.

6. **Audit Logs:**
   - Track user actions (e.g., login attempts, report submissions).

7. **Responsive Design:**
   - Mobile-friendly interface using Bootstrap.

---

## **Technologies Used**

- **Frontend:** HTML, CSS, JavaScript (Bootstrap, jQuery).
- **Backend:** PHP.
- **Database:** MySQL.
- **Reporting:** FPDF (for PDF reports), PhpSpreadsheet (for Excel reports).
- **Authentication:** PHP sessions and password hashing.

---

## **Directory Structure**

```
candidate_scoring_app/
├── index.php
├── login.php
├── logout.php
├── register.php
├── dashboard.php
├── admin/
├── interviewer/
├── hr/
├── includes/
├── assets/
├── reports/
├── logs/
├── config/
└── README.md
```

---

## **Setup Instructions**

### **Prerequisites**
- PHP 7.0 or higher.
- MySQL database.
- Web server (e.g., Apache, Nginx).
- Composer (for installing PHP libraries).

### **Steps to Run Locally**

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/candidate-scoring-app.git
   cd candidate-scoring-app
   ```

2. **Set Up the Database:**
   - Create a MySQL database and import the provided SQL schema.
   - Update the database credentials in `config/config.php`.

3. **Install Dependencies:**
   - Install FPDF and PhpSpreadsheet using Composer:
     ```bash
     composer require setasign/fpdf mpdf/mpdf phpoffice/phpspreadsheet
     ```

4. **Configure the Web Server:**
   - Point your web server to the `candidate-scoring-app` directory.
   - Ensure `mod_rewrite` is enabled for clean URLs.

5. **Run the Application:**
   - Open the application in your browser (e.g., `http://localhost/candidate-scoring-app`).
   - Log in using the default admin credentials (update these after the first login).

---

## **Usage**

1. **Admin:**
   - Manage users and view all reports.
   - Configure system settings.

2. **Interviewer:**
   - Submit candidate scoring sheets.
   - View reports submitted by themselves.

3. **HR:**
   - View all candidate reports.
   - Generate PDF/Excel reports.
   - Search and filter candidates.

---

## **Contributing**

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeatureName`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeatureName`).
5. Open a pull request.

---

## **License**

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## **Screenshots**

![Login Page](assets/images/login.png)  
![Dashboard](assets/images/dashboard.png)  
![Candidate Scoring Form](assets/images/scoring_form.png)  
![Report Generation](assets/images/report.png)

---

## **Contact**

For questions or feedback, please contact:  
**Your Name**  
**Email:** your.email@example.com  
**GitHub:** [your-username](https://github.com/your-username)

---

This description provides a comprehensive overview of the project and makes it easy for others to understand, use, and contribute to it. Let me know if you need further adjustments!