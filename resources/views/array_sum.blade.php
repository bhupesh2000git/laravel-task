<!DOCTYPE html>
<html>

<head>
    <title>Two Sum Problem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-4">Two Sum Problem (Dynamic)</h2>
            <a href="{{ url('/') }}" class="btn btn-secondary">
                ← Back to Home
            </a>
        </div>

        <form method="POST" action="{{ route('twosum.process') }}">
            @csrf

            <div class="mb-3">
                <label>Enter Numbers (comma separated):</label>
                <input type="text" name="numbers" class="form-control" placeholder="e.g. 2,7,11,15"
                    value="{{ old('numbers', request('numbers')) }}" required>
            </div>

            <div class="mb-3">
                <label>Enter Target:</label>
                <input type="number" name="target" class="form-control" placeholder="e.g. 9"
                    value="{{ old('target', request('target')) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Find Indices</button>
        </form>

        @if(isset($allResults))
            <div class="alert alert-success mt-4">
                <strong>Question:</strong><br>
                Input: nums = [{{ implode(', ', $original_nums) }}], target = {{ $original_target }}<br><br>

                <strong>All Matching Index Pairs:</strong><br>
                <ul>
                    @foreach($allResults as $pair)
                        <li>[{{ $pair[0] }}, {{ $pair[1] }}] ({{ $original_nums[$pair[0]] }} + {{ $original_nums[$pair[1]] }} =
                            {{ $original_target }})
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</body>

</html>