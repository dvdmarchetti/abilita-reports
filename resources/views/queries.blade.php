@extends('layout')

@section('cards')
  <div class="flex flex-wrap xl:mb-4">
    <div class="w-full md:w-6/12 md:px-2 xl:w-3/12 xl:px-4 mb-4">
      <div class="relative flex flex-col min-w-0 break-words w-full h-full mb-6 rounded hover:bg-pink-600 border-2 border-pink-400 hover:border-pink-600" style="transition: all .15s ease">
        <a href="{{ route('dashboard') }}" class="h-full">
          <div class="rounded-t mb-0 p-4 bg-transparent h-full">
            <div class="flex flex-wrap h-full">
              <h6 class="text-pink-200 uppercase font-semibold text-xs">
                {{ __('Import phase') }}
              </h6>
              <div class="text-left w-full self-end">
                <button class="text-white hover:underline font-bold uppercase text-sm outline-none focus:outline-none mr-1 mb-1">
                  <i class="fas fa-chevron-left text-xs"></i> {{ __('Return to Error List') }}
                </button>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <x-card title="Children" :value="$childrenCount" icon="child" color="bg-green-500" />

    <div class="w-full md:w-6/12 md:px-2 xl:w-3/12 xl:px-4 mb-4">
      <div class="relative flex p-4 h-full min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-md">
        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
          <h5 class="text-gray-500 uppercase font-semibold text-xs">{{ __('Families') }}</h5>
          <span class="font-semibold text-4xl text-gray-800">
            {{ $familiesCount }}
            <span class="block text-xs text-gray-600">({{ __(':count with more than a child', ['count' => $familiesWithMoreThanAChildCount]) }})</span>
          </span>
        </div>
        <div class="relative w-auto pl-4 flex-initial">
          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-500">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>

    <x-card title="Services" :value="$servicesCount" icon="cogs" color="bg-purple-500" />
  </div>
@endsection

@section('content')
<div class="flex flex-wrap mt-4 -mt-24">
  <div class="w-full pb-12 xl:mb-0 xl:px-4 md:px-2">
    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-md rounded">
      <div class="rounded-t mb-0 px-4 border-0">
        <div class="flex flex-wrap h-12 items-center">
          <div class="relative w-full max-w-full">
            <h3 class="font-semibold text-base text-gray-800">
              {{ __('Query Results') }}
            </h3>
          </div>
        </div>
      </div>
      <div class="block w-full overflow-x-auto -mt-px">
        <!-- Projects table -->
        <table class="items-center table-auto w-full bg-transparent border-collapse">
          <thead>
            <tr class="h-12">
              {{--
              <th class="px-4 bg-gray-50 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                Key
              </th>
              --}}
              <th class="px-4 bg-gray-50 text-gray-600 align-middle border border-solid border-gray-100 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                {{ __('Question') }}
              </th>
              <th class="md:table-cell hidden px-4 bg-gray-50 text-gray-600 align-middle border border-solid border-gray-100 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                {{ __('Result') }}
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($queries as $key => $query)
              <tr class="odd:bg-white bg-gray-50 w-full md:table-row table">
                <td class="border-t-0 border-l-0 border-r-0 md:table-cell table-row">
                  <div class="sm:block table-cell w-full px-4 align-top border-l-0 border-r-0 text-sm p-4 md:py-4 pb-1 py-2">
                    <p class="text-xs font-semibold text-gray-500">{{ $key }}</p>
                    <p>{{ $query->question() }}</p>
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
  </div>
</div>
@endsection
