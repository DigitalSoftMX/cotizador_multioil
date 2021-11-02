@push('js')
    @if (session('status'))
        <script>
            color = "{{ session('color') ?? 'primary' }}";
            message = "{{ session('status') }}";
            $.notify({
                message: message
            }, {
                type: color,
                timer: 3000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        </script>
    @endif
@endpush
