{{-- Mini browser mockup — $type: resto | shop | company --}}
<div class="mock-browser">
  <div class="mock-bar">
    <div class="mock-dots"><span></span><span></span><span></span></div>
    <div class="mock-addr"></div>
  </div>
  <div class="mock-page mock-{{ $type }}">
    @switch($type)
      @case('resto')
        <div class="mock-pnav"></div>
        <div class="mock-phero"></div>
        <div class="mock-prow">
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
        </div>
        @break

      @case('shop')
        <div class="mock-pnav"></div>
        <div class="mock-prow mock-pgrid">
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
        </div>
        <div class="mock-ptext"></div>
        @break

      @case('company')
        <div class="mock-pnav"></div>
        <div class="mock-phero mock-phero--split">
          <div class="mock-phero-text"></div>
          <div class="mock-phero-img"></div>
        </div>
        <div class="mock-prow">
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
          <div class="mock-pcard"></div>
        </div>
        @break
    @endswitch
  </div>
</div>
