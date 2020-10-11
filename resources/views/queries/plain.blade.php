@if ($results instanceof \Illuminate\Support\Collection)
  <table class="font-mono">
    @foreach ($results as $key => $line)
      <tr>
        <td class="font-bold">{{ $key }}:</td>
        <td class="px-4 text-right">{{ $line }}</td>
      </tr>
    @endforeach
  </table>
@else
  <span class="font-mono">{{ $results }}</span>
@endif