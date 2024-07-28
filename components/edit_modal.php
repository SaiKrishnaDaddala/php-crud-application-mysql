<div id="editEmployeeModal" class="modal fade" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" id="id_u" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name_u" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email_u" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" id="phone_u" name="phone" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>City</label>
                        <input type="text" class="form-control" id="city_u" name="city" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Address</label>
                        <input type="text" class="form-control" id="address_u" name="address">
                    </div>
                    <div class="form-group mb-3">
                        <label>Job Title</label>
                        <input type="text" class="form-control" id="job_title_u" name="job_title">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancel">
                    <button type="button" class="btn btn-primary" id="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
