<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
</head>

<body>
    @include('partials.header')
    <section id="welcome">
        <div class="wrapper">
            <div class="welcome-con">
                <div class="welcome-details-con">
                    <h2>EngTeacherHub</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    </p>
                </div>
                <div class="welcome-form-con">
                    <form action="{{ route('login.user') }}" method="POST">
                        @csrf
                        <div class="field-con">
                            <input type="text" name="email" value="{{ !empty(old('email')) ? old('email') : null }}"
                                class="form-control" placeholder="Email" required>
                        </div>
                        <div class="field-con password-toggle">
                            <input type="password" name="password" id="authPassword" class="form-control"
                                placeholder="Password" required>
                            <i class="bi bi-eye-slash" id="toggle-password"></i>
                        </div>
                        <div class="btn-con">
                            <button type="submit" class="btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('partials.plugins')
    @include('partials.script')
    @include('partials.toastr')
    <script>
        $(document).ready(() => {
            $(document).on('click', '#toggle-password', function() {
                const authPassword = $("#authPassword");
                authPassword.attr('type', authPassword.attr('type') == 'password' ? 'text' : 'password');
                $(this).toggleClass("bi-eye-slash bi-eye");
            });
        });
    </script>
</body>

</html>
