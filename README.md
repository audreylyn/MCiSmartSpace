# MCiSmartSpace (Improved RMIS)

## 📌 Overview

**MCiSmartSpace** is a comprehensive web-based system designed to streamline room reservations, monitor equipment usage, and manage academic facility resources. Developed with role-based access control, the system supports students, teachers, department administrators, and registrar staff through a unified interface.

> This capstone project was conceptualized, designed, and fully implemented by **Audreylyn Moraña** as the technical lead.

---

## 🚀 Key Features

- **Room Reservation with QR Check-in**
- **Equipment Reporting with File Uploads**
- **PDF Export and Report Generation**
- **Secure Role-Based Access**
- **Statistics Dashboards per Role**
- **Responsive Design for All Devices**

---

## 🛠️ Technologies Used

| Area                      | Tools & Libraries                                                                 |
|---------------------------|------------------------------------------------------------------------------------|
| **Frontend**              | Bootstrap 4.3.1, Font Awesome 4.5.0, jQuery                                       |
| **PDF & Barcode**         | QRCode.js, HTML5-QRCode, Client-side PDF APIs                                     |
| **Backend**               | PHP, PHPMailer, PHPSpreadsheet, vlucas/phpdotenv                                  |
| **UI Techniques**         | Flexbox, CSS Grid, CSS Custom Properties                                           |
| **Data & Tables**         | DataTables, Malihu Custom Scrollbar                                               |
| **Security Enhancements** | Secure session flags, Role-based auth, Password hashing with BCRYPT               |
| **Performance**           | FastClick (for mobile tap delay removal)                                          |
| **Typography**            | Plus Jakarta Sans (Google Fonts)                                                  |

---

## 🔐 Security Features

### Session Security
- Session cookies: `secure`, `httponly`, `samesite=Lax`
- Auto-timeout: 30 min idle / 12 hr total
- Session ID regeneration on login
- User-Agent-based session verification

### Authentication & Authorization
- Role-based page protection
- Middleware checks for user roles
- Secure logout with full session/cookie destruction

### Password Security
- Passwords hashed using `password_hash()` with `BCRYPT` and cost factor 12
- Authentication via `password_verify()`

### Rate Limiting
- Max 5 failed login attempts per 5 minutes per IP address

### Input Validation
- Strict input validation and sanitation
- All DB queries use prepared statements

---

## 👤 User Roles & Responsibilities

### Student / Teacher
- Browse rooms and submit reservations
- View reservation status (Pending, Approved, Rejected)
- Cancel pending requests
- Report equipment issues
- Track issue/report history
- Download PDF confirmations
- Edit personal profile
- Change password / Delete account

### Department Admin
- Approve/reject student & teacher requests
- Manage student/teacher accounts
- Monitor equipment issues
- View department statistics
- Oversee room/equipment allocations

### Registrar
- Manage admin accounts, rooms, and buildings
- Assign equipment to rooms
- View global facility/equipment stats
- Maintain system-wide structure

---

## 📷 Screenshots by Role

### Registrar
![Sign-in Page](screenshots/sign-in.png)
![Add Admin](screenshots/registrar/reg_add_admin.png)
![Add Building](screenshots/registrar/reg_add_building.png)
![Add Rooms](screenshots/registrar/reg_add_rooms.png)
![Facility Management](screenshots/registrar/facility_management.png)
![Add Equipment](screenshots/registrar/reg_add_equipment.png)
![Assign Equipment](screenshots/registrar/assign_equipment.png)

---

### Department Admin
![Admin Dashboard](screenshots/dept-admin/admin_dashboard.png)
![Room Approval](screenshots/dept-admin/room_approval.png)
![Add Student](screenshots/dept-admin/add_student.png)
![Add Teacher](screenshots/dept-admin/add_teacher.png)
![Edit Student](screenshots/dept-admin/edit_student.png)
![Edit Teacher](screenshots/dept-admin/edit_teacher.png)
![Equipment Report](screenshots/dept-admin/equipment_report.png)
![Equipment 1](screenshots/dept-admin/eq1.png)
![Equipment 2](screenshots/dept-admin/eq2.png)
![QR Code Generator](screenshots/dept-admin/qr_code_generator.png)

---

### Student / Teacher
![Browse Room](screenshots/student_teacher/browse_room.png)
![Reservation Status](screenshots/student_teacher/reservation_status.png)
![Reservation History](screenshots/student_teacher/reservation_history.png)
![Equipment Reports](screenshots/student_teacher/equipment_reports.png)
![Report Page](screenshots/student_teacher/report_page.png)

---

## 📄 License & Credits

This project represents an academic capstone submission developed in compliance with institutional requirements. All third-party technologies and libraries integrated within the application are utilized in accordance with their respective licensing terms and conditions. For comprehensive licensing information and detailed attribution of external resources, please reference the project's `LICENSE` file or consult the complete [documentation guide](https://docs.google.com/document/d/1AUt2GX5aSccbsqDtfyzA8Y_tD_5woG99c4XPZXhRrz4/edit?tab=t.0#heading=h.5yd0k7wozhzr) which provides thorough coverage of all technological dependencies and their associated terms.

---

## ✍️ Author
Developed by **Audreylyn Moraña**  
📧 email: audreylynmorana1504@gmail.com  
🛠️ FrontEnd/Technical lead
