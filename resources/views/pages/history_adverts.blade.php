@extends('layout')

@section('content')
    <div class="text-center">
        <h4>
            Details of history №{{$history->id}} from {{$history->created_at->format('d-m-Y')}}
        </h4>
    </div>
    <table class="table table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Advert</th>
            <th scope="col">Price Before</th>
            <th scope="col">Price After</th>
        </tr>
        </thead>
        <tbody>
        @if($details->isNotEmpty())
            @foreach($details as $detail)
                <tr>
                    <th scope="row">{{$detail->id}}</th>
                    <td>{{$detail->advert_name}}</td>
                    <td>{{$detail->old_value.' '. config('shopify.base_currency')}}</td>
                    <td>{{$detail->new_value.' '. config('shopify.base_currency')}}</td>
                </tr>
            @endforeach
        @else
            <script>
                $('.message-info').html('<div class="alert alert-danger"> There is no adverts in this history </div>');
                // $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                $('.message-info').slideDown(1000);
            </script>
{{--            <div class="alert alert-danger">--}}
{{--                {{'There is no adverts in this history'}}--}}
{{--            </div>--}}
        @endif
        </tbody>
    </table>
    {{$details->onEachSide(2)->links('')}}

@endsection
