<?php
// ১. ডাটা ফেচ করা
add_action('wp_ajax_fetch_users', 'ajax_fetch_users_handler');
add_action('wp_ajax_nopriv_fetch_users', 'ajax_fetch_users_handler');

function ajax_fetch_users_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_users';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

    if ($results) {
        foreach ($results as $row) {
            echo "<tr class='border-b hover:bg-gray-50'>
                <td class='p-4'>{$row->id}</td>
                <td class='p-4'>{$row->name}</td>
                <td class='p-4'>{$row->email}</td>
                <td class='p-4 text-center'>
                    <button class='edit-btn bg-yellow-500 text-white px-3 py-1 rounded' data-id='{$row->id}'>Edit</button>
                    <button class='delete-btn bg-red-500 text-white px-3 py-1 rounded ml-1' data-id='{$row->id}'>Delete</button>
                </td>
            </tr>";
        }
    }
    wp_die(); 
}

// ২. ডাটা সেভ/আপডেট করা
add_action('wp_ajax_save_user_action', 'ajax_save_user_handler');
function ajax_save_user_handler() {
    check_ajax_referer('user_crud_nonce', 'security');
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_users';

    $id = $_POST['user_id'];
    $data = [
        'name' => sanitize_text_field($_POST['name']),
        'email' => sanitize_email($_POST['email']),
    ];

    if (!empty($id)) {
        $wpdb->update($table_name, $data, ['id' => $id]);
        wp_send_json_success('Updated successfully!');
    } else {
        $wpdb->insert($table_name, $data);
        wp_send_json_success('Added successfully!');
    }
}

// ৩. ডিলিট করা
add_action('wp_ajax_delete_user_action', 'ajax_delete_user_handler');
function ajax_delete_user_handler() {
    check_ajax_referer('user_crud_nonce', 'security');
    global $wpdb;
    $wpdb->delete($wpdb->prefix . 'custom_users', ['id' => $_POST['id']]);
    wp_send_json_success('Deleted!');
}

// ৪. সিঙ্গেল ডাটা ফেচ (এডিট এর জন্য)
add_action('wp_ajax_get_single_user', 'ajax_get_single_user_handler');
function ajax_get_single_user_handler() {
    global $wpdb;
    $id = $_POST['id'];
    $user = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}custom_users WHERE id = $id");
    wp_send_json_success($user);
}