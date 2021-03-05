<div class="w-full md:w-6/12 md:px-2 xl:w-3/12 lg:px-4 mb-4">
  <div class="relative flex p-4 h-full self-stretch min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-md">
    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
      <h5 class="text-gray-500 uppercase font-semibold text-xs">{{ __($title) }}</h5>
      <span class="font-semibold text-4xl text-gray-800">{{ $value }}</span>
    </div>
    <div class="relative w-auto pl-4">
      <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 rounded-full {{ $color }}">
        <i class="fa fa-{{ $icon }}"></i>
      </div>
    </div>
  </div>
</div>
