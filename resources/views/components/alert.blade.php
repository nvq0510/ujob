{{-- resources/views/components/alert.blade.php --}}
@if ($errors->any() || session('success') || session('error') || session('warning') || session('info'))
    <div class="alert 
        @if(session('success')) alert-success 
        @elseif(session('error')) alert-danger 
        @elseif(session('warning')) alert-warning 
        @elseif(session('info')) alert-info 
        @elseif($errors->any()) alert-danger 
        @endif 
        alert-dismissible fade show" role="alert">
        
        {{-- Display the appropriate message based on the session key --}}
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ session('success') ?? session('error') ?? session('warning') ?? session('info') }}
        @endif

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<script>
    $(document).ready(function() {
        // Auto-hide the alert after 3 seconds
        let alert = $('.alert-dismissible');
        if (alert.length) {
            setTimeout(function() {
                alert.fadeOut('slow', function() {
                    $(this).remove(); // Remove the alert from the DOM after fading out
                });
            }, 3000);
        }
    });
</script>
