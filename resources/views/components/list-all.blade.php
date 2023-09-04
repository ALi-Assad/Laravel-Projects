@props(['data', 'ucd'])
    @foreach ($data as $key => $year)
      <div class="card">
        <h5 class="card-header">{{$key}}</h5>
        <x-list-products-per-year :path="['yearName' => $key]" :year="$year" :ucd="$ucd"/>
      </div>
    @endforeach
    
    @if(count($data) > 0)
        <h3 class="border p-3 m-3">Sum Total: <span id="sum-total"></span></h3>
     @endIf 

     
    <script type="text/javascript">
      $( function() {
            var sum = 0;
            $('.total-item').each(function() {
                sum += Number($(this).val());
            });
            $('#sum-total').text(sum);
      })

    </script>
