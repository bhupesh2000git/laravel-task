<!DOCTYPE html>
<html lang="en">

<head>
    <title>Image Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gallery img {
            width: 100%;
            max-width: 200px;
            border-radius: 8px;
        }
    </style>
</head>

<body class="bg-light py-4">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>📤 Upload Image</h2>
            <a href="{{ url('/') }}" class="btn btn-secondary">
                ← Back to Home
            </a>
        </div>


        <div class="container mb-4">
            <div class="row gx-2 gy-2 align-items-end">
                {{-- Upload Form --}}
                <div class="col-12 col-md-8">
                    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data"
                        class="row g-2">
                        @csrf

                        <div class="col-12 col-sm-6 col-lg-5">
                            <input type="file" name="image" class="form-control" required accept="image/*">
                        </div>

                        <div class="col-12 col-sm-4 col-lg-4">
                            <select name="orientation" class="form-select" required>
                                <option value="">Orientation</option>
                                <option value="portrait">Portrait</option>
                                <option value="landscape">Landscape</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-2 col-lg-3 d-grid">
                            <button type="submit" class="btn btn-success">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Clear All Form --}}
                <div class="col-12 col-md-4">
                    <form action="{{ route('images.clear') }}" method="POST" class="d-grid">
                        @csrf
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete ALL images?');">
                            Clear All
                        </button>
                    </form>
                </div>
            </div>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <hr>

        <h4 class="mb-3">🖼 Uploaded Images</h4>
        <div class="row gallery">
            @php
                $total = count($images);
                $index = 0;
            @endphp

            <div class="row">

                @if($total > 0)
                                @php
                                    $first = $images[0];
                                @endphp

                                {{-- Check if first image is landscape or portrait --}}
                                @if($first->orientation === 'landscape')
                                    {{-- Pattern: L, P+P, L, P+P ... --}}
                                    @while($index < $total)
                                        {{-- 1 Landscape --}}
                                        @if(isset($images[$index]) && $images[$index]->orientation === 'landscape')
                                            <div class="col-md-12 mb-3">
                                                <div class="card p-2">
                                                    <img src="{{ asset('storage/' . $images[$index]->filename) }}" class="img-fluid" alt=""
                                                        width="100%">
                                                    <p class="text-center mt-2">{{ ucfirst($images[$index]->orientation) }}</p>
                                                </div>
                                            </div>
                                            @php $index++; @endphp
                                        @endif

                                        {{-- 2 Portraits --}}
                                        @for($i = 0; $i < 2; $i++)
                                            @if(isset($images[$index]) && $images[$index]->orientation === 'portrait')
                                                <div class="col-md-6 mb-3">
                                                    <div class="card p-2">
                                                        <img src="{{ asset('storage/' . $images[$index]->filename) }}" class="img-fluid" alt=""
                                                            width="100%">
                                                        <p class="text-center mt-2">{{ ucfirst($images[$index]->orientation) }}</p>
                                                    </div>
                                                </div>
                                                @php $index++; @endphp
                                            @endif
                                        @endfor
                                    @endwhile

                                @else
                                    {{-- Pattern: P, L, P, L, P ... --}}
                                    @while($index < $total)
                                        @if(isset($images[$index]) && $images[$index]->orientation === 'portrait')
                                            <div class="col-md-6 mb-3">
                                                <div class="card p-2">
                                                    <img src="{{ asset('storage/' . $images[$index]->filename) }}" class="img-fluid" alt=""
                                                        width="100%">
                                                    <p class="text-center mt-2">{{ ucfirst($images[$index]->orientation) }}</p>
                                                </div>
                                            </div>
                                            @php $index++; @endphp
                                        @endif

                                        @if(isset($images[$index]) && $images[$index]->orientation === 'landscape')
                                            <div class="col-md-12 mb-3">
                                                <div class="card p-2">
                                                    <img src="{{ asset('storage/' . $images[$index]->filename) }}" class="img-fluid" alt=""
                                                        width="100%">
                                                    <p class="text-center mt-2">{{ ucfirst($images[$index]->orientation) }}</p>
                                                </div>
                                            </div>
                                            @php $index++; @endphp
                                        @endif
                                    @endwhile
                                @endif

                @else
                    <p>No images uploaded yet.</p>
                @endif

            </div>

        </div>
    </div>

</body>

</html>