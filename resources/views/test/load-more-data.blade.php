<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Load More Data AJAX</title>
    <link rel="stylesheet" href="{{ asset('assets/site/css/bootstrap.min.css') }}">

    <script src="{{ asset('assets/site/js/jquery-1.11.1.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Load More Data AJAX</h1>
        @csrf
        <div id="categoryData"></div>
    </div>


    <script>
        var token = $('input[name="_token"]').val();

        load_more('', token);

        function load_more(id = "", token) {
            $.ajax({
                url: '{{ route('load-more-data') }}',
                method: 'POST',
                data: { id: id, _token: token },
                success: function (data) {
                    $('#loadMoreButton').remove();
                    $('#categoryData').append(data);
                }
            });
        }

        $('body').on('click', '#loadMoreButton', function () {
            var id = $(this).data('id');

            $('#loadMoreButton').html("Lodding...");
            load_more(id, token);
        });


    </script>
</body>
</html>
