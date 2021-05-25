<table class="font-mono table-fixed">
  <thead>
    <tr>
      <th>Servizio/Anni</th>
      @for ($i = 1; $i <= $column_count; $i++)
        <th class="p-2 text-right">{{ $i }}</th>
      @endfor
    </tr>
  </thead>

  <tbody>
    @foreach ($results as $service => $years)
      <tr>
        <th class="p-2 text-right">{{ $service }}</th>
        @for ($i = 1; $i <= $column_count; $i++)
          <td class="p-2 border border-gray-400 text-right">{{ $years->get($i, '-') }}</td>
        @endfor
      </tr>
    @endforeach
  </tbody>
</table>
