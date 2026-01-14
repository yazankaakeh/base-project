@props(['userType' => 'patient'])

<div class="social-login-buttons">
    <div class="divider my-4">
        <div class="divider-text">
            {{ trans('auth::auth.or') }}
        </div>
    </div>

    <div class="d-grid gap-2">
        <!-- Google Login -->
        <a href="{{ route('auth.social.redirect', ['provider' => 'google', 'user_type' => $userType]) }}"
           class="btn btn-outline-danger">
            <i class="fab fa-google me-2"></i>
            {{ trans('auth::auth.login_with_google') }}
        </a>

        <!-- Facebook Login -->
        <a href="{{ route('auth.social.redirect', ['provider' => 'facebook', 'user_type' => $userType]) }}"
           class="btn btn-outline-primary">
            <i class="fab fa-facebook-f me-2"></i>
            {{ trans('auth::auth.login_with_facebook') }}
        </a>

        <!-- X (Twitter) Login -->
        <a href="{{ route('auth.social.redirect', ['provider' => 'x', 'user_type' => $userType]) }}"
           class="btn btn-outline-dark">
            <i class="fab fa-x-twitter me-2"></i>
            {{ trans('auth::auth.login_with_x') }}
        </a>
    </div>
</div>



