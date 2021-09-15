@extends('layout')

@section('content')
    <div class="text-center">
        <h4>
            All Categories
        </h4>
    </div>
{{--    @include ('pages.errors')--}}
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
    {{Form::open(['route' => ['categories.upload', 'method'=>'POST']])}}
    <table class="table table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Category</th>
            <th scope="col">History</th>
            @if(Auth::user()->is_admin)
                <th scope="col">Actions</th>
            @endif
            <th scope="col" id="extra">Extra</th>
        </tr>
        </thead>
        <tbody id="categoryTableBody">
            @if($categories->isNotEmpty())
                @foreach($categories as $category)
                    <tr id="tr_category_{{$category->id}}">
                        <th scope="row">{{$category->id}}</th>
                        <td class="categoryName">{{$category->title}}</td>
                        <td class="small">
                            @if($category->getLatestHistory(2))
                                @foreach($category->getLatestHistory(2) as $history)
                                    {{$history}}
                                    <br>
                                @endforeach
                                <a href="{{route('categories.history', ["id" => $category->id])}}">more...</a>
                            @else
                                {{'There is no history for this category'}}
                            @endif
                        </td>
                        @if(Auth::user()->is_admin)
                            <td>
                                <div class="flex-row">
                                    <button type="button" id="categoryEditButton_{{$category->id}}" class="btn btn-success" data-id="{{$category->id}}" data-toggle="modal" data-target="#categoryModalWindow">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" id="categoryDeleteButton_{{$category->id}}" class="btn btn-danger" data-id="{{$category->id}}" data-toggle="modal" data-target="#deleteModalWindow">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        @endif
                        <td>
                                <div class="form-row">
                                    <div class="form-group col-3">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-info active">
                                                <input type="radio" name="asc_desc[{{$category->id}}]" value="0" autocomplete="off" checked> +
                                            </label>
                                            <label class="btn btn-outline-info ">
                                                <input type="radio" name="asc_desc[{{$category->id}}]" value="1" autocomplete="off"> -
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-3">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-info active">
                                                <input type="radio" name="perc_rate[{{$category->id}}]" value="0" autocomplete="off" checked>
                                                <i class="fas fa-percentage"></i>
                                            </label>
                                            <label class="btn btn-outline-info ">
                                                <input type="radio" name="perc_rate[{{$category->id}}]" value="1" autocomplete="off">
                                                <i class="fas fa-dollar-sign"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="number" min="0" placeholder="Value" class="form-control" name="value[{{$category->id}}]">
                                    </div>
                                </div>
                        </td>
                    </tr>
               @endforeach
            @else
{{--                <div class="text-center alert alert-primary">There is no categories</div>--}}
                <script>
                    $('.message-info').html('<div class="alert alert-danger"> There is no history for this user </div>');
                    // $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                    $('.message-info').slideDown(1000);
                </script>
            @endif
        </tbody>
    </table>


    {{$categories->onEachSide(2)->links('')}}


    <button type="button" id="addCategory" class="btn btn-primary float-left" data-toggle="modal" data-target="#categoryModalWindow">
        <i class="fas fa-plus"></i>
        Add new
    </button>
    <button type="submit" value="submit" class="btn btn-success float-right">
        <i class="fas fa-share-square"></i>
        Upgrade
    </button>
    {{Form::close()}}




    {{--    modal dialog add/edit form--}}
    <div class="modal fade" id="categoryModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-message-info">
                </div>
                <form id="categoryForm" role="form">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input type="text" id="categoryTitleInput" autofocus class="form-control" name="title" data-placement="{{config('view.tooltip_position')}}" title="Category title">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </button>
                        <button id="categorySubmitButton" type="submit" class="btn btn-success">
                            <i class="far fa-save" id="categoryButtonSubmit"></i>
                            <span id="buttonValue"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>


        // bind buttons delete category
        $('[id^=categoryDeleteButton_]').click(function () {
            setCategoryDeleteModalWindow($(this));
        });


        //bind button add category
        $('#addCategory').click( function () {
            $('#categoryTitle').html('Create new category');
            $('#categoryTitleInput').attr('placeholder', 'New category').val('');
            $('#categorySubmitButton #buttonValue').html('Create');
            $('#categoryForm').unbind('submit');
            $('#categoryForm').submit(function () {
                addCategory();
                return false;
            });
        });


        // bind buttons edit category
        $('[id^=categoryEditButton_]').click(function () {
            setCategoryEditModalWindow($(this));
        });


        function setCategoryDeleteModalWindow($this) {
            let id = $this.attr('data-id');
            let categoryName = $this.closest('td').siblings('.categoryName').html();
            $('#modalLongTitle').html('Warning !!!');
            $('#modalBodyHeader').html('Do you really want to delete category <b>'+ categoryName +'</b>, and all history for it ?');
            $('#deleteConfirmButton').unbind("click");
            $('#deleteConfirmButton').click( function () {
                deleteCategory(id);
            });
        }


        function setCategoryEditModalWindow($this) {
            let id = $this.attr('data-id');
            let categoryName = $this.closest('td').siblings('.categoryName').html();
            $('#categoryTitle').html('Edit category <b>'+ categoryName +'</b>');
            $('#categoryTitleInput').attr('placeholder', 'Category name').val(categoryName);
            $('#categorySubmitButton #buttonValue').html('Save');
            $('#categoryForm').unbind('submit');
            $('#categoryForm').submit(function () {
                editCategory(id);
                return false;
            });
        }





        function editCategory(id) {
            let url = '{{route('categories.update',['id' => ':id'])}}';
            $.ajax({
                type: "PUT",
                // url: "categories/" +id,
                url: url.replace(':id', id),
                data: $('#categoryForm').serialize(),
                success: function (response) {
                    if(response.status) {
                        $('#categoryModalWindow').modal('hide');
                        $('#tr_category_' + id + ' .categoryName').hide(1000,function () {
                            $(this).html(response.title);
                        }).show(1000, function () {
                            $('.message-info').html('<div class="alert alert-info"> Category' +response.title+ ' is updated </div>');
                            $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                        });
                    }
                    else {
                        $('.modal-message-info').html('<div class="alert alert-danger"> Category is not updated. Enter other category title, or try again later! </div>');
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
                    $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            })
        }

        function deleteCategory(id) {
            let url = '{{route('categories.delete', ['id' => ':id'])}}';
            $.ajax({
                type: "POST",
                // url: "categories/" +id+ "/destroy",
                url: url.replace(':id', id),
                data: {'id': id },
                success: function (response) {
                    $('#deleteModalWindow').modal('hide');
                    $('#tr_category_'+id).hide(1000, function () {
                        $('.message-info').html('<div class="alert alert-danger">' +response.message+ '</div>');
                        $('.message-info').slideDown(1000).delay(2000).slideUp(1000);
                    })
                },
                error: function (reject) {
                    console.log(reject);
                    $('.modal-message-info').html('<div class="alert alert-danger">Something goes wrong. Go back and try again later</div>');
                    $('.modal-message-info').slideDown(1000).delay(2000).slideUp(1000);
                }
            })
        }

        function addCategory() {
            $.ajax({
                type: "POST",
                url: "{{ route('categories.store') }}",
                data: $('#categoryForm').serialize(),
                success: function (response) {
                    $('#categoryModalWindow').modal('hide');
                    // functional to add new category in create new tr
                    let trNewCategory = "<tr id=\"tr_category_" +response.id+ "\">\n" +
                        "                        <th scope=\"row\">" +response.id+ "</th>\n" +
                        "                        <td class=\"categoryName\">" +response.title+ "</td>\n" +
                        "                        <td class=\"small\">\n" +
                        "                                                            There is no history for this category\n" +
                        "                        </td>" +
                        @if(Auth::user()->is_admin)
                        "                       <td>\n" +
                        "                            <div class=\"flex-row\">\n" +
                        "                                <button type=\"button\" id=\"categoryEditButton_" +response.id+ "\" class=\"btn btn-success\" data-id=\"" +response.id+ "\" data-toggle=\"modal\" data-target=\"#categoryModalWindow\">\n" +
                        "                                    <i class=\"fas fa-edit\"></i>\n" +
                        "                                </button>\n" +
                        "                                <button type=\"button\" id=\"categoryDeleteButton_" +response.id+ "\" class=\"btn btn-danger\" data-id=\"" +response.id+ "\" data-toggle=\"modal\" data-target=\"#deleteModalWindow\">\n" +
                        "                                    <i class=\"fas fa-trash-alt\"></i>\n" +
                        "                                </button>\n" +
                        "                            </div>\n" +
                        "                        </td>\n" +
                        @endif
                        "                        <td>\n" +
                        "                                <div class=\"form-row\">\n" +
                        "                                    <div class=\"form-group col-3\">\n" +
                        "                                        <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" +
                        "                                            <label class=\"btn btn-outline-info active\">\n" +
                        "                                                <input type=\"radio\" name=\"asc_desc[" +response.id+ "]\" value=\"0\" autocomplete=\"off\" checked=\"\"> +\n" +
                        "                                            </label>\n" +
                        "                                            <label class=\"btn btn-outline-info\">\n" +
                        "                                                <input type=\"radio\" name=\"asc_desc[" +response.id+ "]\" value=\"1\" autocomplete=\"off\"> -\n" +
                        "                                            </label>\n" +
                        "                                        </div>\n" +
                        "                                    </div>\n" +
                        "                                    <div class=\"form-group col-3\">\n" +
                        "                                        <div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" +
                        "                                            <label class=\"btn btn-outline-info active\">\n" +
                        "                                                <input type=\"radio\" name=\"perc_rate[" +response.id+ "]\" value=\"0\" autocomplete=\"off\" checked=\"\">\n" +
                        "                                                <i class=\"fas fa-percentage\"></i>\n" +
                        "                                            </label>\n" +
                        "                                            <label class=\"btn btn-outline-info\">\n" +
                        "                                                <input type=\"radio\" name=\"perc_rate[" +response.id+ "]\" value=\"1\" autocomplete=\"off\">\n" +
                        "                                                <i class=\"fas fa-dollar-sign\"></i>\n" +
                        "                                            </label>\n" +
                        "                                        </div>\n" +
                        "                                    </div>\n" +
                        "                                    <div class=\"form-group col-6\">\n" +
                        "                                        <input type=\"number\" min=\"0\" placeholder=\"Value\" class=\"form-control\" name=\"value[" +response.id+ "]\">\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                        </td>\n" +
                        "                    </tr>";

                    $('#categoryTableBody').append(trNewCategory);
                    $('#categoryDeleteButton_'+ response.id).click(function () {
                        setCategoryDeleteModalWindow($(this));
                    });
                    $('#categoryEditButton_'+ response.id).click(function () {
                        setCategoryEditModalWindow($(this));
                    });
                    $('#tr_category_'+response.id).css('display', 'none').show(1000, function () {
                        $('.message-info').html('<div class="alert alert-info">Category '+ response.title+' is created.</div>');
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
            })
        }


    </script>
@endsection
