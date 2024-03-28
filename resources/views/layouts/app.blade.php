<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    To-Do-list
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.2/dist/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {



            $("#AdduserModal").on("hidden.bs.modal", function() {
                $("#AddUser_from")[0].reset();
                $("#hid").val("");
                $("#AddUser_from").validate().resetForm();
            });

            $("#user_modalbtn").on("click", function() {
                $('#AdduserModal').modal('show');
            })


            $(document).on('click', '#submit', function() {
                $('#AdduserModal').modal('hide');
            });




            $('form[id="AddUser_from"]').validate({
                rules: {
                    name: "required",
                    email: "required",
                    password: "required",
                },
                messages: {
                    name: 'This field is required',
                    email: 'This field is required',
                    password: 'This field is required',
                },
                submitHandler: function() {
                    var formData = new FormData($("#AddUser_from")[0]);
                    $.ajax({
                        url: "/add_todo",
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(response) {
                            // console.log('response:', response.msg);
                            alert(response.msg)
                            $('#usertable').DataTable().ajax.reload();
                        }
                    });
                },
            });



            var headers = $('meta[name="csrf-token"]').attr('content');
            let list = $('#usertable').dataTable({
                searching: true,
                paging: true,
                pageLength: 10,
                "ajax": {
                    url: "/todo_list",
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'date_when_created'
                    },
                    {
                        data: 'date_when_updated'
                    },
                    {
                        data: 'action',
                    }
                ],
            });




            $(document).on('click', '.delete', function() {
                var deleteId = this.getAttribute('id');
                $.ajax({
                    type: "post",
                    url: "/delete_todo",
                    data: {
                        _token: $("[name='_token']").val(),
                        id: deleteId
                    },
                    success: function(response) {
                        console.log('response from delete:', response)
                        if (response.status == 0) {
                            alert(response.msg);
                        } else {
                            alert(response.msg);

                        }
                        $('#usertable').DataTable().ajax.reload();
                    },
                });

            });





            $(document).on('click', '.edit', function() {
                var editId = this.getAttribute('id');
                $.ajax({
                    type: "post",
                    url: "/edit",
                    data: {
                        _token: $("[name='_token']").val(),
                        id: editId,
                    },
                    success: function(response) {
                        $('#AdduserModal').modal('show');
                        var data = JSON.parse(response);
                        console.log('data:', data)
                        
                        $('#hid').val(data.id);
                        $('#title').val(data.title);
                        $('#description').val(data.description);
                    },
                });
            });












        })
    </script>
</body>

</html>