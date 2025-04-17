<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>K Closest Elements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-4">Find K Closest Elements</h2>
            <a href="{{ url('/') }}" class="btn btn-secondary">
                ← Back to Home
            </a>
        </div>

        <form method="POST" action="{{ route('kclosest') }}">
            @csrf

            <div class="mb-3">
                <label>Enter Sorted Numbers (comma separated):</label>
                <input type="text" name="numbers" class="form-control" placeholder="e.g. 1,2,3,4,5"
                    value="{{ old('numbers', request('numbers')) }}" required>
                @error('numbers') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Enter k (how many closest):</label>
                <input type="number" name="k" class="form-control" placeholder="e.g. 4"
                    value="{{ old('k', request('k')) }}" required>
                @error('k') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Enter x (target):</label>
                <input type="number" name="x" class="form-control" placeholder="e.g. 3"
                    value="{{ old('x', request('x')) }}" required>
                @error('x') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Compute</button>
        </form>

        @if(isset($result))
            <div class="alert alert-info mt-4">
                <strong>Question:</strong><br>
                arr = [{{ implode(', ', $original_nums) }}],
                k = {{ $original_k }},
                x = {{ $original_x }}<br><br>

                <strong>Output:</strong> [{{ implode(', ', $result) }}]
            </div>
        @endif
    </div>
</body>

</html>