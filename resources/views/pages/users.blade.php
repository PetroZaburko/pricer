@extends('layout')

@section('content')
    <div class="text-center">
        <h4>
            All Users
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
    <script>




        let data = [
            {
                'id': 1,
                '_id_scope': 'row2',
                'name': 'Petro',
                '_name_class': 'userName',
                'email': 'gigabyte_tech@ukr.net',
                '_email_class': 'userEmail',
                'actions': '                    <div class="flex-row">\n' +
                    '                        <button type="button" class="btn btn-success" id="userEditButton_1" data-id="1" data-toggle="modal" data-target="#userModalWindow">\n' +
                    '                            <i class="fas fa-edit"></i>\n' +
                    '                        </button>\n' +
                    '                        <button type="button" class="btn btn-danger" id="userDeleteButton_1" data-id ="1" data-toggle="modal" data-target="#deleteModalWindow">\n' +
                    '                            <i class="fas fa-trash-alt"></i>\n' +
                    '                        </button>\n' +
                    '                    </div>',
                'status': '<input type="checkbox" id="userStatusToggle_1" data-id="1" data-toggle="toggle" data-onstyle="primary">',
                'permissions': '<input type="checkbox" id="userPermissionsToggle_1" data-id="1"  data-toggle="toggle" data-on="Admin" data-off="User" data-onstyle="primary">'
            },
            {
                'id': 2,
                'name': 'Ivan',
                'email': 'gigabyte_plus@ukr.net',
                'status': 'user'
            },
            {
                'id': 3,
                'name': 'Oleg',
                'email': 'gigabyte_info@ukr.net',
                'status': 'admin'
            },
            {
                'id': 4,
                'name': 'Nazar',
                'email': 'gigabyte_support@ukr.net',
                'status': 'user'
            },
            {
                'id': 1,
                'name': 'Petro',
                'email': 'gigabyte_tech@ukr.net',
                'status': 'admin'
            },
            {
                'id': 2,
                'name': 'Ivan',
                'email': 'gigabyte_plus@ukr.net',
                'status': 'user'
            },
            {
                'id': 3,
                'name': 'Oleg',
                'email': 'gigabyte_info@ukr.net',
                'status': 'admin'
            },
            {
                'id': 4,
                'name': 'Nazar',
                'email': 'gigabyte_support@ukr.net',
                'status': 'user'
            },
            {
                'id': 1,
                'name': 'Petro',
                'email': 'gigabyte_tech@ukr.net',
                'status': 'admin'
            },
            {
                'id': 2,
                'name': 'Ivan',
                'email': 'gigabyte_plus@ukr.net',
                'status': 'user'
            },
            {
                'id': 3,
                'name': 'Oleg',
                'email': 'gigabyte_info@ukr.net',
                'status': 'admin'
            },
            {
                'id': 4,
                'name': 'Nazar',
                'email': 'gigabyte_support@ukr.net',
                'status': 'user'
            },
        ];




        $(function () {
            $('#table').bootstrapTable({
                data: data,
                pagination: true,
                search: true,
                locale: 'en-EN',
                pageList: [2, 10, 25, 50, 'all'],
                pageSize: 10,
                classes: "table table-hover table-sm",
                theadClasses: 'thead-light',
                sortable: true,
                sortClass: 'table-active',
                paginationHAlign: 'left',
                paginationDetailHAlign: 'right',
                // sortName: 'id',
                // sortOrder: 'asc',
                rowAttributes: rowAttributes
            });
        });

        function rowAttributes(row, index) {
            return {
                'id': 'tr_user_' + row.id
            }
        }






    </script>

    <table id="table">
        <thead>
        <tr>
            <th scope="col" data-field="id" data-sortable="true">ID</th>
            <th scope="col" data-field="name" data-sortable="true">Name</th>
            <th scope="col" data-field="email" data-sortable="true">Email</th>
            <th scope="col" data-field="actions" data-sortable="true">Actions</th>
            <th scope="col" data-field="status" data-sortable="true">Status</th>
            <th scope="col" data-field="permissions" data-sortable="true">Permissions</th>
        </tr>
        </thead>
    </table>



    <table class="table table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">E-mail</th>
            @if(Auth::user()->is_admin)
                <th scope="col">Actions</th>
            @endif
            <th scope="col">Status</th>
            <th scope="col">Permissions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr id="tr_user_{{$user->id}}">
            <th scope="row">{{$user->id}}</th>
            <td class="userName"><a href="{{route('users.history', ['id' => $user->id])}}">{{$user->name}}</a></td>
            <td class="userEmail">{{$user->email}}</td>
            @if(Auth::user()->is_admin)
                <td>
                    <div class="flex-row">
                        <button type="button" class="btn btn-success" id="userEditButton_{{$user->id}}" data-id="{{$user->id}}" data-toggle="modal" data-target="#userModalWindow">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger" id="userDeleteButton_{{$user->id}}" data-id ="{{$user->id}}" data-toggle="modal" data-target="#deleteModalWindow">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>

                <td>
                    <input type="checkbox" id="userStatusToggle_{{$user->id}}" data-id="{{$user->id}}" {{$user->status ? 'checked' : ''}} data-toggle="toggle" data-onstyle="primary">
                </td>
                <td>
                    <input type="checkbox" id="userPermissionsToggle_{{$user->id}}" data-id="{{$user->id}}" {{$user->is_admin ? 'checked' : ''}} data-toggle="toggle" data-on="Admin" data-off="User" data-onstyle="primary">
                </td>
            @else
                <td>
                    {{$user->getUserStatus()}}
                </td>
                <td>
                    {{$user->isUserAdmin()}}
                </td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
    {{$users->links()}}



    {{--    modal dialog edit form--}}
    <div class="modal fade" id="userModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-message-info">
                </div>
                <form id="userForm" role="form">
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" id="userNameInput" class="form-control" name="name" placeholder="User name" autofocus data-placement="{{config('view.tooltip_position')}}" title="User name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="email" id="userEmailInput" class="form-control" name="email" placeholder="User email" data-placement="{{config('view.tooltip_position')}}" title="User email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="password" id="userOldPassInput" class="form-control" name="old_password" placeholder="Old password" data-placement="{{config('view.tooltip_position')}}" title="Old password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="password" id="userNewPassInput" class="form-control" name="password" placeholder="New password" data-placement="{{config('view.tooltip_position')}}" title="New password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="password" id="userConfirmNewPassInput" class="form-control" name="password_confirmation" placeholder="Confirm new password" data-placement="{{config('view.tooltip_position')}}" title="Confirm new password">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </button>
                        <button id="userSubmitButton" type="submit" class="btn btn-success">
                            <i class="far fa-save" id="categoryButtonSubmit"></i>
                            <span id="buttonValue"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>

        $(document).ready(function () {
            // initializing toggle status button
            $('[id^=userStatusToggle_]').bootstrapToggle();

            // adding event listener on toggle status button
            $('[id^=userPermissionsToggle_]').bootstrapToggle();

        });



        // bind buttons delete user
        $('[id^=userDeleteButton_]').click(function () {
            setUserDeleteModalWindow($(this));
        });


        // bind buttons edit user
        $('[id^=userEditButton_]').click(function () {
            setUserEditModalWindow($(this));
        });


        // bind buttons change user status
        $('[id^=userStatusToggle_]').change(function () {
            let id = $(this).attr('data-id');
            if(id == '{{Auth::user()->id}}') {
                $(this).bootstrapToggle('on', true);
                setLoggedUserStatusModalWindow(id);
            }
            else {
                toggleUserStatus(id);
            }
        });


        // bind buttons change user permissions
        $('[id^=userPermissionsToggle_]').change(function () {
            let id = $(this).attr('data-id');
            if(id == '{{Auth::user()->id}}') {
                $(this).bootstrapToggle('on', true);
                setLoggedUserPermissionsModalWindow(id);
            }
            else {
                toggleUserPermissions(id);
            }
        });




        function setLoggedUserStatusModalWindow(id) {
            $('#modalLongTitle').html('Warning !!!');
            $('#modalBodyHeader').html('You are trying to turn off your status. <b>You will be logged out</b>,  are you sure ?');
            $('#deleteModalWindow').modal('show');
            $('#deleteConfirmButton').unbind("click");
            $('#deleteConfirmButton').click( function () {
                toggleUserStatus(id);
                logOutSystem();
            });
        }




        function setLoggedUserPermissionsModalWindow(id) {
            $('#modalLongTitle').html('Warning !!!');
            $('#modalBodyHeader').html('You are trying to change your own permissions, are you sure ?');
            $('#deleteModalWindow').modal('show');
            $('#deleteConfirmButton').unbind("click");
            $('#deleteConfirmButton').click( function () {
                $('#deleteModalWindow').modal('hide');
                toggleUserPermissions(id);
                // console.log(window.location);
                window.location.reload();
            });
        }



        function setUserEditModalWindow($this) {
            let id = $this.attr('data-id');
            let userName = $this.closest('td').siblings('.userName').find('a').html();
            let userEmail = $this.closest('td').siblings('.userEmail').html();
            $('#userOldPassInput, #userNewPassInput, #userConfirmNewPassInput').val('');
            $('#userTitle').html('Edit user <b>'+ userName +'</b>');
            $('#userNameInput').val(userName);
            $('#userEmailInput').val(userEmail);
            $('#userSubmitButton #buttonValue').html('Save');
            $('#userForm').unbind('submit');
            $('#userForm').submit(function () {
                editUser(id);
                return false;
            });
        }



        function setUserDeleteModalWindow($this) {
            let id = $this.attr('data-id');
            let userName = $this.closest('td').siblings('.userName').find('a').html();
            $('#modalLongTitle').html('Warning !!!');
            $('#modalBodyHeader').html('Do you really want to delete user <b>' + userName + '</b> ?');
            $('#deleteConfirmButton').unbind("click");
            $('#deleteConfirmButton').click( function () {
                deleteUser(id);
            });
        }







        function deleteUser(id) {
            let url = '{{route('users.delete', ['id' => ':id'])}}';
            $.ajax({
               type: "POST",
               url: url.replace(':id', id),
               success: function (response) {
                   $('#deleteModalWindow').modal('hide');
                    $('#tr_user_'+id).hide(1000, function () {
                        $('.message-info').html('<div class="alert alert-danger">' +response.message+ '</div>');
                        $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                    })
               },
                error: function (reject) {
                    $('.modal-message-info').html('<div class="alert alert-danger">Something goes wrong. Go back and try again later</div>');
                    $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
           })
        }


        function toggleUserStatus(id) {
            let url = '{{route('users.status', ['id' => ':id'])}}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                success: function (response) {
                    if(response.rejected) {
                        $('#userStatusToggle_' +id).bootstrapToggle('on', true);
                    }
                    let classType = (response.status) ? 'alert-info' : 'alert-danger';
                    $('.message-info').html('<div class="alert ' +classType+ '">' +response.message+ '</div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);

                },
                error: function (reject) {
                    //change buttonToggle status back
                    $('.message-info').html('<div class="alert alert-danger"> Something goes wrong. User status not changed. Try again later </div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            });
        }


        function toggleUserPermissions(id) {
            let url = '{{route('users.permissions', ['id' => ':id'])}}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                success: function (response) {
                    if(response.rejected) {
                        $('#userPermissionsToggle_' +id).bootstrapToggle('on', true);
                    }
                    let classType = (response.status) ? 'alert-info' : 'alert-danger';
                    $('.message-info').html('<div class="alert ' +classType+ '">' +response.message+ '</div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                },
                error: function (reject) {
                    $('.message-info').html('<div class="alert alert-danger"> Something goes wrong. User permissions not changed. Try again later </div>');
                    $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            });
        }



    </script>
@endsection



