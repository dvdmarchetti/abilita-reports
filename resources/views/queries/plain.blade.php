@if ($results instanceof \Illuminate\Support\Collection)
  <ul class="font-mono">
    @foreach ($results as $key => $line)
      <li>{{ $key }}: {{ $line }}</li>
    @endforeach
  </ul>
@else
  <span class="font-mono">{{ $results }}</span>
@endif