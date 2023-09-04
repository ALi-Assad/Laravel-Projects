@props(['product', 'id', 'path', 'ucd'])

@php
$productId = $id;
$fullPath = $path['yearName'] .'/'. $path['monthName'] .'/' . $path['dayName'];
$fullPathAsClass = $path['yearName'] .'-'. $path['monthName'] .'-' . $path['dayName'] .'-'. $productId;
$total = $product['quantity'] * $product['price'];
@endphp

<div class="row justify-content-center mb-3">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-0 border rounded-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-8 col-lg-8 col-xl-8">
              <h5>{{$product['name']}}</h5>
              <div class="d-flex flex-row">
                Quantity:<span>{{" ".$product['quantity']}}</span>
              </div>
              <div class="mb-2 text-muted small">
                <span>Total</span>
                <span class="text-primary"> : </span>
                <span>{{$total}}</span>
                <input type="hidden"  class="total-item" value="{{$total}}">
              </div>
              <div class="text-muted small">
                <span>Created At</span>
                <span class="text-primary"> : </span>
                <span>{!! date("g:i a",$product['created_at']) !!}</span>
              </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xl-4 border-sm-start-none border-start">
              <div class="d-flex flex-row align-items-center mb-1">
                <h4 class="mb-1 me-1">{{ $ucd }}<span class="price-item">{{ $product['price'] }} </span></h4>
              </div>
              <div class="d-flex flex-column mt-3">
                <button id="update-btn-{{$fullPathAsClass}}" class="btn btn-primary btn-sm update-btn" type="button" product-id="{{$productId}}">Update</button>
              </div>
            </div>
            <div id="update-section-{{$fullPathAsClass}}" class="mt-3">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
    $( function() {
        let fullPathAsClass ="<?php echo $fullPathAsClass; ?>";
      $('#update-btn-'+ fullPathAsClass).click(function() {
          let fullPath =  "<?php echo $fullPath; ?>";
          const productId = "<?php echo $productId; ?>";
          $(".update-btn").prop("disabled",true);
          $.ajax({
              url: "{{ url('products/'.$productId.'/edit') }}",
              method: 'GET',
              data: {productId: productId, fullPath:fullPath, fullPathAsClass:fullPathAsClass},
              success: function(data) {
                  $('#update-section-'+ fullPathAsClass).html(data);
              }
          });
      });
    })

</script>