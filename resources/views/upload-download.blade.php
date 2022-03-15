<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload / Download</title>

    <!-- Compressed CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/css/foundation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/regular.min.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compressed JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/js/foundation.min.js"></script>
</head>

<body>
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell small-8 small-offset-2">
                <h3 class="text-center">Upload / Download</h3>

                <div class="card">
                    <div class="card-section">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('store') }}">
                            @csrf
                            {{-- <label for="fileUpload" class="button">Browse</label>
                            <input type="file" id="fileUpload" class="show-for-sr"> --}}
                            <input type="file" id="fileUpload" name="file">
                            <input type="submit" class="button success" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
            @if (Session::has('success'))
                <div class="cell small-8 small-offset-2">
                    <div class="callout success">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                </div>
            @endif
            <div class="cell small-8 small-offset-2">
                <table class="unstriped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($files as $file)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <i class="far fa-file"></i>
                                    <a href="{{ route('download', $file->id) }}">{{ $file->name }}</a>
                                </td>
                                <td>{{ $file->size }}</td>
                                <td>{{ $file->type }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">No files uploaded yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>

</html>
