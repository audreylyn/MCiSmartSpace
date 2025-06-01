// Check for duplicate building name
$('#building_name').on('blur', function() {
    var buildingName = $(this).val().trim();
    if (buildingName.length > 0) {
        $.ajax({
            url: 'includes/check_building_name.php',
            type: 'GET',
            data: {
                name: buildingName
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#building_name').addClass('input-error');
                    $('#building_name_error').addClass('show-tooltip');
                    // Show tooltip for 3 seconds when error is detected
                    setTimeout(function() {
                        $('#building_name_error').removeClass('show-tooltip');
                    }, 3000);
                } else {
                    $('#building_name').removeClass('input-error');
                    $('#building_name_error').removeClass('show-tooltip');
                }
            }
        });
    }
});

// Clear error when typing
$('#building_name').on('input', function() {
    $(this).removeClass('input-error');
    $('#building_name_error').removeClass('show-tooltip');
});

// Form submission validation
$('#buildingForm').on('submit', function(e) {
    var buildingName = $('#building_name').val().trim();

    // First check if there's already an error shown
    if ($('#building_name').hasClass('input-error')) {
        e.preventDefault();
        showCustomAlert("Please fix the errors before submitting.", "error");
        return false;
    }

    // If no visible error, do one final check
    if (buildingName.length > 0) {
        e.preventDefault(); // Temporarily prevent submission

        $.ajax({
            url: 'includes/check_building_name.php',
            type: 'GET',
            data: {
                name: buildingName
            },
            dataType: 'json',
            async: false, // Make synchronous to block form submission
            success: function(response) {
                if (response.exists) {
                    $('#building_name').addClass('input-error');
                    $('#building_name_error').addClass('show-tooltip');
                    showCustomAlert("This building name already exists.", "error");
                    return false;
                } else {
                    // If no duplicate, manually submit the form
                    $('#buildingForm').unbind('submit').submit();
                }
            }
        });

        return false; // Prevent default form submission
    }
});