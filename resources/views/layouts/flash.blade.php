@if(session('success'))
    <div class="card" style="border-left:4px solid #2e7d32">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="card" style="border-left:4px solid #c62828">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="card validation-error">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif