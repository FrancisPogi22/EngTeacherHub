<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
</head>

<body>
    @include('partials.header')
    <section id="inquiries">
        <div class="wrapper">
            <div class="inquiries-con">
                <h2>Inquiries</h2>
                <div class="inquiries-list">
                    @foreach ($bookings as $book)
                        <div class="inquiries-widget">
                            <img src="{{ asset('/profiles/' . $book->teacher_profile) }}" alt="Image">
                            <div class="inquiries-details">
                                <h4>Teacher: {{ $book->teacher_name }}</h4>
                                <p>Status: {{ $book->status }}</p>
                            </div>
                            <div class="date-con">
                                <p>Start Date: {{ \Carbon\Carbon::parse($book->start_date)->format('F d, Y') }}</p>
                                <p>End Date: {{ \Carbon\Carbon::parse($book->end_date)->format('F d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @include('partials.plugins')
    @include('partials.script')
    @include('partials.toastr')
</body>

</html>
