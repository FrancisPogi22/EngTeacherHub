<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
</head>

<body>
    @include('partials.header')
    <section id="profile">
        <div class="wrapper">
            <div class="profile-con">
                <h2>Profile</h2>
                <div class="profile-widget">
                    <img src="{{ asset('/profiles/' . auth()->user()->profile) }}" alt="Profile">
                    <div class="profile-details">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->description }}</p>
                        <p>{{ $year->year }} years experience</p>
                        <p>{{ auth()->user()->category }}</p>
                        <p></p>
                        <button type="button" class="btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editProfile">Edit Profile</button>
                        <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Form</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('edit.profile') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="field-con">
                                                <input type="file" class="form-control" name="profile">
                                            </div>
                                            <div class="field-con">
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Name" value="{{ auth()->user()->name }}" required>
                                            </div>
                                            <div class="field-con">
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Email" value="{{ auth()->user()->email }}" required>
                                            </div>
                                            <div class="field-con">
                                                <input type="number" class="form-control" name="year"
                                                    placeholder="Year" value="{{ $year->year }}" required>
                                            </div>
                                            <div class="field-con">
                                                <select name="type" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ auth()->user()->type == $category->id ? 'selected' : '' }}>
                                                            {{ $category->type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn-primary">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.plugins')
    @include('partials.script')
    @include('partials.toastr')
</body>

</html>
