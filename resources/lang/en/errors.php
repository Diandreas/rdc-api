<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom Error Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines contain custom error messages for the
    | application. These messages are used for various error scenarios.
    |
    */

    // HTTP Status Codes
    '400' => 'Bad Request',
    '401' => 'Unauthorized',
    '403' => 'Forbidden',
    '404' => 'Page Not Found',
    '405' => 'Method Not Allowed',
    '408' => 'Request Timeout',
    '419' => 'Page Expired',
    '422' => 'Unprocessable Entity',
    '429' => 'Too Many Requests',
    '500' => 'Internal Server Error',
    '502' => 'Bad Gateway',
    '503' => 'Service Unavailable',
    '504' => 'Gateway Timeout',

    // Application Errors
    'generic' => 'An error occurred',
    'not_found' => 'Item not found',
    'unauthorized' => 'Unauthorized',
    'forbidden' => 'Forbidden',
    'server_error' => 'Server error',
    'validation_error' => 'Validation errors',
    'file_upload_error' => 'File upload error',
    'file_too_large' => 'File is too large',
    'file_type_not_allowed' => 'File type not allowed',
    'database_error' => 'Database error',
    'network_error' => 'Network error',
    'timeout' => 'Request timeout',
    'maintenance' => 'Maintenance in progress',
    'page_expired' => 'Page expired',
    'csrf_token_invalid' => 'Invalid CSRF token',
    'session_expired' => 'Session expired',
    'login_required' => 'Login required',
    'permission_denied' => 'Permission denied',
    'resource_not_found' => 'Resource not found',
    'method_not_allowed' => 'Method not allowed',
    'too_many_requests' => 'Too many requests',
    'service_unavailable' => 'Service unavailable',

    // Form Errors
    'form_invalid' => 'The form contains errors',
    'form_submission_failed' => 'Form submission failed',
    'required_fields_missing' => 'Required fields are missing',
    'invalid_data_format' => 'Invalid data format',
    'duplicate_entry' => 'This entry already exists',
    'foreign_key_constraint' => 'Foreign key constraint violation',
    'unique_constraint' => 'This value is already taken',

    // File Upload Errors
    'file_not_found' => 'File not found',
    'file_corrupted' => 'File corrupted',
    'file_permission_denied' => 'File permission denied',
    'file_size_exceeded' => 'File size exceeded',
    'file_format_not_supported' => 'File format not supported',
    'file_upload_failed' => 'File upload failed',
    'file_processing_failed' => 'File processing failed',

    // Authentication Errors
    'login_failed' => 'Login failed',
    'invalid_credentials' => 'Invalid credentials',
    'account_locked' => 'Account locked',
    'account_disabled' => 'Account disabled',
    'password_expired' => 'Password expired',
    'password_reset_failed' => 'Password reset failed',
    'email_not_verified' => 'Email not verified',
    'two_factor_required' => 'Two-factor authentication required',
    'two_factor_failed' => 'Two-factor authentication failed',

    // Database Errors
    'connection_failed' => 'Database connection failed',
    'query_failed' => 'Query failed',
    'transaction_failed' => 'Transaction failed',
    'constraint_violation' => 'Constraint violation',
    'deadlock_detected' => 'Deadlock detected',
    'data_integrity_error' => 'Data integrity error',

    // API Errors
    'api_key_invalid' => 'Invalid API key',
    'api_key_expired' => 'API key expired',
    'api_rate_limit_exceeded' => 'API rate limit exceeded',
    'api_endpoint_not_found' => 'API endpoint not found',
    'api_method_not_allowed' => 'API method not allowed',
    'api_unauthorized' => 'API unauthorized',
    'api_forbidden' => 'API forbidden',
    'api_server_error' => 'API server error',

    // Cache Errors
    'cache_failed' => 'Cache failed',
    'cache_key_not_found' => 'Cache key not found',
    'cache_expired' => 'Cache expired',
    'cache_corrupted' => 'Cache corrupted',

    // Queue Errors
    'queue_failed' => 'Queue failed',
    'job_failed' => 'Job failed',
    'job_timeout' => 'Job timeout',
    'job_retry_failed' => 'Job retry failed',

    // Email Errors
    'email_send_failed' => 'Email send failed',
    'email_template_not_found' => 'Email template not found',
    'email_address_invalid' => 'Invalid email address',
    'email_service_unavailable' => 'Email service unavailable',

    // Payment Errors
    'payment_failed' => 'Payment failed',
    'payment_method_invalid' => 'Invalid payment method',
    'payment_gateway_error' => 'Payment gateway error',
    'payment_amount_invalid' => 'Invalid payment amount',
    'payment_refund_failed' => 'Payment refund failed',

    // Security Errors
    'security_violation' => 'Security violation',
    'suspicious_activity' => 'Suspicious activity detected',
    'brute_force_attempt' => 'Brute force attempt detected',
    'malicious_request' => 'Malicious request detected',
    'security_token_invalid' => 'Invalid security token',

    // System Errors
    'system_overload' => 'System overload',
    'memory_limit_exceeded' => 'Memory limit exceeded',
    'disk_space_full' => 'Disk space full',
    'service_unavailable' => 'Service unavailable',
    'configuration_error' => 'Configuration error',
    'environment_error' => 'Environment error',

    // User-friendly Messages
    'something_went_wrong' => 'Something went wrong',
    'please_try_again' => 'Please try again',
    'contact_support' => 'Contact technical support',
    'check_your_input' => 'Check your input',
    'refresh_page' => 'Refresh the page',
    'clear_cache' => 'Clear cache',
    'check_connection' => 'Check your connection',
    'try_later' => 'Try again later',
];
