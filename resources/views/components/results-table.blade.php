<div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-md rounded">
  <div class="rounded-t mb-0 px-4 border-0">
    <div class="flex flex-wrap h-12 items-center">
      <div class="relative w-full max-w-full">
        <h3 class="font-semibold text-base text-gray-800">
          {{ __($title) }}: {{ __('Query Results') }}
        </h3>
      </div>
    </div>
  </div>
  <div class="block w-full overflow-x-auto -mt-px">
    <table class="items-center table-auto w-full bg-transparent border-collapse">
      <thead>
        <tr class="h-12">
          <th class="px-4 bg-gray-200 text-gray-600 align-middle border border-solid border-gray-100 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
            {{ __('Question') }}
          </th>
          <th class="md:table-cell hidden px-4 bg-gray-200 text-gray-600 align-middle border border-solid border-gray-100 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
            {{ __('Result') }}
          </th>
        </tr>
      </thead>
      <tbody>
        @forelse($queries as $key => $query)
          <tr class="odd:bg-white bg-gray-200 w-full md:table-row table">
            <td class="border-t-0 border-l-0 border-r-0 md:table-cell table-row align-top">
              <div class="sm:block table-cell w-full px-4 align-top border-l-0 border-r-0 text-sm p-4 md:py-4 pb-1 py-2">
                <p class="text-xs font-semibold text-gray-500">{{ $key }}</p>
                <p>{{ $loop->iteration }}) {!! $query->question() !!}</p>
              </div>
            </td>
            <td class="border-t-0 border-l-0 border-r-0 md:table-cell table-row">
              <div class="sm:block table-cell w-full align-top border-l-0 border-r-0 text-sm p-4 md:pl-4 md:py-4 pl-16 pt-1 py-2">
                <div class="md:block inline-block">{{ $query->view() }}</div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="border-t-0 px-4 align-top border-l-0 border-r-0 text-sm text-center p-4 whitespace-no-wrap text-left" colspan="4">Nessun dato da visualizzare in base ai filtri selezionati.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
