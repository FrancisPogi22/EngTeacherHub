<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
</head>

<body>
    @include('partials.header')
    <div id="teacher">
        <div class="wrapper">
            <div class="teacher-con">
                <div class="header-con">
                    <h2>Teachers</h2>
                    <div class="filter-con">
                        <select name="category" class="form-control" id="category">
                            <option value="" selected hidden disabled>Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->type }}">{{ $category->type }}</option>
                            @endforeach
                        </select>
                        <select name="filter" class="form-control" id="filter">
                            <option value="" disabled hidden selected>Filter by experience</option>
                            <option value="1-3">1-3 years</option>
                            <option value="3-5">3-5 years</option>
                            <option value="5-10">5-10 years</option>
                            <option value="10-50">10-50 years</option>
                        </select>
                    </div>
                </div>
                <div class="teacher-list-con">
                </div>
                <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('edit.client.profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="field-con">
                                        <input type="file" name="profile" class="form-control">
                                    </div>
                                    <div class="field-con">
                                        <input type="text" name="name" value="{{ auth()->user()->name }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="field-con">
                                        <input type="email" name="email" class="form-control"
                                            value="{{ auth()->user()->email }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="bookModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('book.teacher') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="number" name="teacherID" id="teacherID" hidden>
                                    <div class="field-con">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" name="start_date" class="form-control"
                                            placeholder="Start Date" required>
                                    </div>
                                    <div class="field-con">
                                        <label for="end_date">End Date</label>
                                        <input type="date" name="end_date" class="form-control"
                                            placeholder="End Date" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn-primary">Book Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.plugins')
    @include('partials.script')
    @include('partials.toastr')
    <script>
        initProducts();

        $("#category").change(function() {
            changeCategory();
        });

        $("#filter").change(function() {
            filterTeacher();
        });

        $(document).on('click', '#bookBtn', function() {
            $('#teacherID').val($(this).data('id'));
        });

        function filterTeacher() {
            let filter = $("#filter").val();

            $.ajax({
                url: '{{ route('filter.teacher') }}',
                type: 'GET',
                data: {
                    filter: filter
                },
                success: function(response) {
                    $('.teacher-list-con').empty();
                    response.teachers.forEach(teacher => {
                        $('.teacher-list-con').append(`
                            <div class="teacher-widget">
                                <img src="{{ asset('/profiles/${teacher.profile}') }}" alt="Image">
                                <div class="teacher-details">
                                    <h4>${teacher.name}</h4>
                                    <p>${teacher.description}</p>
                                    <p>₱${teacher.rate}</p>
                                    <p>${teacher.category}</p>
                                </div>
                                <button type="button" class="btn-primary" data-bs-toggle="modal" id="bookBtn"
                                    data-id="${teacher.id}" data-bs-target="#bookModal">Book Now</button>
                            </div>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function changeCategory() {
            let category = $("#category").val();

            $.ajax({
                url: '{{ route('get.teacher.category') }}',
                type: 'GET',
                data: {
                    category: category
                },
                success: function(response) {
                    $('.teacher-list-con').empty();
                    response.teachers.forEach(teacher => {
                        $('.teacher-list-con').append(`
                            <div class="teacher-widget">
                                <img src="{{ asset('/profiles/${teacher.profile}') }}" alt="Image">
                                <div class="teacher-details">
                                    <h4>${teacher.name}</h4>
                                    <p>${teacher.description}</p>
                                    <p>₱${teacher.rate}</p>
                                    <p>${teacher.category}</p>
                                </div>
                                <button type="button" class="btn-primary" data-bs-toggle="modal" id="bookBtn"
                                    data-id="${teacher.id}" data-bs-target="#bookModal">Book Now</button>
                            </div>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function initProducts() {
            $.ajax({
                url: '{{ route('get.teacher') }}',
                method: "GET",
                success(response) {
                    response.teachers.forEach(teacher => {
                        console.log(teacher);
                        $('.teacher-list-con').append(`
                            <div class="teacher-widget">
                                <img src="{{ asset('/profiles/${teacher.profile}') }}" alt="Image">
                                <div class="teacher-details">
                                    <h4>${teacher.name}</h4>
                                    <p>${teacher.description}</p>
                                    <p>₱${teacher.rate}</p>
                                    <p>${teacher.category}</p>
                                </div>
                                <button type="button" class="btn-primary" data-bs-toggle="modal" id="bookBtn"
                                    data-id="${teacher.id}" data-bs-target="#bookModal">Book Now</button>
                            </div>
                        `);
                    });
                }
            });
        }
    </script>
</body>

</html>
