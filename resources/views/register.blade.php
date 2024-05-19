<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
</head>

<body>
    @include('partials.header')
    <section id="register">
        <div class="wrapper">
            <div class="register-con">
                <div class="register-details-con">
                    <h2>EngTeacherHub</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
                </div>
                <form action="{{ route('register.user') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2>EngTeacherHub</h2>
                    <div class="field-con">
                        <input type="file" name="profile" class="form-control">
                    </div>
                    <div class="field-con">
                        <select name="type" id="type" class="form-control" required>
                            <option value="" disabled hidden selected>Select Type</option>
                            <option value="1">Client</option>
                            <option value="2">Teacher</option>
                        </select>
                    </div>
                    <div class="field-con" id="category" hidden>
                        <select name="category" class="form-control" required>
                            <option value="" disabled hidden selected>Select Category</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Full Time">Full Time</option>
                        </select>
                    </div>
                    <div class="field-con" id="description" hidden>
                        <input type="text" name="description" class="form-control" required placeholder="Description">
                    </div>
                    <div class="field-con" id="rate" hidden>
                        <input type="number" name="rate" class="form-control" required placeholder="Rate">
                    </div>
                    <div class="field-con" id="year" hidden>
                        <input type="number" class="form-control" name="year" placeholder="Year">
                    </div>
                    <div class="field-con">
                        <input type="text" name="name" class="form-control"
                            value="{{ !empty(old('name')) ? old('name') : null }}" placeholder="Name" required>
                    </div>
                    <div class="field-con">
                        <input type="email" name="email" class="form-control"
                            value="{{ !empty(old('email')) ? old('email') : null }}" placeholder="Email" required>
                    </div>
                    <div class="field-con password-toggle">
                        <input type="password" name="password" id="authPassword" class="form-control"
                            placeholder="Password">
                        <i class="bi bi-eye-slash" id="toggle-password"></i>
                    </div>
                    <div class="field-con Cpassword-toggle">
                        <input type="password" name="Cpassword" id="authCPassword" class="form-control"
                            placeholder="Confirm Password">
                        <i class="bi bi-eye-slash" id="toggle-Cpassword"></i>
                    </div>
                    <div class="btn-con">
                        <button type="submit" class="btn-primary">Register</button>
                    </div>
                </form>
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

            $(document).on('click', '#toggle-Cpassword', function() {
                const authPassword = $("#authCPassword");
                authPassword.attr('type', authPassword.attr('type') == 'password' ? 'text' : 'password');
                $(this).toggleClass("bi-eye-slash bi-eye");
            });

            $('#type').change(function() {
                if ($(this).val() == 2) {
                    $('#category').prop('hidden', false);
                    $('#year').prop('hidden', false);
                    $('#rate').prop('hidden', false);
                    $('#description').prop('hidden', false);
                } else {
                    $('#year').prop('hidden', true);
                    $('#category').prop('hidden', true);
                    $('#rate').prop('hidden', true);
                    $('#description').prop('hidden', true);
                }
            });
        });
    </script>
</body>

</html>
