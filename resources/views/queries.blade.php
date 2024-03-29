@extends('layout')

@section('cards')
  <div class="flex flex-wrap md:mb-8">
    <div class="w-full md:w-1/3 md:px-4 md:mb-0 mb-4">
      <div class="relative flex flex-col min-w-0 break-words w-full h-full mb-6 rounded hover:bg-blue-500 border-2 border-blue-300 hover:border-blue-500" style="transition: all .15s ease">
        <a href="{{ route('dashboard.children') }}" class="h-full">
          <div class="rounded-t mb-0 p-4 bg-transparent h-full">
            <div class="flex flex-wrap h-full">
              <h6 class="text-blue-50 uppercase font-semibold text-xs tracking-wide">
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

    <x-card title="Children" :value="$childrenCount" icon="child" color="bg-blue-400" />

    <div class="w-full md:w-1/3 md:px-4 md:mb-0 mb-4">
      <div class="relative flex p-4 h-full min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-md">
        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
          <h5 class="text-gray-500 uppercase font-semibold text-xs tracking-wide">{{ __('Families') }}</h5>
          <span class="font-semibold text-4xl text-gray-800">
            {{ $familiesCount }}
          </span>
        </div>
        <div class="relative w-auto pl-4 flex-initial">
          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-400">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="flex flex-wrap mt-4 -mt-24">
  <div class="w-full pb-12 xl:mb-0 md:px-4">
    <x-results-table title="Children" :queries="$childrenQueries"></x-results-table>
    <x-results-table title="Families" :queries="$familiesQueries"></x-results-table>
  </div>
</div>
@endsection
