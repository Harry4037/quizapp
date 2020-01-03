<div class="form-group">
    <label class="control-label col-md-4 col-sm-4 col-xs-12">Products <span class="error">*</span></label>
    <div class="col-md-4 col-sm-6 col-xs-6">
        @foreach($products as $product)
        <input type="checkbox" name="products[]" value="{{$product->id}}">{{$product->name}}
        @endforeach
    </div>
</div>