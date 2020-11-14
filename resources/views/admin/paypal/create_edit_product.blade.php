@extends('admin.layout')

@section('admin-title') Products @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Products' => 'admin/data/products', ($products->id ? 'Edit' : 'Create').' Products' => $products->id ? 'admin/data/products/edit/'.$products->id : 'admin/data/products/create']) !!}

<h1>{{ $products->id ? 'Edit' : 'Create' }} Product
    @if($products->id)
        <a href="#" class="btn btn-outline-danger float-right delete-products-button">Delete Product</a>
    @endif
</h1>

{!! Form::open(['url' => $products->id ? 'admin/data/products/edit/'.$products->id : 'admin/data/products/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="form-group">
    {!! Form::label('Price') !!} {!! add_help('Do not include the $') !!}
    {!! Form::text('price', $products->id ? $products->price : null, ['class' => 'form-control stock-field', 'data-name' => 'price', 'placeholder' => '...']) !!}
</div>

<div class="form-group">
    {!! Form::label('Item') !!}
    {!! Form::select('item_id', $items, null, ['class' => 'form-control stock-field', 'data-name' => 'item_id']) !!}
</div>

<div class="form-group">
    {!! Form::label('is_bundle', 'Is this a bundle?', ['class' => 'form-check-label mb-2']) !!} {!! add_help('This will make the item appear in the \'bundles\' area.') !!}
    {!! Form::checkbox('is_bundle', 1, $products->id ? $products->is_bundle : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
</div>

<div class="form-group">
    {!! Form::label('is_visible', 'Should this product be buyable / visible yet?', ['class' => 'form-check-label mb-2']) !!}
    {!! Form::checkbox('is_visible', 1, $products->id ? $products->is_visible : 1, ['class' => 'form-check-label ml-2', 'data-toggle' => 'toggle']) !!}
</div>

<div class="form-group">
    {!! Form::label('is_limited', 'Does this product have limited stock?', ['class' => 'is-limited-label form-check-label mb-2']) !!}
    {!! Form::checkbox('is_limited', 1, $products->id ? $products->is_limited : 0, ['class' => 'is-limited-class form-check-label ml-2', 'data-toggle' => 'toggle']) !!}
</div>
<div class="br-form-group mb-2" style="display: none">
    {!! Form::label('quantity', 'Quantity', ['class' => 'form-check-label mb-2']) !!}
    {!! Form::text('quantity', $products->id ? $products->quantity : null, ['class' => 'form-control', 'data-name' => 'quantity', 'placeholder' => '...']) !!}
</div>

<div class="text-right">
    {!! Form::submit($products->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {    
    $('.is-limited-class').change(function(e){
            console.log(this.checked)
            $('.br-form-group').css('display',this.checked ? 'block' : 'none')
                })
            $('.br-form-group').css('display',$('.is-limited-class').prop('checked') ? 'block' : 'none')
        });

    $('.delete-products-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/products/delete') }}/{{ $products->id }}", 'Delete Product');
});
    
</script>
@endsection