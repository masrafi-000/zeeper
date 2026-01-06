
function showToast(message, type = "success") {
    let backgroundColor = "#2ecc71"; 
    if (type === "error") backgroundColor = "#e74c3c"; 
    if (type === "warning") backgroundColor = "#f39c12"; 

    Toastify({
        text: message,
        duration: 4000,
        close: true,
        gravity: "bottom", 
        position: "left", 
        stopOnFocus: true, 
        style: {
            background: backgroundColor,
            borderRadius: "8px",
        },
    }).showToast();
}

jQuery(document).ready(function($) {
    const tableBody = $('#user-table-body');


    function fetchUsers() {
        tableBody.html('<tr><td colspan="4" class="text-center p-10">Loading users...</td></tr>');
        $.ajax({
            url: ajax_data.ajax_url,
            type: 'POST',
            data: { action: 'fetch_users' },
            success: function(res) {
                tableBody.html(res || '<tr><td colspan="4" class="text-center p-5 text-gray-400">No users found.</td></tr>');
            }
        });
    }
    fetchUsers();

  
    $('#user-form').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#form-submit');
        btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: ajax_data.ajax_url,
            type: 'POST',
            data: $(this).serialize() + '&action=save_user_action&security=' + ajax_data.nonce,
            success: function(res) {
                if(res.success) {
                   
                    showToast(res.data, "success"); 
                    
                    $('#user-form')[0].reset();
                    $('#user_id').val('');
                    btn.prop('disabled', false).text('Add User').removeClass('bg-green-600');
                    fetchUsers();
                } else {
                    showToast("Something went wrong!", "error");
                    btn.prop('disabled', false).text('Add User');
                }
            },
            error: function() {
                showToast("Server Error!", "error");
                btn.prop('disabled', false).text('Add User');
            }
        });
    });

   
    $(document).on('click', '.delete-btn', function() {
        if(confirm('Are you sure?')) {
            const id = $(this).data('id');
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: { action: 'delete_user_action', id: id, security: ajax_data.nonce },
                success: function(res) {
                   
                    showToast("User deleted successfully!", "warning");
                    fetchUsers();
                }
            });
        }
    });

  
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        $.ajax({
            url: ajax_data.ajax_url,
            type: 'POST',
            data: { action: 'get_single_user', id: id },
            success: function(res) {
                if(res.success) {
                    $('#user_id').val(res.data.id);
                    $('#name').val(res.data.name);
                    $('#email').val(res.data.email);
                    $('#form-submit').text('Update User').addClass('bg-green-600');
                    
                    showToast("Editing User: " + res.data.name, "success");
                }
            }
        });
    });
});