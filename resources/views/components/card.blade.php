<div class="w-full lg:w-6/12 xl:w-3/12 px-4">
  <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-md">
    <div class="flex-auto p-4">
      <div class="flex flex-wrap">
        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
          <h5 class="text-gray-500 uppercase font-bold text-xs">{{ $title }}</h5>
          <span class="font-semibold text-2xl text-gray-800">{{ $value }}</span>
        </div>
        <div class="relative w-auto pl-4 flex-initial">
          <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 rounded-full {{ $color }}">
            <i class="fa fa-{{ $icon }}"></i>
          </div>
        </div>
      </div>
      @if ($rate)
        <p class="text-sm text-gray-500 mt-4">
          @if ($rate > 0)
            <span class="text-green-500 mr-2">
              <i class="fas fa-arrow-up"></i> {{ $rate }}%
            </span>
          @else
            <span class="text-red-500 mr-2">
              <i class="fas fa-arrow-down"></i> {{ $rate }}%
            </span>
          @endif
          <span class="whitespace-no-wrap">{{ $since }}</span>
        </p>
      @endif
    </div>
  </div>
</div>
