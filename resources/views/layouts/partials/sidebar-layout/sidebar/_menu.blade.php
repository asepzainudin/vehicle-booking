<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
  <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
       data-kt-scroll-activate="true" data-kt-scroll-height="auto"
       data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
       data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
    <div class="accordion menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold bg-transparent fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
      {{-- <div class="menu-item">
        <a class="menu-link {{ activeCss('admin.home', cssClass: 'active') }}" href="{{ routed('admin.home') }}">
          <span class="menu-icon"><i class="fad fa-home fs-3"></i></span>
          <span class="menu-title">{{ __('Dashboard') }}</span>
        </a>
      </div> --}}
      @forelse(menus()->get() as $groupName => $group)
        {{--@php
          $hasActive = $group->items->filter(fn ($it) => $it->isActive())->isNotEmpty();
        @endphp--}}
        <div class="accordion-item bg-transparent border-0">
          @if(!str($group->name)->is('default') && $group->items->isNotEmpty())
            <div class="accordion-header menu-item pt-5">
              <div class="menu-content bg-main" data-bs-toggle="collapse" data-bs-target="#sidemenu-{{ $group->name }}">
                <div class="menu-heading fw-bold text-uppercase fs-6 d-flex align-items-center gap-2 justify-content-between" style="color:var(--bs-text-white)!important;">
                  <span>{{ $group->title }}</span>
                  <span class="bullet bullet-vertical"></span>
                </div>
              </div>
            </div>
          @endif

          <div id="sidemenu-{{ $group->name }}" class="accordion-collapse collapse show {{-- $hasActive ? 'show' : '' --}}">
            @forelse($group->items as $menu)
              @if($menu->items->isEmpty())
                @php
                  $activeClass = $menu->isActive() ? 'active' : '';
                  $icon = str($menu->attribute->icon)->contains([' fa-', ' li-', ' ki-'])
                    ? "<i class='{$menu->attribute->icon} fs-3'></i>"
                    : getIcon($menu->attribute->icon ?: 'element-11', 'fs-2');
                @endphp
                <div class="menu-item">
                  <a href="{{ $menu->href }}" class="menu-link {{ $activeClass }}" tabindex="0">
                    <span class="menu-icon">{!! $icon !!}</span>
                    <span class="menu-title">{{ $menu->title }}</span>
                  </a>
                </div>
              @else
                @php
                  $activeClass = $menu->isActive() ? 'here show' : '';
                @endphp
                <div class="menu-item menu-accordion {{ $activeClass }}" data-kt-menu-trigger="click">
                  <div class="menu-link flex items-center grow cursor-pointer border border-transparent gap-[10px] pl-[10px] pr-[10px] py-[6px]" tabindex="0">
                    <span class="menu-icon"><i class="ki-filled ki-profile-circle text-lg"></i></span>
                    <span class="menu-title">{{ $menu->title }}</span>
                    <span class="menu-arrow"></span>
                  </div>
                  <div class="menu-accordion gap-0.5 pl-[10px] relative before:absolute before:left-[20px] before:top-0 before:bottom-0 before:border-l before:border-gray-200">
                    @forelse($menu->items as $subMenu)
                      @php
                        $activeClass = $menu->isActive() ? 'active' : '';
                      @endphp
                      <div class="menu-item">
                        <a href="{{ $subMenu->href }}" class="menu-link {{ $activeClass }}" tabindex="0">
                          <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                          <span class="menu-title">{{ $subMenu->title }}</span>
                        </a>
                      </div>
                    @empty
                    @endforelse
                  </div>
                </div>
              @endif
            @empty
            @endforelse
          </div>
        </div>
      @empty
      @endforelse
    </div>
  </div>
</div>
