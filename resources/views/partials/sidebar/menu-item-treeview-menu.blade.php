@if(Auth::user()->hasRole('CEO'))
    @php $access_menu=['Estimate Management','Job Card Management','Reports','Client Bill Export','Writer Workload'] @endphp
@elseif(Auth::user()->hasRole('Project Manager'))
    @php $access_menu=['Job Card Management','Reports','Writer Workload'] @endphp
@elseif(Auth::user()->hasRole('Quality Control Executive'))
    @php $access_menu=[] @endphp
@else
    @php $access_menu=['Job Card Management','Job Register Management','Estimate Management','Client Management','Language Management','Employee Management','Writer Management','Reports','Client Bill Export','Writer Payment Report','Writer Work Done','Writer Workload'] @endphp
@endif
@if(in_array($item['text'],$access_menu))
<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item has-treeview @isset($item['submenu_class']) {{ $item['submenu_class'] }} @endisset @if(checkRequestUrl($item['active']??[],request()->path())) menu-is-opening menu-open @endif">

    {{-- Menu toggler --}}
    <a class="nav-link @isset($item['class']) {{ $item['class'] }}  @endisset @isset($item['shift']) {{ $item['shift'] }} @endisset"
       href="" {!! $item['data-compiled'] ?? '' !!} >

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
        }}"></i>

        <p>
            {{ $item['text'] }}
            <i class="fas fa-angle-left right"></i>

            @isset($item['label'])
                <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} right">
                    {{ $item['label'] }}
                </span>
            @endisset
        </p>

    </a>
    {{-- Menu items --}}
    <ul class="nav nav-treeview">
        @each('partials.sidebar.menu-item', $item['submenu'], 'item')
    </ul>

</li>
@endif
