<table class="font-mono table-fixed">
  <thead>
    <tr>
      <th>Servizio/Mesi</th>
      @for ($i = 1; $i <= 12; $i++)
        <th class="p-2 text-right">{{ $i }}</th>
      @endfor
    </tr>
  </thead>

  <tbody>
    @foreach ($results as $service => $months)
      <tr>
        <th class="p-2 text-right">{{ $service }}</th>
        @for ($i = 1; $i <= 12; $i++)
          <td class="p-2 border border-gray-400 text-right">{{ $months->get($i, '-') }}</td>
        @endfor
      </tr>
    @endforeach
  </tbody>
</table>
