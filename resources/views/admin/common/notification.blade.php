<script>

     @php
        $notyfConfig = [
            'position' => [
                'x' => 'right',
                'y' => 'top',
            ],
            'duration' => 5000,
        ];
    @endphp

    @if (Session::has('success'))
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'success',
                background: '#262B40',
                icon: {
                    // className: 'fas fa-comment-dots',
                    className: 'fas fa-check-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: true
            }],
            duration: 5000,
        });

        notyf.open({
            type: 'success',
            message: '{{ Session::get('success') }}'
        });
    @endif

    @if (Session::has('error'))
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#FA5252',
                icon: {
                    // className: 'fas fa-times',
                    className: 'fas fa-ban',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: true
            }],
            duration: 5000,
        });
        notyf.open({
            type: 'error',
            message: '{{ Session::get('error') }}'
        });
    @endif

    @if (Session::has('warning'))
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'warning',
                background: '#F5B759',
                icon: {
                    className: 'fas fa-exclamation-triangle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: true
            }],
            duration: 5000,
        });
        notyf.open({
            type: 'warning',
            message: '{{ Session::get('warning') }}'
        });
    @endif


    @if (session('status'))
        const notyfStatus = new Notyf(<?php echo json_encode($notyfConfig); ?>);
        notyfStatus.options.types.push({
            type: 'info', // Or 'success', depending on how you want to style it
            // background: '#6c757d', // A neutral background color
            background: '#262B40', // A neutral background color
            icon: {
                // className: 'fas fa-info-circle', // Or a checkmark if it's a success status
                className: 'fas fa-check-circle',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: true
        });
        notyfStatus.open({
            type: 'info', // Or 'success'
            message: '{{ session('status') }}'
        });
    @endif

    // @if ($errors->any())
    //     const notyfErrorBag = new Notyf(<?php echo json_encode($notyfConfig); ?>);
    //     notyfErrorBag.options.types.push({
    //         type: 'error',
    //         background: '#dc3545', // Standard error background
    //         icon: {
    //             className: 'fas fa-times-circle',
    //             tagName: 'span',
    //             color: '#fff'
    //         },
    //         dismissible: true
    //     });
    //     @foreach ($errors->all() as $error)
    //         notyfErrorBag.open({
    //             type: 'error',
    //             message: '{{ $error }}'
    //         });
    //     @endforeach
    // @endif
</script>
