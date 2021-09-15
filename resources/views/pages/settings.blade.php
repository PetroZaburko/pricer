@extends('layout')

@section('content')

    <div id="editUserForm"></div>
    <div id="editCompanyForm"></div>

    <div class="text-center">
        <h4>
            All Settings
        </h4>
    </div>
    <div class="col-4 ml-5">
        <div class="list-group list-group-flush">
            <button type="button" id="editLoggedUsrBtn" class="list-group-item list-group-item-action" data-id="{{Auth::user()->id}}" data-toggle="modal" data-target="">
                <i class="fas fa-user-edit"></i>
                User settings
            </button>
            @if(Auth::user()->is_admin)
            <button type="button" id="editCompanyBtn" class="list-group-item list-group-item-action"  data-id="{{Auth::user()->company_id}}" data-toggle="modal" data-target="">
{{--                <i class="fas fa-building"></i>--}}
                <i class="fas fa-tools"></i>
                Company settings
            </button>
            @endif
        </div>
    </div>



    <script>

        let loggedUserName;
        let loggedUserEmail;

        $("#editLoggedUsrBtn").click(function () {
            $('#editUserForm').load('{{route("users.index")}}'+ ' #userModalWindow', function () {
                $(':input').tooltip();
                $(':password').password();
                let id = $('.authUser').data('id');
                let userName = loggedUserName ? loggedUserName : '{{Auth::user()->name}}';
                let userEmail = loggedUserEmail ? loggedUserEmail : '{{Auth::user()->email}}';
                $('#userOldPassInput, #userNewPassInput, #userConfirmNewPassInput').val('');
                $('#userTitle').html('Edit user <b>'+ userName +'</b>');
                $('#userNameInput').val(userName);
                $('#userEmailInput').val(userEmail);
                $('#userSubmitButton #buttonValue').html('Save');
                $('#userModalWindow').modal('show');
                $('#userForm').unbind('submit');
                $('#userForm').submit(function () {
                    editUser(id);
                    return false;
                });
            });
        });


        $('#editCompanyBtn').click(function () {
            $('#editCompanyForm').load('{{route("companies.index")}}' + ' #companyModalWindow', function () {
                $(':input').tooltip();
                $(':password').password();
                $('#companyModalWindow').modal('show');

                // getCompanyValues($(this).attr('data-id'));
                getCompanyValues('{{Auth::user()->company_id}}');
            });
        });




    </script>

@endsection
