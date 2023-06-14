<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page - Central Bank System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    @include('common.top-notification-panel')
    <div class="container-fluid">
        @if (Session::has('errorAlert'))
            <div id="notification-alert" style="position: fixed; top: 10px; left:0; z-index: 9999; width: 100%;"
                class="px-5">
                <div class="d-flex flex-column justify-content-center pt-2 px-5">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div>{{ Session::get('errorAlert') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <script>
                    // to trigger the notification removal from the timer
                    setTimeout(() => {
                        const notificationAlert = document.getElementById('notification-alert');
                        notificationAlert.style.display = 'none';
                    }, 3000);
                </script>
            </div>
        @endif
        <div class="row justify-content-center pt-5">
            <div class="col-md-4 border p-5">
                <h1 class="text-center">Central Bank System</h1>
                <form action="/sign-in" method="POST">
                    @csrf
                    <div class="form-group p-2">
                        <label for="username">Member Code</label>
                        <input type="text" class="form-control" name="member_code" id="username"
                            placeholder="Enter username" required>
                    </div>
                    <div class="form-group p-2">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                            placeholder="Enter username" required>
                    </div>
                    <div class="form-group p-2">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Enter password" required>
                    </div>
                    <div class="p-2">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
