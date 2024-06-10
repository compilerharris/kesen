@if(Auth::user()->hasRole('Accounts'))
    @php $access_menu=['Job Card Management'] @endphp
@elseif(Auth::user()->hasRole('Project Manager'))
    @php $access_menu=['Job Card Management'] @endphp
@elseif(Auth::user()->hasRole('Quality Control Executive'))
    @php $access_menu=[] @endphp
@else
<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-header {{ $item['class'] ?? '' }}">

    {{ is_string($item) ? $item : $item['header'] }}

</li>
@endif
