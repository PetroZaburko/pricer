@extends('layout')

@section('content')
    <div class="text-center">
        <h4>
            All Companies
        </h4>
    </div>
    {{--    <div class="message-info">--}}
    {{--        @if(session('message'))--}}
    {{--            @if(session('status'))--}}
    {{--                <div class="alert alert-info">--}}
    {{--                    {{session('message')}}--}}
    {{--                </div>--}}
    {{--            @else--}}
    {{--                <div class="alert alert-danger">--}}
    {{--                    {{session('message')}}--}}
    {{--                </div>--}}
    {{--            @endif--}}
    {{--        @endif--}}
    {{--    </div>--}}
    <table class="table table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Shop URI</th>
            <th scope="col">Edit</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody id="companyTableBody">
        @foreach($companies as $company)
            <tr id="tr_company_{{$company->id}}">
                <th scope="row">{{$company->id}}</th>
{{--                <td class="companyName"><a href="{{route('users.history', ['id' => $user->id])}}">{{$user->name}}</a></td>--}}
                <td class="companyName"><a href="">{{$company->name}}</a></td>
                <td class="companyUri">{{$company->base_uri}}</td>
                <td>
{{--                    <div class="flex-row">--}}
                        <button type="button" class="btn btn-success" id="companyEditButton_{{$company->id}}" data-id="{{$company->id}}" data-toggle="modal" data-target="#companyModalWindow">
                            <i class="fas fa-edit"></i>
                        </button>
{{--                        <button type="button" class="btn btn-danger" id="companyDeleteButton_{{$company->id}}" data-id ="{{$company->id}}" data-toggle="modal" data-target="#deleteModalWindow">--}}
{{--                            <i class="fas fa-trash-alt"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </td>
                <td>
                    <input type="checkbox" id="companyStatusToggle_{{$company->id}}" data-id="{{$company->id}}" {{$company->status ? 'checked' : ''}} data-toggle="toggle" data-onstyle="primary">
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    {{$companies->onEachSide(2)->links('')}}

    <button type="button" id="addCompany" class="btn btn-primary float-left" data-toggle="modal" data-target="#companyModalWindow">
        <i class="fas fa-plus"></i>
        Add new
    </button>


    {{--    modal dialog add/edit form--}}
    <div class="modal fade" id="companyModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-message-info">
                </div>
                <form id="companyForm" role="form">
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" id="companyNameInput" class="form-control" name="name" placeholder="Company name" autofocus data-placement="{{config('view.tooltip_position')}}" title="Company name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" id="apiVersionInput" class="form-control" name="api_version" placeholder="API version" data-placement="{{config('view.tooltip_position')}}" title="API version">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="password" id="apiKeyInput" class="form-control" name="api_key" placeholder="API key" data-toggle="password" data-placement="{{config('view.tooltip_position')}}" title="API key">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="password" id="apiPasswordInput" class="form-control" name="api_password" placeholder="API password" data-toggle="password" data-placement="{{config('view.tooltip_position')}}" title="API password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" id="baseUriInput" class="form-control" name="base_uri" placeholder="Shop URI" data-placement="{{config('view.tooltip_position')}}" title="Shop URI">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" id="baseCurrencyInput" class="form-control" name="base_currency" placeholder="Shop currency" data-placement="{{config('view.tooltip_position')}}" title="Shop currency">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </button>
                        <button id="companySubmitButton" type="submit" class="btn btn-success">
                            <i class="far fa-save"></i>
                            <span id="buttonValue"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>


        //bind button add company
        $('#addCompany').click( function () {
            $('#companyTitle').html('Create new company');
            $('#companyForm :input').val('');
            $('#companyNameInput').attr('placeholder', 'New company');
            $('#companySubmitButton #buttonValue').html('Create');
            $('#companyForm').unbind('submit');
            $('#companyForm').submit(function () {
                addCompany();
                return false;
            });
        });


        // bind buttons edit company
        $('[id^=companyEditButton_]').click(function () {
            getCompanyValues($(this).attr('data-id'));
        });

        // bind buttons change company status
        $('[id^=companyStatusToggle_]').change(function () {
            setCompanyStatusModalWindow($(this));
        });


        function setCompanyStatusModalWindow($this) {
            let id = $this.attr('data-id');
            let companyName = $this.closest('td').siblings('.companyName').find('a').html();
            $this.bootstrapToggle(getCompanyCurrentStatus(!$this.prop('checked')), true);
            $('#modalLongTitle').html('Warning !!!');
            $('#modalBodyHeader').html('You are trying to turn <b>' +getCompanyCurrentStatus(!$this.prop('checked')) + '</b> company <b>' +companyName+ '</b>,  are you sure ?');
            $('#deleteModalWindow').modal('show');
            $('#deleteConfirmButton').unbind("click");
            $('#deleteConfirmButton').click( function () {
                $('#deleteModalWindow').modal('hide');
                $this.bootstrapToggle(getCompanyCurrentStatus($this.prop('checked')));
                toggleCompanyStatus(id);
            });
        }

        function getCompanyCurrentStatus(checked) {
            return (checked) ? 'on' : 'off';
        }





        // function setCompanyEditModalWindow(company) {
        //     $('#companyTitle').html('Edit company <b>'+ company.name + '</b>');
        //     $('#companyNameInput').attr('placeholder', 'Company name');
        //     $('#companyNameInput'). val(company.name);
        //     $('#apiVersionInput'). val(company.api_version);
        //     $('#apiKeyInput'). val(company.api_key);
        //     $('#apiPasswordInput'). val(company.api_password);
        //     $('#baseUriInput'). val(company.base_uri);
        //     $('#baseCurrencyInput'). val(company.base_currency);
        //     $('#companySubmitButton #buttonValue').html('Save');
        //     $('#companyForm').unbind('submit');
        //     $('#companyForm').submit(function () {
        //         editCompany(company.id);
        //         return false;
        //     });
        // }


        {{--function editCompany(id) {--}}
        {{--    let url = '{{route('companies.update', ['id' => ':id'])}}';--}}
        {{--    $.ajax({--}}
        {{--        type: 'PUT',--}}
        {{--        url: url.replace(':id', id),--}}
        {{--        data: $('#companyForm').serialize(),--}}
        {{--        success: function (response) {--}}
        {{--            console.log(response);--}}
        {{--        },--}}
        {{--        error: function (reject) {--}}
        {{--            console.log(reject)--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}


        function toggleCompanyStatus(id) {
            let url = '{{route('companies.status', ['id' => ':id'])}}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                success: function (response) {
                    let classType = (response.status) ? 'alert-info' : 'alert-danger';
                    $('.message-info').html('<div class="alert ' +classType+ '">' +response.message+ '</div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                },
                error: function (reject) {
                    console.log(reject);
                    //change buttonToggle status back
                    $('#companyStatusToggle_' +id).bootstrapToggle(getCompanyCurrentStatus($(this).prop('checked')));

                    $('.message-info').html('<div class="alert alert-danger"> Something goes wrong. Try again later </div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            });
        }


        {{--function getCompanyValues(id) {--}}
        {{--    let url = '{{route('companies.company', ['id' => ':id'])}}';--}}
        {{--    $.ajax({--}}
        {{--        type: 'GET',--}}
        {{--        url: url.replace(':id', id),--}}
        {{--        success: function (response) {--}}
        {{--            setCompanyEditModalWindow(response.company);--}}
        {{--        },--}}
        {{--        error: function (reject) {--}}
        {{--            $('.message-info').html('<div class="alert alert-danger"> Something goes wrong. Try again later </div>');--}}
        {{--            $('.message-info').slideDown(1000).delay(2000).slideUp(1000);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}





        function addCompany() {
            $.ajax({
                type: 'POST',
                url: '{{route('companies.store')}}',
                data: $('#companyForm').serialize(),
                success: function (response) {
                    $('#companyModalWindow').modal('hide');
                    let trNewCompany = "<tr id=\"tr_company_" +response.id+ "\">\n" +
                        "                <th scope=\"row\">" +response.id+ "</th>\n" +
                        "                <td class=\"companyName\"><a href=\"\">" +response.name+ "</a></td>\n" +
                        "                <td class=\"companyUri\">" +response.base_uri+ "</td>\n" +
                        "                <td>\n" +
                        // "                    <div class=\"flex-row\">\n" +
                        "                        <button type=\"button\" class=\"btn btn-success\" id=\"companyEditButton_" +response.id+ "\" data-id=\"" +response.id+ "\" data-toggle=\"modal\" data-target=\"#companyModalWindow\">\n" +
                        "                            <i class=\"fas fa-edit\"></i>\n" +
                        "                        </button>\n" +
                        // "                        <button type=\"button\" class=\"btn btn-danger\" id=\"companyDeleteButton_" +response.id+ "\" data-id=\"" +response.id+ "\" data-toggle=\"modal\" data-target=\"#deleteModalWindow\">\n" +
                        // "                            <i class=\"fas fa-trash-alt\"></i>\n" +
                        // "                        </button>\n" +
                        // "                    </div>\n" +
                        "                </td>\n" +
                        "                <td>\n" +
                        "                       <input type=\"checkbox\" id=\"companyStatusToggle_" +response.id+ "\" data-id=\"" +response.id+ "\" data-toggle=\"toggle\" data-onstyle=\"primary\">" +
                        "                </td>\n" +
                        "            </tr>";

                    $('#companyTableBody').append(trNewCompany);
                    // initializing toggle status button
                    $('#companyStatusToggle_' + response.id).bootstrapToggle();

                    // adding event listener on toggle status button
                    $('#companyStatusToggle_' + response.id).change(function () {
                        setCompanyStatusModalWindow($(this));
                    });

                    // adding event listener on delete button
                    // $('#conpanyDeleteButton_'+ response.id).click(function () {
                    //     setCompanyDeleteModalWindow($(this));
                    // });

                    // adding event listener on edit button
                    $('#categoryEditButton_'+ response.id).click(function () {
                        setCompanyEditModalWindow($(this));
                    });

                    $('#tr_company_'+response.id).css('display', 'none').show(1000, function () {
                        $('.message-info').html('<div class="alert alert-info">Company '+ response.name+' is created.</div>');
                        $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                    });
                },
                error: function (reject) {
                    let $list = '<ul>';
                    if(reject.status == 422) {
                        let errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function (key, value) {
                            $list += '<li>' + value + '</li>';
                        })
                    }
                    $('.modal-message-info').html('<div class="alert alert-danger">' + $list + '</div>');
                    $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            });
        }


    </script>


    @endsection
