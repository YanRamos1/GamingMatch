@if($message = session('message'))
    <script>
        new BsToast({
                    title: "{{ session('title') }}",
                    content: '{!! $message !!}',
                    type: "{{ session('type') }}",
                    pause_on_hover: true,
                    delay: 5000,
                    position: 'top-right',
                });
    </script>
@endif