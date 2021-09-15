@extends('layout')

@section('content')
    <div class="text-center">
        <h4>
            All products
        </h4>
    </div>
    <div class="message-info">
        @if(session('message'))
            @if(session('status'))
                <div class="alert alert-info">
                    {{session('message')}}
                </div>
            @else
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
            @endif
        @endif
    </div>
    <table>
        <tr>
            <table class="table table-sm adverts-inner-table">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="adverts-inner-table-id">ID</th>
                    <th scope="col" class="adverts-inner-table-title">Title</th>
                    <th scope="col" class="adverts-inner-table-img">Image</th>
                    <th scope="col" class="adverts-inner-table-cat">Categories</th>
                    <th scope="col" class="adverts-inner-table-act">Actions</th>
                </tr>
                </thead>
            </table>
        </tr>

{{--        <tbody>--}}
        @if(!empty($products))
            @foreach($products as $product)
                <tr>
                    <td>
                        {{Form::open(['route' => ['adverts'], 'method'=>'POST'])}}
                            <table class="adverts-inner-table table table-hover table-sm">
                                <tr>

                                    <th scope="row" class="adverts-inner-table-id">{{$product->id}}</th>
                                    <td class="adverts-inner-table-title"><a href="{{config('shopify.base_uri').'/products/'.$product->handle}}" target="_blank">{{$product->title}}</a> </td>
                                    <td class="adverts-inner-table-img">
                                        <img src="{{$product->image->src}}" alt="">
                                    </td>
                                    <td class="adverts-inner-table-cat">
                                        <select class="selectpicker"  data-live-search="true" name="category_id">
                                            <option  value="">Nothing selected</option>
                                            @if($categories->isNotEmpty())
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{(isset($product->category) && $product->category['id'] == $category->id) ? "selected" : ""}}>{{$category->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td class="adverts-inner-table-act">
                                        <input type="hidden" value="{{$product->id}}" name="advert_id">
                                        <input type="hidden" value="{{$product->title}}" name="advert_title">
                                        <button type="submit" value="submit" class="btn btn-primary btn-block">
                                            <i class="far fa-save"></i>
                                            Save
                                        </button>
                                    </td>

                                </tr>
                            </table>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
        @else
            <div class="text-center alert alert-primary">There is no products</div>
        @endif
{{--        </tbody>--}}
    </table>
    {{$products->links()}}
@endsection
