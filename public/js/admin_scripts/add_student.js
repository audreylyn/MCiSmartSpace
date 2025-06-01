// Program mapping based on departments
// const programsByDepartment = {
//     'Accountancy': [
//         'BACHELOR OF SCIENCE IN ACCOUNTANCY (BSA)',
//         'BACHELOR OF SCIENCE IN ACCOUNTING INFORMATION SYSTEMS (BSAIS)',
//         'BACHELOR OF SCIENCE IN MANAGEMENT ACCOUNTING (BSMA)',
//         'BACHELOR OF SCIENCE IN LEGAL MANAGEMENT (BSLM)'
//     ],
//     'Business Administration': [
//         'BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION (BS-BA)',
//         'BACHELOR OF SCIENCE IN BUSINESS MANAGEMENT (BS-BM)'
//     ],
//     'Hospitality Management': [
//         'BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT (BS-HM)',
//         'BACHELOR OF SCIENCE IN TRAVEL MANAGEMENT (BS-TM)'
//     ],
//     'Education, Arts, and Sciences': [
//         'BACHELOR IN ELEMENTARY EDUCATION (BEED)',
//         'BACHELOR OF SECONDARY EDUCATION (BSED)',
//         'BACHELOR OF PHYSICAL EDUCATION (BPE)',
//         'BACHELOR OF ARTS in Psychology (AB-Psych)'
//     ],
//     'Criminal Justice Education': [
//         'BACHELOR OF SCIENCE IN CRIMINOLOGY (BS-Crim)'
//     ]
// };

// Program mapping based on departments (acronyms only)
const programsByDepartment = {
    'Accountancy': [
        'BSA',
        'BSAIS',
        'BSMA',
        'BSLM'
    ],
    'Business Administration': [
        'BS-BA',
        'BS-BM'
    ],
    'Hospitality Management': [
        'BS-HM',
        'BS-TM'
    ],
    'Education, Arts, and Sciences': [
        'BEED',
        'BSED',
        'BPE',
        'AB-Psych'
    ],
    'Criminal Justice Education': [
        'BS-Crim'
    ]
};

// Function to update program dropdown
function updateProgramDropdown(department) {
    const programDropdown = $('#program');
    programDropdown.empty();
    programDropdown.append('<option value="">Select Program</option>');

    if (department && programsByDepartment[department]) {
        programsByDepartment[department].forEach(program => {
            programDropdown.append(`<option value="${program}">${program}</option>`);
        });
    }
}

// Handle department selection change
$('#department').on('change', function() {
    const selectedDepartment = $(this).val();
    updateProgramDropdown(selectedDepartment);
});

// Check for duplicate email
$('#student_email').on('blur', function() {
    var email = $(this).val().trim();
    if (email.length > 0) {
        $.ajax({
            url: 'check_email.php',
            type: 'GET',
            data: {
                email: email,
                type: 'student'
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#student_email').addClass('input-error');
                    $('#email_error').addClass('show-tooltip');
                    // Show tooltip for 3 seconds when error is detected
                    setTimeout(function() {
                        $('#email_error').removeClass('show-tooltip');
                    }, 3000);
                } else {
                    $('#student_email').removeClass('input-error');
                    $('#email_error').removeClass('show-tooltip');
                }
            }
        });
    }
});

// Clear error when typing
$('#student_email').on('input', function() {
    $(this).removeClass('input-error');
    $('#email_error').removeClass('show-tooltip');
});

// Form submission validation
$('form').on('submit', function(e) {
    var email = $('#student_email').val().trim();

    // First check if there's already an error shown
    if ($('#student_email').hasClass('input-error')) {
        e.preventDefault();
        showCustomAlert("Please fix the errors before submitting.", "error");
        return false;
    }

    // If no visible error, do one final check
    if (email.length > 0) {
        e.preventDefault(); // Temporarily prevent submission

        $.ajax({
            url: 'check_email.php',
            type: 'GET',
            data: {
                email: email,
                type: 'student'
            },
            dataType: 'json',
            async: false, // Make synchronous to block form submission
            success: function(response) {
                if (response.exists) {
                    $('#student_email').addClass('input-error');
                    $('#email_error').addClass('show-tooltip');
                    showCustomAlert("This email already exists. Please use a different email.", "error");
                    return false;
                } else {
                    // If no duplicate, continue with form submission
                    $('form').unbind('submit').submit();
                }
            }
        });

        return false; // Prevent default form submission
    }
});