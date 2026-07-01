@if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end', // Muncul di pojok kanan atas
            showConfirmButton: false, // Menghilangkan tombol OK
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            customClass: {
                popup: 'rounded-2xl shadow-lg border border-gray-100'
            }
        });
    </script>
@endif

@if(session('error'))
    <script>
        const ToastError = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });

        ToastError.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            customClass: {
                popup: 'rounded-2xl shadow-lg border border-gray-100'
            }
        });
    </script>
@endif