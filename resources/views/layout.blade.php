@include('pages.head')
    <body>


    <div class="modal fade" id="deleteModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-message-info">
                </div>
                <div class="modal-body" id="modalBodyHeader">
                </div>
                <div class="modal-footer">
                    <button id="deleteCancelButton" type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fas fa-times"></i>
                        No
                    </button>
                    <button id="deleteConfirmButton" type="button" class="btn btn-danger ">
                        <i class="fas fa-check"></i>
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <header class="row">
            <div class="col-2">
                <div class="authUser"  data-id="{{Auth::user()->id}}">
                    Hello,<br> <span id="authUserName" class="font-weight-bold">{{ Auth::user()->name }}</span>
                </div>
            </div>
            <div class="col-7">
                <div class="message-info">
                </div>
            </div>
            <div class="col-3">
                <div class="float-right">
{{--                        <button id="editLoggedUsrBtn" type="button" class="btn btn-light " data-id="{{Auth::user()->id}}" data-toggle="modal" data-target="">--}}
                        <button type="button" class="btn btn-light" onclick="window.location='{{route("users.settings")}}'">
{{--                            <i class="fas fa-user-edit"></i>--}}
                            <i class="fas fa-cog"></i>
                            Settings
                        </button>
                        <button id="exitSysBtn" type="button" class="btn btn-light " data-toggle="modal" data-target="#deleteModalWindow">
                            <i class="fas fa-sign-out-alt"></i>
                            Exit
                        </button>
                </div>
{{--                    <div class="clearfix"></div>--}}
            </div>
        </header>


        <menu class="row">
            <div class="col-3">
                <button type="button" class="btn btn-light btn-block" onclick="window.location='{{ route("categories.index") }}'">
                    <i class="fas fa-tasks"></i>
                    Categories
                </button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-light btn-block" onclick="window.location='{{ route("adverts") }}'">
                    <i class="fas fa-tags"></i>
                    Adverts
                </button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-light btn-block" onclick="window.location='{{ route("users.index") }}'">
                    <i class="fas fa-user-friends"></i>
                    Users
                </button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-light btn-block" onclick="window.location='{{route("history")}}'">
                    <i class="fas fa-th-list"></i>
                    All history
                </button>
            </div>
        </menu>


        <main class="row">
            <div class="col-12">
                @yield('content')
             </div>
        </main>

    </div>
    </body>
</html>


<script>

    // $(function () {
        // $('[data-toggle="password"]').tooltip()
        $(':input').tooltip();
    // });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        dataType: 'json'
    });

    $('#exitSysBtn').click(function () {
        $('#modalLongTitle').html('Exit system !!!');
        $('#modalBodyHeader').html('Do you really want to Logout? Are you sure?');
        $('#deleteConfirmButton').unbind("click");
        $('#deleteConfirmButton').click( function () {
            logOutSystem();
            return false;
        });
    });






    function editUser(id) {
        let url = '{{route('users.update', ['id' => ':id'])}}';
        $.ajax({
            type: "PUT",
            url: url.replace(':id', id),
            data: $('#userForm').serialize(),
            success: function (response) {
                if(response.status) {
                    $('#userModalWindow').modal('hide');
                    if('{{Auth::user()->id}}' == id) {
                        $('#authUserName').html(response.name);
                        loggedUserName = response.name;
                        loggedUserEmail = response.email;
                    }
                    if ('{{request()->getBaseUrl()}}' + '/users' == $(location).attr('pathname')) {
                        $('#tr_user_' + id + ' .userName').hide(1000,function () {
                            $('#tr_user_' + id + ' .userName').html('' +'<a href="{{url('users/')}}' +'/' + + id + '/history">' +response.name+ '</a>');
                            $('#tr_user_' + id + ' .userEmail').html(response.email);
                        }).show(1000, function () {
                            $('.message-info').html('<div class="alert alert-info"> User ' +response.name+ ' is updated </div>');
                            $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                        });
                    }
                    else {
                        $('.message-info').html('<div class="alert alert-info"> User ' +response.name+ ' is updated </div>');
                        $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                    }
                }
                else {
                    $('.modal-message-info').html('<div class="alert alert-danger"> User is not updated. Enter other values !</div>');
                    $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            },
            error: function (reject) {
                let $list = '<ul>';
                if(reject.status == 422) {
                    let errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key, value) {
                        $list += '<li>' + value + '</li>';
                    })
                }
                else {
                    $list = 'Wrong user id';
                }
                $('.modal-message-info').html('<div class="alert alert-danger">' + $list + '</div>');
                $('.modal-message-info').slideDown(1000).delay(4000).slideUp(1000);
            }
        })
    }


    function logOutSystem() {
        $.ajax({
            type: 'POST',
            url: '{{route('logout')}}',
            success: function (response) {
                $('#deleteModalWindow').modal('hide');
                if(response.status == 'logged out') {
                    location.reload();
                }
            }
        })
    }



    function getCompanyValues(id) {
        let url = '{{route('companies.company', ['id' => ':id'])}}';
        $.ajax({
            type: 'GET',
            url: url.replace(':id', id),
            success: function (response) {
                setCompanyEditModalWindow(response.company);
            },
            error: function (reject) {
                $('.modal-message-info').html('<div class="alert alert-danger"> Something goes wrong. Try again later </div>');
                $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
            }
        });
    }


    function setCompanyEditModalWindow(company) {
        $('#companyTitle').html('Edit company <b>'+ company.name + '</b>');
        $('#companyNameInput').attr('placeholder', 'Company name');
        $('#companyNameInput'). val(company.name);
        $('#apiVersionInput'). val(company.api_version);
        $('#apiKeyInput'). val(company.api_key);
        $('#apiPasswordInput'). val(company.api_password);
        $('#baseUriInput'). val(company.base_uri);
        $('#baseCurrencyInput'). val(company.base_currency);
        $('#companySubmitButton #buttonValue').html('Save');
        $('#companyForm').unbind('submit');
        $('#companyForm').submit(function () {
            editCompany(company.id);
            return false;
        });
    }

    function editCompany(id) {
        let url = '{{route('companies.update', ['id' => ':id'])}}';
        $.ajax({
            type: 'PUT',
            url: url.replace(':id', id),
            data: $('#companyForm').serialize(),
            success: function (response) {
                if(response.status) {
                    $('#companyModalWindow').modal('hide');
                    if ('{{request()->getBaseUrl()}}' + '/companies' == $(location).attr('pathname')) {
                        $('#tr_company_' + id + ' .companyName').hide(1000,function () {
                            $('#tr_company_' + id + ' .companyName').html('<a href="{{url('companies/')}}' +'/' + id + '/history">' +response.name+ '</a>');
                            $('#tr_company_' + id + ' .companyUri').html(response.base_uri);
                        }).show(1000, function () {
                            $('.message-info').html('<div class="alert alert-info"> Company ' +response.name+ ' is updated </div>');
                            $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                        });
                    }
                    else {
                        $('.message-info').html('<div class="alert alert-info"> Company ' +response.name+ ' is updated </div>');
                        $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                    }
                }
                else {
                    $('.modal-message-info').html('<div class="alert alert-danger"> Company is not updated. Enter other values !</div>');
                    $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
                }

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
                $('.modal-message-info').slideDown(1000).delay(4000).slideUp(1000);
            }
        })
    }

</script>
