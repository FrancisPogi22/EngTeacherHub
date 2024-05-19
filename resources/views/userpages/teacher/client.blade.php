<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
</head>

<body>
    @include('partials.header')
    <section id="client">
        <div class="wrapper">
            <div class="client-con">
                <h2>Clients</h2>
                <div class="client-list-con">
                    @foreach ($clients as $client)
                        <div class="client-widget">
                            <img src="{{ asset('/profiles/' . $client->client_profile) }}" alt="Image">
                            <h4>{{ $client->client_name }}</h4>
                            <div class="date-con">
                                <p>Start Date: {{ \Carbon\Carbon::parse($client->start_date)->format('F d, Y') }}</p>
                                <p>End Date: {{ \Carbon\Carbon::parse($client->end_date)->format('F d, Y') }}</p>
                            </div>
                            <div class="btn-con">
                                <button class="btn-primary removeBtn" data-id="{{ $client->user_id }}">Remove</button>
                                <button class="btn-primary doneBtn" data-id="{{ $client->id }}">Done</button>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.doneBtn').on('click', function() {
            let widget = $(this);

            $.ajax({
                url: "{{ route('done.clients') }}",
                method: "PATCH",
                data: {
                    id: $(this).data('id')
                },
                success(response) {
                    if (response.status == "warning") {
                        showInfoMessage(response.message);
                    } else {
                        widget.closest('.client-widget').remove();
                        showSuccessMessage("Successfully Updated.");
                    }
                },
                error() {
                    showErrorMessage();
                }
            });
        });

        $('.removeBtn').on('click', function() {
            let widget = $(this);

            $.ajax({
                url: "{{ route('remove.clients') }}",
                method: "DELETE",
                data: {
                    id: $(this).data('id')
                },
                success(response) {
                    if (response.status == "warning") {
                        showInfoMessage(response.message);
                    } else {
                        widget.closest('.client-widget').remove();
                        showSuccessMessage("Successfully Removed.");
                    }
                },
                error() {
                    showErrorMessage();
                }
            });
        });
    </script>
</body>

</html>
