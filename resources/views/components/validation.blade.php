<!-- Input validation alert for admin code and password validation -->
@if (session('error'))
    <div id="alert-error" class="alert text-red-600 alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div id="alert-success" class="alert text-green-600 alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Password validation errors -->
@if ($errors->any())
    <div id="alert-errors" class="alert text-red-600 alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    setTimeout(() => {
        const errorAlert = document.getElementById('alert-error');
        const successAlert = document.getElementById('alert-success');
        const validationErrorsAlert = document.getElementById('alert-errors');
        
        if (errorAlert) errorAlert.style.display = 'none';
        if (successAlert) successAlert.style.display = 'none';
        if (validationErrorsAlert) validationErrorsAlert.style.display = 'none';
    }, 3000);
</script>