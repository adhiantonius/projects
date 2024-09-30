
<h1>Issues</h1>

<ul>
    @foreach($issues as $issue)
        <li>
            {{ $issue->title }} - {{ $issue->description }}
            <a href="{{ route('issues.show', $issue) }}">View</a>
            <a href="{{ route('issues.edit', $issue) }}">Edit</a>
            <form action="{{ route('issues.destroy', $issue) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>