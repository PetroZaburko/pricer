@extends('layout')

@section('content')

    <div class="text-center">
        <h4>
            History
        </h4>
    </div>
    <script>
        $(function () {
            $('#history_table').bootstrapTable({
                data: JSON.parse('{!! $result !!}'),
                pagination: true,
                search: true,
                pageList: [5, 15, 30, 50, 'All'],
                pageSize: '{{ config('view.per_page') }}',
                classes: "table table-hover table-sm",
                theadClasses: 'thead-light',
                sortable: true,
                sortClass: 'table-active',
                paginationHAlign: 'left',
                paginationDetailHAlign: 'right',
                formatNoMatches: function () {
                    $('.message-info').html('<div class="alert alert-danger"> There is no history</div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            });
        });

    </script>
    <table id="history_table">
        <thead>
        <tr>
            <th scope="col" data-field="id" data-sortable="true">ID</th>
            <th scope="col" data-field="date" data-sortable="true">Date</th>
            <th scope="col" data-field="time" data-sortable="true">Time</th>
            <th scope="col" data-field="category" data-sortable="true">Category</th>
            <th scope="col" data-field="action" data-sortable="true">Action</th>
            <th scope="col" data-field="author" data-sortable="true">Author</th>
            <th scope="col" data-field="company" data-sortable="true">Company</th>
        </tr>
        </thead>


{{--    <table class="table table-hover table-sm">--}}
{{--        <thead class="thead-light">--}}
{{--        <tr>--}}
{{--            <th scope="col">ID</th>--}}
{{--            <th scope="col">Date</th>--}}
{{--            <th scope="col">Time</th>--}}
{{--            <th scope="col">Category</th>--}}
{{--            <th scope="col">Action</th>--}}
{{--            <th scope="row">Author</th>--}}
{{--            <th scope="row">Company</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @if($histories->isNotEmpty())--}}
{{--            @foreach($histories as $history)--}}
{{--            <tr>--}}
{{--                <th scope="row">--}}
{{--                    <a href="{{route('history.details', ['id' => $history->id])}}">{{$history->id}}</a>--}}
{{--                </th>--}}
{{--                <td>{{$history->created_at->format('d-m-Y')}}</td>--}}
{{--                <td>{{$history->created_at->format('H:i:s')}}</td>--}}
{{--                <td>{{$history->category->title}}</td>--}}
{{--                <td>{{$history->getFormattedAction()}}</td>--}}
{{--                <td>{{$history->user->name}}</td>--}}
{{--                <td>{{$history->company->name}}</td>--}}
{{--            </tr>--}}
{{--            @endforeach--}}
{{--        @else--}}
{{--            <script>--}}
{{--                $('.message-info').html('<div class="alert alert-danger"> There is no history</div>');--}}
{{--                // $('.message-info').slideDown(1000).delay(2000).slideUp(1000);--}}
{{--                $('.message-info').slideDown(1000);--}}
{{--            </script>--}}
{{--            <div class="alert alert-danger">--}}
{{--                {{'There is no history'}}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        </tbody>--}}
    </table>
{{--        {{$histories->onEachSide(2)->links('')}}--}}

@endsection
