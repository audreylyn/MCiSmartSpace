# MCiSmartSpace (improved RMIS)

## Description

MCiSmartSpace is a comprehensive web application designed for managing room reservations, equipment tracking, and user administration in academic environments. The system supports role-based access control across multiple user types including students, teachers, department administrators, and registrar staff. Key features include QR code-based room check-ins, equipment issue reporting with file uploads, PDF generation for reports, and a responsive interface that adapts to different screen sizes and user roles.

## Interesting Techniques

The codebase employs several modern web development patterns. The application uses [Flexbox layouts](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Flexible_Box_Layout/Basic_Concepts_of_Flexbox) extensively for responsive design, combined with [CSS Grid](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout) for complex layouts. Client-side PDF generation is handled through browser APIs without server processing. The QR code functionality integrates both the [Barcode Detection API](https://developer.mozilla.org/en-US/docs/Web/API/Barcode_Detection_API) where supported and fallback JavaScript libraries. File uploads utilize [FormData](https://developer.mozilla.org/en-US/docs/Web/API/FormData) with progress tracking and validation. The interface implements [CSS custom properties](https://developer.mozilla.org/en-US/docs/Web/CSS/--*) for consistent theming across different user role interfaces.

## Notable Technologies & Libraries

The application integrates several established libraries and frameworks. [Bootstrap 4.3.1](https://getbootstrap.com/docs/4.3/) provides the responsive grid system and UI components. [Font Awesome 4.5.0](https://fontawesome.com/v4.7.0/) supplies the icon system throughout the interface. [jQuery](https://jquery.com/) handles DOM manipulation and AJAX interactions. [DataTables](https://datatables.net/) powers the sortable, searchable data grids. The QR code functionality uses [QRCode.js](https://github.com/davidshimjs/qrcodejs) for generation and [HTML5-QRCode](https://github.com/mebjas/html5-qrcode) for scanning. [PHPSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) manages Excel file imports and exports. The PHP backend utilizes [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) for environment configuration management.

Typography uses [Plus Jakarta Sans](https://fonts.google.com/specimen/Plus+Jakarta+Sans) from Google Fonts. Performance optimizations include [FastClick](https://github.com/ftlabs/fastclick) for mobile interaction improvements and [Malihu Custom Scrollbar](https://manos.malihu.gr/jquery-custom-content-scroller/) for enhanced scrolling experiences.

## Security Features

### Session Security
Secure session cookies are implemented with secure, httponly, and samesite=Lax flags to prevent interception and cross-site attacks. The system enforces session timeout after 30 minutes of inactivity and after 12 hours regardless of activity level. Session IDs undergo regeneration after login to prevent session fixation attacks. Session integrity checks validate the user agent on each request to help prevent session hijacking attempts.

### Authentication and Authorization
Role-based access control ensures every protected page uses middleware to verify the user's role and session validity before granting access. The secure logout process destroys all session data and cookies to prevent unauthorized access to previous sessions.

### Password Security
All user passwords are hashed using the password_hash() function with the BCRYPT algorithm and a cost factor of 12. Password verification is handled through the password_verify() function to ensure secure authentication processes.

### Rate Limiting
The login system implements rate limiting to restrict failed login attempts to 5 attempts per 5 minutes per IP address, providing protection against brute-force attacks.

### Input Validation and Sanitization
All database queries involving user input utilize prepared statements to prevent SQL injection attacks. User input undergoes validation and sanitization before processing, including checks for email format, required fields, and password length requirements.

## User Roles and Responsibilities

### Student
- Browse available rooms and view room details
- Submit room reservation requests for activities
- View the status of their own room reservations (pending, approved, rejected)
- Cancel their own pending reservation requests
- Report equipment issues in rooms they use
- View the status of their equipment issue reports
- Download or generate PDF confirmations for reservations
- Edit their profile (with some fields restricted to admin updates)
- Change their password and delete their account

### Teacher
- Browse available rooms and view room details
- Submit room reservation requests for classes or activities
- View the status of their own room reservations (pending, approved, rejected)
- Cancel their own pending reservation requests
- Report equipment issues in rooms they use
- View the status of their equipment issue reports
- Download or generate PDF confirmations for reservations
- Edit their profile (with some fields restricted to admin updates)
- Change their password and delete their account

### Department Admin
- Approve or reject room reservation requests from students and teachers in their department
- Manage (add, edit, delete) student and teacher accounts for their department
- View statistics and summaries for rooms, equipment, and requests in their department
- Monitor and resolve equipment issues reported by students and teachers in their department
- Oversee room and equipment assignments within their department

### Registrar
- Add and manage department admin accounts
- Add and manage rooms and buildings
- Assign equipment to rooms
- View facility summaries and statistics
- Oversee the overall structure of departments, rooms, and equipment across the institution
