<div id="notification-alert" style="position: fixed; top: 10px; left:0; z-index: 9999; width: 100%;" class="px-5">
    {{-- @if ($error->any())
        @foreach ($error->all() as $error)
            <div class="d-flex flex-column justify-content-center pt-2 px-5">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>{{ $error }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endforeach
    @endif
    <script>
        // to trigger the notification removal from the timer
        setTimeout(() => {
            const notificationAlert = document.getElementById('notification-alert');
            notificationAlert.style.display = 'none';
        }, 3000);
    </script> --}}
</div>
