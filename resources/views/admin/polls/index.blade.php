@foreach($polls as $poll)
    <div>
        <p>{{ $poll->question }}</p>
    </div>
@endforeach