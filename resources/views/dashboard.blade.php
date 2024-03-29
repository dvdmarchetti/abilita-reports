@extends('layout')

@section('cards')
  <div class="flex flex-wrap items-stretch lg:mb-8">
    <div class="w-full lg:w-4/12 lg:mb-0 lg:px-4 mb-4">
      <div class="relative flex flex-col justify-between min-w-0 break-words w-full h-full shadow-md rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full max-w-full flex-grow flex-1">
              <h6 class="uppercase text-gray-500 mb-1 text-xs font-semibold tracking-wide">
                {{ __('Filter') }}
                @if (\Arr::get(request(), 'filter.service') !== null)
                  <a href="{{ request()->fullUrlWithQuery(['filter' => array_merge(request()->query('filter', []), [ 'service' => '' ])]) }}" class="float-right text-red-700 last:mr-0 mr-1 hover:underline">{{ __('Clear filters') }} </a>
                @endif
              </h6>
              <h2 class="text-gray-800 xl:w-4/12 text-xl font-semibold">
                {{ __('Service') }}
              </h2>
            </div>
          </div>
        </div>
        <div class="p-4 pt-0">
          @forelse ($services as $service)
            @if (\Arr::get(request(), 'filter.service') === $service->id)
              <a href="{{ request()->fullUrlWithQuery(['filter' => array_merge(request()->query('filter', []), [ 'service' => $service->id ])]) }}" class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-800 bg-blue-200 last:mr-0 mr-1 mt-1">{{ $service->id }}</a>
            @else
              <a href="{{ request()->fullUrlWithQuery(['filter' => array_merge(request()->query('filter', []), [ 'service' => $service->id ])]) }}" class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-gray-900 bg-gray-100 last:mr-0 mr-1 mt-1 transition duration-100 hover:bg-blue-100">{{ $service->id }}</a>
            @endif
          @empty
            <p>Nessun servizio inserito nel database.</p>
          @endforelse
        </div>
      </div>
    </div>

    <div class="w-full lg:w-4/12 lg:mb-0 lg:px-4 mb-4">
      <div class="relative flex flex-col justify-between min-w-0 break-words w-full h-full mb-6 shadow-md rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full max-w-full flex-grow flex-1">
              <h6 class="uppercase text-gray-500 mb-1 text-xs font-semibold  tracking-wide">
                {{ __('Filter') }}
                @if (\Arr::get(request(), 'filter.spreadsheet') !== null)
                  <a href="{{ request()->fullUrlWithQuery(['filter' => array_merge(request()->query('filter', []), [ 'spreadsheet' => '' ])]) }}" class="float-right text-red-700 last:mr-0 mr-1 hover:underline">{{ __('Clear filters') }}</a>
                @endif
              </h6>
              <h2 class="text-gray-800 text-xl font-semibold">
                {{ __('Spreadsheet') }}
              </h2>
            </div>
          </div>
        </div>
        <div class="p-4 pt-0">
          @foreach (['anagrafica-b', 'servizio'] as $spreadsheet)
            @if (\Arr::get(request(), 'filter.spreadsheet') === $spreadsheet)
              <a href="{{ request()->fullUrlWithQuery(['filter' => array_merge(request()->query('filter', []), [ 'spreadsheet' => $spreadsheet ])]) }}" class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-800 bg-blue-200 last:mr-0 mr-1 mt-1">{{ $spreadsheet }}</a>
            @else
              <a href="{{ request()->fullUrlWithQuery(['filter' => array_merge(request()->query('filter', []), [ 'spreadsheet' => $spreadsheet ])]) }}" class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-gray-800 bg-gray-100 last:mr-0 mr-1 mt-1 transition duration-100 hover:bg-blue-100">{{ $spreadsheet }}</a>
            @endif
          @endforeach
        </div>
      </div>
    </div>

    <div class="w-full lg:w-4/12 lg:mb-0 lg:px-4 mb-4">
      <div class="relative min-w-0 break-words w-full h-full rounded hover:bg-blue-500 border-2 border-blue-300 hover:border-blue-500" style="transition: all .15s ease">
        <a href="{{ route('queries.index') }}" class="flex flex-col justify-between h-full">
          <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
            <div class="flex flex-wrap items-center">
              <div class="relative w-full max-w-full flex-grow flex-1">
                <h6 class="uppercase text-blue-50 mb-1 text-xs font-semibold">
                  {{ __('Analysis') }}
                </h6>
                <h2 class="text-white xl:w-full text-xl font-semibold">
                  {{ __('Query Results') }}
                </h2>
              </div>
            </div>
          </div>
          <div class="p-4 pt-0 text-right">
            <button class="text-white active:bg-teal-300 hover:underline font-bold uppercase text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
              {{ __('Explore') }} <i class="fas fa-chevron-right text-xs"></i>
            </button>
          </div>
        </a>
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="flex flex-wrap">
  <div class="relative w-full mb-12 lg:px-4">
    <div class="flex h-12 font-semibold text-sm uppercase">
      @if ($currentRouteName === 'dashboard.children')
      <a class="rounded-t flex-1 flex items-center justify-center text-blue-400 bg-white z-2">{{ __('Children') }}</a>
      @else
      <a class="rounded-t flex-1 flex items-center justify-center text-gray-100 transition duration-200 hover:text-white hover:bg-blue-300 bg-blue-500" href="{{ route('dashboard.children') }}">{{ __('Children') }}</a>
      @endif

      @if ($currentRouteName === 'dashboard.families')
        <a class="rounded-t flex-1 flex items-center justify-center text-blue-400 bg-white">{{ __('Families') }}</a>
      @else
        <a class="rounded-t flex-1 flex items-center justify-center text-gray-100 transition duration-200 hover:text-white hover:bg-blue-300 bg-blue-500" href="{{ route('dashboard.families') }}">{{ __('Families') }}</a>
      @endif
    </div>
    <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-md z-3">
      <div class="rounded-t mb-0 px-4 border-0">
        <div class="flex flex-wrap h-12 items-center justify-between">
          <h3 class="font-semibold text-base text-gray-800">
            {{ __('Import errors') }} ({{ $logs->count() }})
          </h3>
          <div>
            <form class="hidden sm:inline-block" action="{{ route('imports.cleanup') }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="bg-transparent border-0 inline-block px-3 py-1 text-gray-500 text-sm hover:underline">
                {{ __('Clean all data') }}
              </button>
            </form>
            <form class="inline-block" action="{{ route('imports.run') }}" method="POST">
              @csrf
              <button id="run-import" class="inline-block px-3 py-1 bg-blue-200 text-blue-800 rounded-full font-semibold text-sm hover:underline">
                {{ __('Run import') }}
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="block w-full overflow-x-auto -mt-px">
        <!-- Projects table -->
        <table class="items-center table-auto w-full bg-transparent border-collapse">
          <thead>
            <tr class="h-12 text-gray-600 text-xs uppercase text-left bg-gray-200">
              <th class="px-4 align-middle border border-solid border-gray-100 border-l-0 border-r-0 font-semibold">
                {{ __('Service') }}
              </th>
              <th class="px-4 align-middle border border-solid border-gray-100 border-l-0 border-r-0 font-semibold">
                {{ __('Spreadsheet') }}
              </th>
              @if ($currentRouteName === 'dashboard.families')
                <th class="px-4 align-middle border border-solid border-gray-100 border-l-0 border-r-0 font-semibold">
                  {{ __('Family') }}
                </th>
              @else
                <th class="px-4 align-middle border border-solid border-gray-100 border-l-0 border-r-0 font-semibold">
                  {{ __('Child') }}
                </th>
              @endif
              <th class="hidden lg:table-cell px-4 align-middle border border-solid border-gray-100 border-l-0 border-r-0 font-semibold">
                {{ __('Errors') }}
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $log)
              @if ($loop->index%2 == 0)
                <tr>
              @else
                <tr class="bg-gray-200">
              @endif
                <th class="border-t-0 align-top border-l-0 border-r-0 text-sm p-4 pb-0 lg:pb-4 text-left">
                  {{ $log->service }}
                </th>
                <td class="border-t-0 align-top border-l-0 border-r-0 text-sm p-4 pb-0 lg:pb-4">
                  {{ $log->spreadsheet }}
                </td>
                @if ($currentRouteName === 'dashboard.families')
                  <td class="border-t-0 align-top border-l-0 border-r-0 text-sm p-4 pb-0 lg:pb-4">
                    {{ $log->family }}
                  </td>
                @else
                  <td class="border-t-0 align-top border-l-0 border-r-0 text-sm p-4 pb-0 lg:pb-4">
                    {{ $log->child }}
                  </td>
                @endif
                <td class="hidden lg:table-cell border-t-0 border-l-0 border-r-0 text-sm p-4 pb-0 lg:pb-4">
                  <ul class="list-disc">
                    @foreach ($log->errors as $error)
                      @if (! is_string($error))
                        <li>{{ $error['message'] }}</li>

                        <table class="font-mono table-fixed">
                          <thead>
                            <tr>
                              <th></th>
                              <th class="p-2">{{ __('Existing') }}</th>
                              <th class="p-2">{{ __('Upon insertion') }}</th>
                            </tr>
                          </thead>

                          <tbody>
                            @foreach ($error['existing'] as $prop => $value)
                              @if (array_key_exists($prop, $error['new']))
                                <tr>
                                  <th class="p-2 text-right">{{ $prop }}</th>
                                  <td class="p-2 border">{{ $value }}</td>
                                  <td class="p-2 border">{{ $error['new'][$prop] }}</td>
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <li>{{ $error }}</li>
                      @endif
                    @endforeach
                  </ul>
                </td>
              </tr>
              @if ($loop->index%2 == 0)
                <tr class="lg:hidden border-b border-gray-200">
              @else
                <tr class="bg-gray-50 lg:hidden border-b border-gray-200">
              @endif
                <td colspan="3" class="border-t-0 border-l-0 border-r-0 text-sm p-4 pt-2">
                  <ul class="list-disc pl-4">
                    @foreach ($log->errors as $error)
                      @if (! is_string($error))
                        <li>{{ $error['message'] }}</li>

                        <table class="font-mono table-fixed">
                          <thead>
                            <tr>
                              <th></th>
                              <th class="p-2">{{ __('Existing') }}</th>
                              <th class="p-2">{{ __('Upon insertion') }}</th>
                            </tr>
                          </thead>

                          <tbody>
                            @foreach ($error['existing'] as $prop => $value)
                              @if (array_key_exists($prop, $error['new']))
                                <tr>
                                  <th class="p-2 text-right">{{ $prop }}</th>
                                  <td class="p-2 border">{{ $value }}</td>
                                  <td class="p-2 border">{{ $error['new'][$prop] }}</td>
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <li>{{ $error }}</li>
                      @endif
                    @endforeach
                  </ul>
                </td>
              </tr>
            @empty
              <tr>
                <td class="border-t-0 align-top border-l-0 border-r-0 text-sm text-center p-4" colspan="4">
                  {{ __('No import error has been found matching the selected criteria.') }}
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('custom-scripts')
  <div id="overlay" class="hidden fixed z-10 inset-0 bg-blue-400 bg-opacity-75 h-screen w-screen flex items-center justify-center">
    <img src="{{ asset('res/loader.svg') }}" width="48" />
    <h2 class="text-white text-3xl px-4 font-semibold">{{ __('Loading...') }}</h2>
  </div>
  <script>
    document.getElementById('run-import').addEventListener('click', function () {
      document.getElementById('overlay').classList.remove('hidden');
    });
  </script>
@endpush
