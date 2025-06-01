// Check for duplicate room name when room name changes or building selection changes
function checkRoomName() {
    var roomName = $('#room_name').val().trim();
    var buildingId = $('#building_id').val();

    if (roomName.length > 0 && buildingId) {
        $.ajax({
            url: 'includes/check_room_name.php',
            type: 'GET',
            data: {
                name: roomName,
                building_id: buildingId
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#room_name').addClass('input-error');
                    $('#room_name_error').addClass('show-tooltip');
                    // Show tooltip for 3 seconds when error is detected
                    setTimeout(function() {
                        $('#room_name_error').removeClass('show-tooltip');
                    }, 3000);
                } else {
                    $('#room_name').removeClass('input-error');
                    $('#room_name_error').removeClass('show-tooltip');
                }
            }
        });
    }
}

// Check when leaving room name field
$('#room_name').on('blur', function() {
    checkRoomName();
});

// Check when building selection changes
$('#building_id').on('change', function() {
    if ($('#room_name').val().trim().length > 0) {
        checkRoomName();
    }
});

// Clear error when typing in room name field
$('#room_name').on('input', function() {
    $(this).removeClass('input-error');
    $('#room_name_error').removeClass('show-tooltip');
});

// Form submission validation
$('#roomForm').on('submit', function(e) {
    var roomName = $('#room_name').val().trim();
    var buildingId = $('#building_id').val();

    // First check if there's already an error shown
    if ($('#room_name').hasClass('input-error')) {
        e.preventDefault();
        showCustomAlert("Please fix the errors before submitting.", "error");
        return false;
    }

    // If no visible error and we have both name and building, do one final check
    if (roomName.length > 0 && buildingId) {
        e.preventDefault(); // Temporarily prevent submission

        $.ajax({
            url: 'includes/check_room_name.php',
            type: 'GET',
            data: {
                name: roomName,
                building_id: buildingId
            },
            dataType: 'json',
            async: false, // Make synchronous to block form submission
            success: function(response) {
                if (response.exists) {
                    $('#room_name').addClass('input-error');
                    $('#room_name_error').addClass('show-tooltip');
                    showCustomAlert("This room name already exists in the selected building.", "error");
                    return false;
                } else {
                    // If no duplicate, manually submit the form
                    $('#roomForm').unbind('submit').submit();
                }
            }
        });

        return false; // Prevent default form submission
    }
});