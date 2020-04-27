@extends('layout')

@section('cards')
<div class="flex flex-wrap">
  <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 rounded hover:bg-pink-700" style="transition: all .15s ease">
      <a href="{{ route('dashboard') }}">
        <div class="rounded-t mb-0 p-4 bg-transparent">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full max-w-full flex-grow flex-1">
              <h6 class="text-pink-200 uppercase font-bold text-xs">
                Import phase
              </h6>
              <h2 class="text-white xl:w-full text-2xl font-semibold">
                <i class="fas fa-chevron-left text-base"></i> Return to Error List
              </h2>
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
  <x-card title="Families" :value="$familiesCount" icon="users" color="bg-blue-500" />
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
              <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                Key
              </th>
              <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                Question
              </th>
              <th class="px-6 bg-gray-100 text-gray-600 align-middle border border-solid border-gray-200 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-no-wrap font-semibold text-left">
                Results
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($queries as $key => $query)
              <tr class="odd:bg-white bg-gray-100">
                <th class="border-t-0 px-6 align-top border-l-0 border-r-0 text-sm whitespace-no-wrap p-4 text-left">
                  {{ $key }}
                </th>
                <td class="border-t-0 px-6 align-top border-l-0 border-r-0 text-sm whitespace-no-wrap p-4">
                  {{ $query->question() }}
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

<footer class="block py-4">
  <div class="container mx-auto px-4">
    <hr class="mb-4 border-b-1 border-gray-300" />
    <div class="flex flex-wrap items-center md:justify-between justify-center">
      <div class="w-full md:w-4/12 px-4">
        <div class="text-sm text-gray-600 font-semibold py-1">
        </div>
      </div>
    </div>
  </div>
</footer>
@endsection
