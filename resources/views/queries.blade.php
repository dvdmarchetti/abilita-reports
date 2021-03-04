@extends('layout')

@section('cards')
<div class="flex flex-wrap">
  <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full h-full mb-6 rounded hover:bg-pink-700" style="transition: all .15s ease">
      <a href="{{ route('dashboard') }}" class="h-full">
        <div class="rounded-t mb-0 p-4 bg-transparent h-full">
          <div class="flex flex-wrap h-full">
            <h6 class="text-pink-200 uppercase font-bold text-xs">
              {{ __('Import phase') }}
            </h6>
            <div class="text-left w-full self-end">
              <button class="text-white active:bg-teal-300 hover:underline font-bold uppercase text-sm outline-none focus:outline-none mr-1 mb-1">
                <i class="fas fa-chevron-left text-xs"></i> {{ __('Return to Error List') }}
              </button>
            </div>
          </div>
        </div>
        {{-- <div class="p-4 pt-0 flex-auto text-right">
          <button class="text-white active:bg-teal-300 hover:underline font-bold uppercase text-sm outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
            Visualizza <i class="fas fa-chevron-right text-xs"></i>
          </button>
        </div> --}}
      </a>
    </div>
  </div>

  <x-card title="Children" :value="$childrenCount" icon="child" color="bg-teal-500" />

  <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
    <div class="relative flex p-4 h-full min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-md">
      <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
        <h5 class="text-gray-500 uppercase font-bold text-xs">{{ __('Families') }}</h5>
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
  <div class="w-full mb-12 xl:mb-0 px-4">
    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-md rounded">
      <div class="rounded-t mb-0 px-4 py-3 border-0">
        <div class="flex flex-wrap items-center">
          <div class="relative w-full px-4 max-w-full flex-grow flex-1">
            <h3 class="font-semibold text-base text-gray-800">
              Risultati delle Interrogazioni
            </h3>
          </div>
          {{-- <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
            <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1" type="button" style="transition:all .15s ease">
            See all
            </button>
          </div> --}}
        </div>
      </div>
      <div class="block w-full overflow-x-auto">
        <!-- Projects table -->
        <table class="items-center table-auto w-full bg-transparent border-collapse">
          <thead>
            <tr>
              {{-- <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                Key
              </th> --}}
              <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                {{ __('Question') }}
              </th>
              <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                {{ __('Result') }}
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($queries as $key => $query)
              <tr class="odd:bg-white bg-gray-100">
                <td class="border-t-0 px-6 align-top border-l-0 border-r-0 text-sm whitespace-no-wrap p-4">
                  <p class="text-xs font-semibold text-gray-500">{{ $key }}</p>
                  <p>{{ $query->question() }}</p>
                </td>
                <td class="border-t-0 px-6 align-top border-l-0 border-r-0 text-sm whitespace-no-wrap p-4">
                  {{ $query->view() }}
                </td>
              </tr>
            @empty
              <tr>
                <td class="border-t-0 px-6 align-top border-l-0 border-r-0 text-sm text-center whitespace-no-wrap p-4 text-left" colspan="4">Nessun dato da visualizzare in base ai filtri selezionati.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
