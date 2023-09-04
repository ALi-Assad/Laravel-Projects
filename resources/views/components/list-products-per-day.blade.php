@props(['day', 'path', 'ucd'])

<section style="background-color: #eee;">
    <div class="container py-5">
        @foreach ($day as $key => $product)
            <x-list-one-product :product="$product" :id="$key" :path="$path" :ucd="$ucd"/>
        @endforeach   
    </div>
<section>
