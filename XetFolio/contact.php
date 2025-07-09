<?php
/**
 * Plugin Name: Modern Contact Form
 * Description: A secure, modern contact form plugin for WordPress with validation and spam protection.
 * Version: 1.0
 * Author: Esteham H. Zihad Ansari
 * Author URI: https://xetroot.com
 * License: GPL2
 */

// Enqueue necessary scripts and styles
function modern_contact_form_assets() {
    wp_enqueue_style('modern-contact-form', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('modern-contact-form', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0', true);
    
    // Localize script for AJAX
    wp_localize_script('modern-contact-form', 'contactFormAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('contact_form_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'modern_contact_form_assets');

// Contact form shortcode
function modern_contact_form() {
    ob_start(); ?>
    
    <div class="modern-contact-form-container">
        <form id="modern-contact-form" class="modern-contact-form" method="post">
            <div class="form-group">
                <label for="full_name">Full Name*</label>
                <input type="text" id="full_name" name="full_name" required>
                <span class="error-message" id="name-error"></span>
            </div>
            
            <div class="form-group">
                <label for="email_address">Email Address*</label>
                <input type="email" id="email_address" name="email_address" required>
                <span class="error-message" id="email-error"></span>
            </div>
            
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number">
                <span class="error-message" id="phone-error"></span>
            </div>
            
            <div class="form-group">
                <label for="comments">Your Message*</label>
                <textarea id="comments" name="comments" rows="5" required></textarea>
                <span class="error-message" id="message-error"></span>
            </div>
            
            <!-- Honeypot field for spam protection -->
            <div class="honeypot" style="display: none;">
                <label>Leave this field empty</label>
                <input type="text" name="honeypot">
            </div>
            
            <div class="form-group">
                <button type="submit" name="submit_form" class="submit-btn">
                    <span class="btn-text">Send Message</span>
                    <span class="loading-spinner" style="display:none;"></span>
                </button>
            </div>
            
            <div class="form-response" style="display: none;"></div>
        </form>
    </div>
    
    <?php
    return ob_get_clean();
}
add_shortcode('modern_contact_form', 'modern_contact_form');

// Form processing via AJAX
function process_contact_form() {
    check_ajax_referer('contact_form_nonce', 'nonce');
    
    // Initialize response array
    $response = array(
        'success' => false,
        'errors' => array(),
        'message' => ''
    );
    
    // Validate honeypot
    if (!empty($_POST['honeypot'])) {
        $response['message'] = __('Spam detected!', 'modern-contact-form');
        wp_send_json($response);
    }
    
    // Validate fields
    $name = sanitize_text_field($_POST['full_name'] ?? '');
    $email = sanitize_email($_POST['email_address'] ?? '');
    $phone = sanitize_text_field($_POST['phone_number'] ?? '');
    $message = sanitize_textarea_field($_POST['comments'] ?? '');
    
    // Validation checks
    if (empty($name)) {
        $response['errors']['full_name'] = __('Please enter your name', 'modern-contact-form');
    }
    
    if (empty($email)) {
        $response['errors']['email_address'] = __('Please enter your email', 'modern-contact-form');
    } elseif (!is_email($email)) {
        $response['errors']['email_address'] = __('Please enter a valid email', 'modern-contact-form');
    }
    
    if (!empty($phone) && !preg_match('/^[\d\s\-+()]{10,20}$/', $phone)) {
        $response['errors']['phone_number'] = __('Please enter a valid phone number', 'modern-contact-form');
    }
    
    if (empty($message)) {
        $response['errors']['comments'] = __('Please enter your message', 'modern-contact-form');
    }
    
    // If there are errors, return them
    if (!empty($response['errors'])) {
        wp_send_json($response);
    }
    
    // Prepare email
    $to = get_option('admin_email'); // Use admin email from settings
    $subject = __('New Contact Form Submission from ', 'modern-contact-form') . get_bloginfo('name');
    
    $body = '<html><body>';
    $body .= '<h2>' . __('Contact Form Submission', 'modern-contact-form') . '</h2>';
    $body .= '<p><strong>' . __('Name:', 'modern-contact-form') . '</strong> ' . esc_html($name) . '</p>';
    $body .= '<p><strong>' . __('Email:', 'modern-contact-form') . '</strong> ' . esc_html($email) . '</p>';
    $body .= '<p><strong>' . __('Phone:', 'modern-contact-form') . '</strong> ' . esc_html($phone) . '</p>';
    $body .= '<p><strong>' . __('Message:', 'modern-contact-form') . '</strong></p>';
    $body .= '<p>' . nl2br(esc_html($message)) . '</p>';
    $body .= '</body></html>';
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Send email
    $mail_sent = wp_mail($to, $subject, $body, $headers);
    
    if ($mail_sent) {
        // Save to database if needed
        if (get_option('modern_contact_form_store_submissions', true)) {
            global $wpdb;
            $contact_me = $wpdb->prefix . 'modern_contact_form';
            
            $wpdb->insert(
                $contact_me,
                array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'message' => $message,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'submission_date' => current_time('mysql')
                ),
                array('%s', '%s', '%s', '%s', '%s', '%s')
            );
        }
        
        $response['success'] = true;
        $response['message'] = __('Thank you for your message! We will get back to you soon.', 'modern-contact-form');
    } else {
        $response['message'] = __('There was an error sending your message. Please try again later.', 'modern-contact-form');
    }
    
    wp_send_json($response);
}
add_action('wp_ajax_process_contact_form', 'process_contact_form');
add_action('wp_ajax_nopriv_process_contact_form', 'process_contact_form');

// Create database table on plugin activation
function modern_contact_form_activate() {
    global $wpdb;
    $contact_me = $wpdb->prefix . 'modern_contact_form';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $contact_me (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(30),
        message text NOT NULL,
        ip_address varchar(45),
        submission_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Set default options
    add_option('modern_contact_form_store_submissions', true);
}
register_activation_hook(__FILE__, 'modern_contact_form_activate');

// Add admin menu for submissions
function modern_contact_form_admin_menu() {
    add_menu_page(
        __('Contact Form Submissions', 'modern-contact-form'),
        __('Form Submissions', 'modern-contact-form'),
        'manage_options',
        'modern-contact-form-submissions',
        'modern_contact_form_submissions_page'
    );
}
add_action('admin_menu', 'modern_contact_form_admin_menu');

// Admin submissions page
function modern_contact_form_submissions_page() {
    global $wpdb;
    $contact_me = $wpdb->prefix . 'modern_contact_form';
    $submissions = $wpdb->get_results("SELECT * FROM $contact_me ORDER BY submission_date DESC");
    
    echo '<div class="wrap">';
    echo '<h1>' . __('Contact Form Submissions', 'modern-contact-form') . '</h1>';
    
    if (!empty($submissions)) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Date</th>
                <th>IP</th>
              </tr></thead>';
        echo '<tbody>';
        
        foreach ($submissions as $submission) {
            echo '<tr>';
            echo '<td>' . $submission->id . '</td>';
            echo '<td>' . esc_html($submission->name) . '</td>';
            echo '<td>' . esc_html($submission->email) . '</td>';
            echo '<td>' . esc_html($submission->phone) . '</td>';
            echo '<td>' . esc_html(substr($submission->message, 0, 100)) . '...</td>';
            echo '<td>' . date_i18n(get_option('date_format'), strtotime($submission->submission_date)) . '</td>';
            echo '<td>' . esc_html($submission->ip_address) . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p>' . __('No submissions yet.', 'modern-contact-form') . '</p>';
    }
    
    echo '</div>';
}

// Add settings page
function modern_contact_form_settings() {
    register_setting('modern_contact_form_settings', 'modern_contact_form_store_submissions');
    
    add_settings_section(
        'modern_contact_form_main',
        __('Contact Form Settings', 'modern-contact-form'),
        'modern_contact_form_section_text',
        'modern-contact-form'
    );
    
    add_settings_field(
        'store_submissions',
        __('Store Submissions', 'modern-contact-form'),
        'modern_contact_form_store_submissions_field',
        'modern-contact-form',
        'modern_contact_form_main'
    );
}
add_action('admin_init', 'modern_contact_form_settings');

function modern_contact_form_section_text() {
    echo '<p>' . __('Configure your contact form settings.', 'modern-contact-form') . '</p>';
}

function modern_contact_form_store_submissions_field() {
    $option = get_option('modern_contact_form_store_submissions');
    echo '<input type="checkbox" id="store_submissions" name="modern_contact_form_store_submissions" value="1" ' . checked(1, $option, false) . ' />';
    echo '<label for="store_submissions">' . __('Store form submissions in database', 'modern-contact-form') . '</label>';
}

// Add settings link to plugin page
function modern_contact_form_settings_link($links) {
    $settings_link = '<a href="admin.php?page=modern-contact-form-submissions">' . __('Submissions', 'modern-contact-form') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'modern_contact_form_settings_link');