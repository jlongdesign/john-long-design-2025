<?php
/**
 * AJAX Handlers
 */

if (!defined('ABSPATH')) {
    exit;
}

// Enhanced function to get user IP
function jld_get_user_ip() {
    $ip_headers = array(
        'HTTP_CF_CONNECTING_IP',     // Cloudflare
        'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
        'HTTP_X_REAL_IP',            // Nginx proxy
        'HTTP_CLIENT_IP',            // Proxy
        'REMOTE_ADDR'                // Standard fallback
    );
    
    foreach ($ip_headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = $_SERVER[$header];
            // Handle comma-separated IPs
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            // Validate IP
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    
    return '0.0.0.0';
}

// Handle contact form submission
function jld_handle_contact_form() {
    // Verify nonce (ONLY ONCE)
    if (!wp_verify_nonce($_POST['contact_nonce'], 'jld_contact_form')) {
        wp_redirect(home_url('/?contact=error'));
        exit;
    }

    // Honeypot check
    if (!empty($_POST['website'])) {
        wp_redirect(home_url('/?contact=spam'));
        exit;
    }

    // Time-based protection (form must be filled for at least 3 seconds)
    if (isset($_POST['form_timestamp'])) {
        $time_taken = time() - intval($_POST['form_timestamp']);
        if ($time_taken < 3) {
            wp_redirect(home_url('/?contact=spam'));
            exit;
        }
    }

    // Rate limiting (max 5 submissions per hour per IP)
    $user_ip = jld_get_user_ip();
    $rate_limit_key = 'contact_form_' . md5($user_ip);
    $submissions = get_transient($rate_limit_key) ?: 0;
    
    if ($submissions >= 5) {
        wp_redirect(home_url('/?contact=rate_limit'));
        exit;
    }

    // reCAPTCHA verification
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $recaptcha_secret = '6Le0ffMrAAAAAB9qujH_wIEdggZMa7U4UtGvBk3H'; // Replace with your actual secret key
        $recaptcha_response = $_POST['g-recaptcha-response'];
        
        $verify_response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => $recaptcha_secret,
                'response' => $recaptcha_response,
                'remoteip' => $user_ip
            )
        ));
        
        if (!is_wp_error($verify_response)) {
            $verify_result = json_decode(wp_remote_retrieve_body($verify_response), true);
            if (!$verify_result['success']) {
                wp_redirect(home_url('/?contact=error'));
                exit;
            }
        }
    } else {
        wp_redirect(home_url('/?contact=error'));
        exit;
    }
    
    // Sanitize form data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $subject = sanitize_text_field($_POST['contact_subject'] ?? ''); // Handle optional subject
    $message = sanitize_textarea_field($_POST['contact_message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(home_url('/?contact=error'));
        exit;
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_redirect(home_url('/?contact=error'));
        exit;
    }

    // Content-based spam filtering
    $content_to_check = $message . ' ' . $email . ' ' . $name . ' ' . $subject;
    $spam_patterns = array(
        '/\b(viagra|casino|poker|loan|debt|mortgage|insurance|pharmacy|pills)\b/i',
        '/\b(click here|visit now|buy now|act now|limited time)\b/i',
        '/\b(make money|work from home|earn \$|guaranteed income)\b/i',
        '/(.)\1{4,}/', // Repeated characters (aaaaa)
    );
    
    foreach ($spam_patterns as $pattern) {
        if (preg_match($pattern, $content_to_check)) {
            wp_redirect(home_url('/?contact=spam'));
            exit;
        }
    }

    // Block disposable email domains
    $temp_email_domains = array('tempmail.org', '10minutemail.com', 'guerrillamail.com', 'mailinator.com', 'yopmail.com');
    $email_domain = substr(strrchr($email, "@"), 1);
    if (in_array(strtolower($email_domain), $temp_email_domains)) {
        wp_redirect(home_url('/?contact=spam'));
        exit;
    }

    // Increment rate limit counter
    set_transient($rate_limit_key, $submissions + 1, HOUR_IN_SECONDS);
    
    // Prepare email
    $to = get_theme_mod('contact_email', get_option('admin_email'));
    $email_subject = !empty($subject) ? 'Contact: ' . $subject : 'New Contact Form Message from ' . get_bloginfo('name');
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Email body
    $body = '<html><body>';
    $body .= '<h2>New Contact Form Message</h2>';
    $body .= '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
    $body .= '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
    if (!empty($subject)) {
        $body .= '<p><strong>Subject:</strong> ' . esc_html($subject) . '</p>';
    }
    $body .= '<p><strong>Message:</strong></p>';
    $body .= '<div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #0073aa;">';
    $body .= nl2br(esc_html($message));
    $body .= '</div>';
    $body .= '<hr>';
    $body .= '<p><small>This message was sent from the contact form on ' . get_bloginfo('name') . ' (' . home_url() . ')</small></p>';
    $body .= '<p><small>Sender IP: ' . esc_html($user_ip) . '</small></p>';
    $body .= '</body></html>';
    
    // Send email
    $sent = wp_mail($to, $email_subject, $body, $headers);
    
    // Store in database for backup
    jld_store_contact_submission($name, $email, $subject, $message);
    
    // Redirect with success or error message
    if ($sent) {
        wp_redirect(home_url('/?contact=success'));
    } else {
        wp_redirect(home_url('/?contact=error'));
    }
    exit;
}

// Hook for both logged in and non-logged in users
add_action('wp_ajax_jld_contact_form', 'jld_handle_contact_form');
add_action('wp_ajax_nopriv_jld_contact_form', 'jld_handle_contact_form');

// Store contact submissions in database (UPDATED TO INCLUDE SUBJECT)
function jld_store_contact_submission($name, $email, $subject, $message) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    // Create table if it doesn't exist
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        subject varchar(200),
        message text NOT NULL,
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Insert the submission
    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ),
        array('%s', '%s', '%s', '%s')
    );
}

// Admin page functions remain the same...
function jld_contact_admin_menu() {
    add_management_page(
        'Contact Submissions',
        'Contact Form',
        'manage_options',
        'contact-submissions',
        'jld_contact_admin_page'
    );
}
add_action('admin_menu', 'jld_contact_admin_menu');

function jld_contact_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    
    // Handle delete action
    if (isset($_GET['delete']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_submission')) {
        $wpdb->delete($table_name, array('id' => intval($_GET['delete'])), array('%d'));
        echo '<div class="notice notice-success"><p>Submission deleted.</p></div>';
    }
    
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submitted_at DESC");
    
    echo '<div class="wrap">';
    echo '<h1>Contact Form Submissions</h1>';
    
    if (empty($submissions)) {
        echo '<p>No submissions yet.</p>';
    } else {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        
        foreach ($submissions as $submission) {
            echo '<tr>';
            echo '<td>' . esc_html($submission->submitted_at) . '</td>';
            echo '<td>' . esc_html($submission->name) . '</td>';
            echo '<td><a href="mailto:' . esc_attr($submission->email) . '">' . esc_html($submission->email) . '</a></td>';
            echo '<td>' . esc_html($submission->subject ?? 'No subject') . '</td>';
            echo '<td>' . esc_html(wp_trim_words($submission->message, 15)) . '</td>';
            echo '<td>';
            echo '<a href="' . wp_nonce_url(admin_url('tools.php?page=contact-submissions&delete=' . $submission->id), 'delete_submission') . '" onclick="return confirm(\'Are you sure?\')">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    }
    
    echo '</div>';
}
?>