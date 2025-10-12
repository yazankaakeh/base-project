# Auth Module - Translation & Module Organization Guide

## Overview
The Auth Module has been created with complete authentication flows for both Doctors and Patients, including:
- Login/Logout
- Registration (Patients only)
- Password Reset
- Email Verification

## Translation System

### Supported Languages (LanguageEnum)
- English (en)
- Arabic (ar)
- Turkish (tr)

### Translation Files Location
```
Modules/Auth/lang/
├── en/auth.php
├── ar/auth.php
└── tr/auth.php
```

### Using Translations in Views
Always use `trans()` instead of `__()` with the module namespace:

```blade
{{-- Good ✓ --}}
{{ trans('auth::auth.doctor_login') }}
{{ trans('auth::auth.email') }}

{{-- Bad ✗ --}}
{{ __('Doctor Login') }}
{{ __('email') }}
```

## Module Structure

### Auth Module (Modules/Auth/)
**Purpose**: Authentication for Doctors and Patients only

**Contains**:
- Doctor Authentication (login, password reset, email verification)
- Patient Authentication (login, registration, password reset, email verification)
- Auth-specific translation files
- Auth controllers, actions, requests, middleware

**Does NOT contain**:
- Landing pages
- Blog views
- Public/frontend content

### Website Module (Modules/Website/)
**Purpose**: All public-facing frontend content

**Should contain**:
- Landing pages
- Blog listing/viewing (frontend)
- Public pages
- Marketing content
- Contact forms

## File Locations

### Auth Module Files
```
Modules/Auth/
├── app/
│   ├── Actions/
│   │   ├── Doctor/LoginAction.php
│   │   └── Patient/LoginAction.php, RegisterAction.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Doctor/LoginController.php, ForgotPasswordController.php, etc.
│   │   │   └── Patient/LoginController.php, RegisterController.php, etc.
│   │   └── Requests/
│   │       ├── Doctor/LoginRequest.php
│   │       └── Patient/LoginRequest.php, RegisterRequest.php
│   └── Http/Middleware/
│       ├── RedirectIfAuthenticatedDoctor.php
│       └── RedirectIfAuthenticatedPatient.php
├── resources/views/
│   ├── doctor/
│   │   ├── login.blade.php
│   │   ├── forgot-password.blade.php
│   │   ├── reset-password.blade.php
│   │   └── verify-email.blade.php
│   └── patient/
│       ├── login.blade.php
│       ├── register.blade.php
│       ├── forgot-password.blade.php
│       ├── reset-password.blade.php
│       └── verify-email.blade.php
├── routes/web.php
└── lang/
    ├── en/auth.php
    ├── ar/auth.php
    └── tr/auth.php
```

## Routes

### Doctor Routes
- `/doctor/login` - Login form
- `/doctor/logout` - Logout (POST)
- `/doctor/forgot-password` - Password reset request
- `/doctor/reset-password/{token}` - Password reset form
- `/doctor/verify-email` - Email verification notice

### Patient Routes
- `/patient/login` - Login form
- `/patient/register` - Registration form
- `/patient/logout` - Logout (POST)
- `/patient/forgot-password` - Password reset request
- `/patient/reset-password/{token}` - Password reset form
- `/patient/verify-email` - Email verification notice

## Translation Keys

### Common Keys
- `app_name`, `email`, `password`, `confirm_password`
- `remember_me`, `sign_in`, `sign_up`, `logout`
- `back_to_login`

### Doctor-Specific Keys
- `doctor_login`, `doctor_login_subtitle`
- `are_you_patient`, `patient_login`

### Patient-Specific Keys
- `patient_login`, `patient_registration`
- `new_on_platform`, `create_account`
- `already_have_account`, `sign_in_instead`

### Password Reset Keys
- `forgot_password_title`, `forgot_password_subtitle`
- `send_reset_link`, `reset_password`, `new_password`

### Email Verification Keys
- `verify_email`, `verify_email_message`
- `did_not_receive_email`, `request_another`

### Success/Error Messages
- `welcome_back`, `account_created`, `logged_out`
- `password_reset_sent`, `email_verified`
- `invalid_credentials`, `account_inactive`

## Configuration

### Auth Guards (config/auth.php)
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'patients',
    ],
    'doctor' => [
        'driver' => 'session',
        'provider' => 'doctors',
    ],
],

'passwords' => [
    'patients' => [
        'provider' => 'patients',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
    'doctors' => [
        'provider' => 'doctors',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
],
```

## Best Practices

### 1. Always Use Translations
```blade
{{-- Good ✓ --}}
<h4>{{ trans('auth::auth.doctor_login') }}</h4>
<label>{{ trans('auth::auth.email') }}</label>

{{-- Bad ✗ --}}
<h4>Doctor Login</h4>
<label>Email</label>
```

### 2. Module Separation
- Auth Module = Authentication only
- Website Module = Public frontend
- Blog Module = Blog management (admin)
- Keep concerns separated

### 3. Controllers Follow Architecture
```php
// Thin controllers
public function login(LoginRequest $request, LoginAction $action)
{
    $action->handle($request->validated());
    return redirect()->route('doctor.dashboard');
}
```

### 4. Use Form Requests
- All validation in Form Request classes
- Never validate in controllers

### 5. Business Logic in Actions
- Actions handle all business logic
- Controllers only orchestrate

## Adding New Translations

1. Add key to all language files (`en`, `ar`, `tr`)
2. Use in blade views with `trans('auth::auth.key_name')`
3. Test in all languages

Example:
```php
// lang/en/auth.php
'new_key' => 'New Translation',

// lang/ar/auth.php
'new_key' => 'ترجمة جديدة',

// lang/tr/auth.php
'new_key' => 'Yeni Çeviri',
```

## Testing Authentication

```bash
# Visit routes
http://localhost/doctor/login
http://localhost/patient/login
http://localhost/patient/register

# Test password reset
# Test email verification
# Test multi-language support
```