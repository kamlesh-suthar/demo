<table class="table table-bordered" id="customers" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Description</th>
        <th>Published Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($blogs as $blog)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $blog->title }}</td>
            <td>{{ $blog->description }}</td>
            <td>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->toDateString() : null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>