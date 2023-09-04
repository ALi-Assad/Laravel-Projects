@props(['month', 'path', 'ucd'])

@foreach ($month as $key => $day)
    @php
    $path['dayName']  = $key;
    @endphp
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><span class="badge bg-secondary">Day {{$key}}</span>
           <x-list-products-per-day :path="$path" :day="$day" :ucd="$ucd"/>
        </li>
    </ul>
@endforeach
