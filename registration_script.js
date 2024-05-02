$(document).ready(function() {
    $('#registrationForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: 'POST',
            url: 'register_employee.php',
            data: formData,
            success: function(response) {
                $('#message').html(response);
            }
        });
    });
});