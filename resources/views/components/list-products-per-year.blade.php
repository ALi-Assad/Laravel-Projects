@props(['year' , 'path', 'ucd'])

@foreach ($year as $key => $month)
   @php
   $path['monthName']  = $key;
   @endphp
   <ul class="list-group list-group-flush">
      <li class="list-group-item"><span class="badge bg-primary">Month {{$key}}</span>
         <x-list-products-per-month :path="$path" :month="$month" :ucd="$ucd"/>
      </li>
   </ul>
@endforeach