@props(['product', 'fullPathAsClass' , 'productId', 'fullPath'])

<form method="POST" action="" id="form-update-{{$fullPathAsClass}}">
      @csrf
      @method('PUT')
      <div class="card">
            <div class="card-body">
                  <h4 class="card-title">Update Product: {{$product['name']}}</h4>
                        <div class="form-group mt-2">
                              <label for="name">Name</label>
                              <input type="text" class="form-control" id="name-{{$fullPathAsClass}}" name="name" aria-describedby="name" placeholder="Enter Name" value="{{$product['name']}}">
                              @error('name')
                              <p class="text-danger"> {{$message}} </p>
                              @enderror
                        </div>
                        <div class="form-group mt-2">
                              <label for="quantity">Quantity</label>
                              <input type="number" class="form-control" id="quantity-{{$fullPathAsClass}}" name="quantity" aria-describedby="quantity" placeholder="Enter Quantity" value="{{$product['quantity']}}">
                              @error('quantity')
                              <p class="text-danger"> {{$message}} </p>
                              @enderror
                        </div>
                        <div class="form-group mt-2">
                              <label for="price">Price</label>
                              <input type="number" step="0.01" class="form-control" id="price-{{$fullPathAsClass}}" name="price" aria-describedby="price" placeholder="Enter Price" value="{{$product['price']}}">
                              @error('price')
                              <p class="text-danger"> {{$message}} </p>
                              @enderror
                        </div>
                        <div id="update-errors"></div>
                   <button type="button" class="btn btn-primary mt-4" id="submit-update-{{$fullPathAsClass}}">Submit</button>
                   <button type="button" class="btn btn-primary mt-4" id="cancel-update-{{$fullPathAsClass}}">Cancel</button>
            </div>
      </div>
</form> 

<script type="text/javascript">
      $( function() {
            let fullPathAsClass ="<?php echo $fullPathAsClass; ?>";
            let productId ="<?php echo $productId; ?>";
            $('#cancel-update-'+ fullPathAsClass).click(function() {
                  $('#update-section-'+ fullPathAsClass).html('');
                  $(".update-btn").prop("disabled",false);
            });

            $('#submit-update-'+ fullPathAsClass).click(function() {
                  let fullPath =  "<?php echo $fullPath; ?>";
                  const productId = "<?php echo $productId; ?>";
                  var data={
                        name: $('#name-'+ fullPathAsClass).val(),
                        quantity: $('#quantity-'+ fullPathAsClass).val(),
                        price: $('#price-'+ fullPathAsClass).val(),
                  }
                  $.ajax({
                        url: "{{ url('products/'.$productId) }}",
                        type: 'PUT',
                        data: {formData: data, fullPath:fullPath, fullPathAsClass:fullPathAsClass, "_token": "{{ csrf_token() }}"},
                        success: function(data) {
                          $('#list-all').load("{{ url('product/list-all') }}");
                        },
                        error: function(data){
                              $.ajax({
                              url: "{{ url('products/'.$productId.'/edit') }}",
                              method: 'GET',
                              data: {productId: productId, fullPath:fullPath, fullPathAsClass:fullPathAsClass},
                              success: function(data) {
                                    $('#update-section-'+ fullPathAsClass).html(data);
                                    errorsHtml = '<div class="alert alert-danger" role="alert">Invalid data</div>';
                                    $( '#update-errors' ).html(  errorsHtml ); 
                                    }
                              });
                        }
                  });
           });

      })

  </script>