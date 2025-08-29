# Forgot Password API Documentation

## Overview
This system provides a secure 3-step password reset process using OTP (One-Time Password) sent via email.

## Flow Diagram
```
User Request → Send OTP → Validate OTP → Reset Password → Success
     ↓              ↓           ↓           ↓
  Enter Email   Email OTP   Enter OTP   New Password
```

## API Endpoints

### 1. Send OTP for Password Reset
**Endpoint:** `POST /api/forgot-password`

**Request Body:**
```json
{
    "email": "user@example.com"
}
```

**Response (Success):**
```json
{
    "error": false,
    "message": "OTP sent successfully. Please check your email.",
    "status_code": 200,
    "data": {
        "email": "user@example.com"
    }
}
```

**Response (Error - Email not found):**
```json
{
    "error": true,
    "message": "Validation failed",
    "status_code": 422,
    "data": {
        "errors": {
            "email": ["No account found with this email address."]
        }
    }
}
```

**Validations:**
- ✅ Email is required
- ✅ Email must be valid format
- ✅ Email must exist in users table
- ✅ Email max length: 255 characters

---

### 2. Validate OTP Code
**Endpoint:** `POST /api/validate-otp`

**Request Body:**
```json
{
    "email": "user@example.com",
    "otp": "123456"
}
```

**Response (Success):**
```json
{
    "error": false,
    "message": "OTP validated successfully.",
    "status_code": 200,
    "data": {
        "email": "user@example.com",
        "reset_token": "abc123def456...",
        "message": "OTP validated successfully. You can now reset your password."
    }
}
```

**Response (Error - Invalid OTP):**
```json
{
    "error": true,
    "message": "Invalid OTP code.",
    "status_code": 422,
    "data": []
}
```

**Response (Error - Expired OTP):**
```json
{
    "error": true,
    "message": "OTP has expired. Please request a new one.",
    "status_code": 422,
    "data": []
}
```

**Validations:**
- ✅ Email is required and must be valid
- ✅ OTP is required and must be exactly 6 characters
- ✅ OTP must exist and not be expired
- ✅ OTP must not have been used before

---

### 3. Reset Password
**Endpoint:** `POST /api/reset-password`

**Request Body:**
```json
{
    "email": "user@example.com",
    "reset_token": "abc123def456...",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response (Success):**
```json
{
    "error": false,
    "message": "Password reset successfully.",
    "status_code": 200,
    "data": []
}
```

**Response (Error - Invalid Token):**
```json
{
    "error": true,
    "message": "Invalid or expired reset token.",
    "status_code": 422,
    "data": []
}
```

**Validations:**
- ✅ Email is required and must exist
- ✅ Reset token is required and must be valid
- ✅ Password is required (min 8 characters)
- ✅ Password confirmation must match password

---

## Security Features

### OTP Security
- **6-digit numeric OTP** generated randomly
- **10-minute expiration** time
- **Single-use only** - OTP becomes invalid after use
- **Rate limiting** - Previous OTPs are deleted when requesting new ones

### Token Security
- **60-character random reset token** generated after OTP validation
- **5-minute expiration** time stored in cache
- **One-time use** - Token becomes invalid after password reset
- **Cache-based storage** for temporary security

### Email Security
- **Professional email template** with security warnings
- **No sensitive data** in email body
- **Clear expiration information** provided to user

---

## Database Schema

### Password Reset OTPs Table
```sql
CREATE TABLE password_reset_otps (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    otp VARCHAR(6) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    is_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX email_index (email)
);
```

---

## Complete Flow Example

### Step 1: Request OTP
```bash
curl -X POST http://your-domain.com/api/forgot-password \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com"}'
```

### Step 2: Check Email & Get OTP
User receives email with 6-digit OTP code.

### Step 3: Validate OTP
```bash
curl -X POST http://your-domain.com/api/validate-otp \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "otp": "123456"}'
```

### Step 4: Reset Password
```bash
curl -X POST http://your-domain.com/api/reset-password \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "reset_token": "abc123def456...",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
  }'
```

---

## Error Handling

### Common Error Scenarios
1. **Email not found** - User doesn't exist in system
2. **Invalid OTP** - Wrong OTP code entered
3. **Expired OTP** - OTP has passed 10-minute limit
4. **Used OTP** - OTP already used for previous reset
5. **Invalid reset token** - Token expired or doesn't match
6. **Password mismatch** - Confirmation doesn't match new password

### HTTP Status Codes
- **200** - Success
- **401** - Unauthorized
- **422** - Validation Error
- **404** - Not Found
- **500** - Internal Server Error

---

## Configuration Requirements

### Email Configuration
Ensure your `.env` file has proper email settings:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Cache Configuration
The system uses Laravel's cache system for storing reset tokens. Ensure cache is properly configured in your `.env` file.

---

## Testing the System

### Test Data
1. **Register a user** using `/api/register`
2. **Request OTP** using `/api/forgot-password`
3. **Check email** for OTP code
4. **Validate OTP** using `/api/validate-otp`
5. **Reset password** using `/api/reset-password`
6. **Test login** with new password using `/api/login`

### Testing Tools
- **Postman** - API testing
- **Insomnia** - API testing
- **cURL** - Command line testing
- **Laravel Tinker** - Database verification

---

## Maintenance & Monitoring

### Cleanup Tasks
- **Expired OTPs** are automatically handled by expiration logic
- **Used OTPs** remain in database for audit purposes
- **Cache tokens** automatically expire after 5 minutes

### Monitoring Points
- **Email delivery success rate**
- **OTP generation frequency**
- **Password reset success rate**
- **Failed validation attempts**

---

## Troubleshooting

### Common Issues
1. **OTP not received** - Check email configuration and spam folder
2. **OTP validation fails** - Ensure OTP is entered within 10 minutes
3. **Reset token invalid** - Check if 5-minute window has passed
4. **Email not found** - Verify user exists in database

### Debug Steps
1. Check Laravel logs in `storage/logs/laravel.log`
2. Verify database connection and table structure
3. Test email configuration with simple mail test
4. Check cache configuration and availability

---

## Security Best Practices

1. **Never log OTP codes** in application logs
2. **Use HTTPS** for all API communications
3. **Implement rate limiting** for OTP requests
4. **Monitor failed attempts** for potential abuse
5. **Regular security audits** of the password reset flow
6. **Educate users** about security best practices

---

## Support & Contact

For technical support or questions about this API system, please contact the development team.

**Version:** 1.0  
**Last Updated:** January 2025  
**Framework:** Laravel 10.x
