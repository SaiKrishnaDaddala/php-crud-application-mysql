$(document).ready(function() {
    function validateForm(formData) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let valid = true;
        formData.forEach(field => {
            if (field.name === 'type') return; // Skip validation for 'type' field
            if (typeof field.value !== 'string' || !field.value.trim()) {
                alert(`Please fill out the ${field.name} field.`);
                valid = false;
                return false;
            }
            if (field.name === 'email' && !emailPattern.test(field.value)) {
                alert('Please enter a valid email address.');
                valid = false;
                return false;
            }
        });
        return valid;
    }

    function handleResponse(response) {
        const parts = response.split('|');
        const statusCode = parts[0];
        const message = parts[1];
        const id = parts[2];
        
        if (statusCode == '200') {
            alert(message);
            location.reload();
        } else {
            alert(message);
        }
    }

    // Add user
    $(document).on('click', '#btn-add', function(e) {
        const formData = $("#user_form").serializeArray();
        formData.push({name: "type", value: 1});
        if (!validateForm(formData)) return;
        $.ajax({
            data: formData,
            type: "post",
            url: "backend/save.php",
            success: function(response) {
                handleResponse(response);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Pre-fill edit modal
    $(document).on('click', '.edit', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        const phone = $(this).data('phone');
        const city = $(this).data('city');
        const address = $(this).data('address');
        const job_title = $(this).data('job_title');

        $('#id_u').val(id);
        $('#name_u').val(name);
        $('#email_u').val(email);
        $('#phone_u').val(phone);
        $('#city_u').val(city);
        $('#address_u').val(address);
        $('#job_title_u').val(job_title);
    });

    // Update user
    $(document).on('click', '#update', function(e) {
        const formData = $("#update_form").serializeArray();
        formData.push({name: "type", value: 2});
        if (!validateForm(formData)) return;
        $.ajax({
            data: formData,
            type: "post",
            url: "backend/save.php",
            success: function(response) {
                handleResponse(response);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Delete user
    $(document).on('click', '.delete', function(e) {
        var id = $(this).data('id');
        $('#id_d').val(id);
    });

    $(document).on('click', '#delete', function(e) {
        $.ajax({
            url: "backend/save.php",
            type: "POST",
            data: {
                type: 3,
                id: $("#id_d").val(),
                csrf_token: $('input[name="csrf_token"]').val()
            },
            success: function(response) {
                handleResponse(response);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Delete multiple users
    $(document).on('click', '#delete_multiple', function(e) {
        var user = [];
        $(".user_checkbox:checked").each(function() {
            user.push($(this).data('user-id'));
        });
        if (user.length <= 0) {
            alert("Please select records.");
        } else {
            var checked = confirm("Are you sure you want to delete " + (user.length > 1 ? "these" : "this") + " row?");
            if (checked == true) {
                var selected_values = user.join(",");
                $.ajax({
                    type: "POST",
                    url: "backend/save.php",
                    data: {
                        type: 4,
                        id: selected_values,
                        csrf_token: $('input[name="csrf_token"]').val()
                    },
                    success: function(response) {
                        handleResponse(response);
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            }
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function() {
        if (this.checked) {
            checkbox.each(function() {
                this.checked = true;
            });
        } else {
            checkbox.each(function() {
                this.checked = false;
            });
        }
    });
    checkbox.click(function() {
        if (!this.checked) {
            $("#selectAll").prop("checked", false);
        }
    });
});
