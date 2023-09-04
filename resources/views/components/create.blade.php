

<form method="POST" action="" id="form-create">
      @csrf
      <div class="card">
            <img class="card-img-top" src="holder.js/100x180/" alt="">
            <div class="card-body">
                  <h4 class="card-title">Create New Product</h4>
                        <div class="form-group mt-2">
                              <label for="name">Name</label>
                              <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group mt-2">
                              <label for="quantity">Quantity</label>
                              <input type="number" class="form-control" id="quantity" name="quantity" aria-describedby="quantity" placeholder="Enter Quantity">
                        </div>
                        <div class="form-group mt-2">
                              <label for="price">Price</label>
                              <input type="number" step="0.01" class="form-control" id="price" name="price" aria-describedby="price" placeholder="Enter Price">
                        </div>
                        <div id="create-errors"></div>
                   <button type="button" class="btn btn-primary mt-4" id="create-product">Submit</button>
            </div>
      </div>
</form>

<script type="text/javascript">
      $( function() {
        
            $('#create-product').click(function() {
                  var data={
                        name: $('#name').val(),
                        quantity: $('#quantity').val(),
                        price: $('#price').val(),
                  }
                  $.ajax({
                        url: "{{ url('products') }}",
                        method: 'POST',
                        data: {formData: data, "_token": "{{ csrf_token() }}"},
                        success: function(data) {
                            $('#list-all').load("{{ url('product/list-all') }}");
                            $('#form-create').trigger("reset");
                            $( '#create-errors' ).html( ' ' ); 
                        },
                        error: function(data){
                              var errors = data.responseJSON;
                              errorsHtml = '<div class="alert alert-danger" role="alert">'+ errors.error +'</div>';
                              $( '#create-errors' ).html( errorsHtml ); 
                        }
                  });
           });

      })

  </script>