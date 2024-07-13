@extends('layouts.admin-app')

@section('content')
    <style>
        .text-muted {
            color: #8898aa !important;
        }

        [type=button]:not(:disabled),
        [type=reset]:not(:disabled),
        [type=submit]:not(:disabled),
        button:not(:disabled) {
            cursor: pointer;
        }

        div.dataTables_wrapper div.dataTables_filter {
            display: none;
        }
    </style>

    <div class="container-fluid content-wrapper">
        <div class="row my-4 p-1">
            <div class="col-12 col-lg-10 col-md-10">
                <h3 class=" fw-bold mb-4">Manage User</h3>

                <div class="table-responsive">
                    <table id="manage-user" class="table table-hover nowrap w-100 ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                {{-- <th scope="col">Status</th> --}}
                                <th scope="col">Added</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userLists as $userList)
                                <tr>
                                    <td scope="row">{{ $userList->id }}</td>
                                    <td>
                                        <span class="fw-bold mb-0">{{ $userList->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $userList->email }}</span>
                                    </td>
                                    @php
                                        $onlineThreshold = now()->subMinutes(5);
                                        $isOnline = $userList->last_online >= $onlineThreshold;
                                    @endphp

                                    <td>
                                        <span class="text-muted">{{ $userList->created_at }}</span>
                                    </td>

                                    <td>
                                        <span class="text-muted">
                                            @if ($userList->type == 'admin')
                                                Admin
                                            @else
                                                Staff
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if ($userList->id != auth()->id())
                                            <button type="button" class="btn btn-danger deleteUser"
                                                data-id="{{ $userList->id }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                                        @endif

                                        <button type="button" class="btn btn-warning updateUser"
                                            data-id="{{ $userList->id }}" data-name="{{ $userList->name }}"
                                            data-address="{{ $userList->address }}" data-email="{{ $userList->email }}"
                                            data-bs-toggle="modal" data-bs-target="#update-user-modal"><i
                                                class="fas fa-edit" style="color: #fff;"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-12 col-lg-2 col-md-2">
                <div class="card rounded-0"
                    style=" box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;">
                    <div class="card-body">
                        <div class="text-center">
                            <button class="btn btn-success btn-block px-4 fw-bold" type="button" data-bs-toggle="modal"
                                data-bs-target="#user-form-modal">New User</button>
                        </div>
                        <hr class="my-3">
                        <div>
                            <div class="form-group">
                                <label for="name-search">Search by Name:</label>
                                <div><input id="search-bar" class="form-control w-100" type="text" placeholder=""
                                        value=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Form Modal -->
    <div class="modal fade" role="dialog" tabindex="-1" id="user-form-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="py-1">
                        <div class="row">
                            <div class="col">
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="full-name">Name</label>
                                            <input id="full-name" class="form-control" type="text" name="full-name"
                                                placeholder="John Smith">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="userAddress">Address</label>
                                            <input id="userAddress" class="form-control" type="text"
                                                name="userAddress" placeholder="123 PlaceHolder JohnDoe, SampleText">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-2">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" class="form-control" type="text"
                                                placeholder="user@example.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-4">
                                        <div class="form-group">
                                            <label for="userType">Category</label>
                                            <select id="userType" class="form-select"
                                                aria-label="Default select example">
                                                <option selected>Open this category</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 mb-3">
                                <div class="mb-2"><b>Password</b></div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="new-password">Password</label>
                                            <input id="new-password" class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="confirm-password">Confirm Password</label>
                                            <input id="confirm-password" class="form-control" type="password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button id="addUserBtn" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Update Form Modal -->
    <div class="modal fade" role="dialog" tabindex="-1" id="update-user-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Update User Informations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="py-1">
                        <div class="row">
                            <div class="col">
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="update-full-name">Name</label>
                                            <span id="updateUserId" style="display:none"></span>
                                            <input id="update-full-name" class="form-control" type="text"
                                                name="update-full-name" placeholder="John Smith" value="John Smith">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="update-userAddress">Address</label>
                                            <input id="update-userAddress" class="form-control" type="text"
                                                name="update-userAddress" placeholder="johnny.s" value="johnny.s">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-2">
                                        <div class="form-group">
                                            <label for="update-email">Email</label>
                                            <input id="update-email" class="form-control" type="text"
                                                placeholder="user@example.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-4">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select id="update-userType" class="form-select"
                                                aria-label="Default select example">
                                                <option selected>Open this category</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button id="updateUserBtn" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this User. <span id="deleteUserId"></span>? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="userDeleteBtn" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Modal -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#addUserBtn').click(function() {
                var fullName = $("#full-name").val();
                var address = $("#userAddress").val();
                var email = $("#email").val();
                var type = $("#userType").val();
                var newPass = $("#new-password").val();
                var confirmPass = $("#confirm-password").val();

                $.ajax({
                    url: '/admin/userManage/add_user',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        fullName: fullName,
                        address: address,
                        email: email,
                        type: type,
                        newPass: newPass,
                        confirmPass: confirmPass
                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'User created successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/manageUser';
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            var message = xhr.responseJSON.message;

                            // Display SweetAlert error notification
                            swal({
                                icon: 'error',
                                title: 'Error on Creating User',
                                text: message
                            });
                        } else {
                            // Handle other error cases
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error on Creating User: <br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    }
                });
            });

            $('.updateUser').click(function() {
                var id = $(this).data("id");
                var name = $(this).data("name");
                var address = $(this).data("address");
                var email = $(this).data("email");

                $('#updateUserId').val(id);
                $('#update-full-name').val(name);
                $('#update-email').val(email);
                $('#update-userAddress').val(address);
            });

            $('#updateUserBtn').click(function() {
                var id = $('#updateUserId').val();
                var fullName = $("#update-full-name").val();
                var address = $("#update-userAddress").val();
                var email = $("#update-email").val();
                var type = $("#update-userType").val();
                // var currentPass = $("#current-password").val();
                // var newPass = $("#update-password").val();
                // var confirmPass = $("#update-confirm-password").val();

                $.ajax({
                    url: '/admin/userManage/update_user',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: id,
                        fullName: fullName,
                        address: address,
                        email: email,
                        type: type,
                        // currentPass: currentPass,
                        // newPass: newPass,
                        // confirmPass: confirmPass
                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'User created successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/manageUser';
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            var message = xhr.responseJSON.message;

                            // Display SweetAlert error notification
                            swal({
                                icon: 'error',
                                title: 'Error on Creating User',
                                text: message
                            });
                        } else {
                            // Handle other error cases
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error on Updating User: <br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    }
                });
            });

            $('.deleteUser').click(function() {
                var id = $(this).data('id');

                $('#deleteUserId').text(id);
            });

            // Delete User Modal
            $('#userDeleteBtn').click(function() {
                var userId = $('#deleteUserId').text();

                $.ajax({
                    url: '/admin/userManage/delete_user/' + userId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'User deleted successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/manageUser';
                        });
                    },
                    error: function(xhr) {
                        // Handle the error response
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error on Deleting User: <br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                });
            });


            var userTable = $('#manage-user').DataTable({
                responsive: true,
                fixedheader: true,
                lengthChange: false,
            });

            $('#search-bar').on('keyup', function() {
                // Get the value from the search input
                var searchValue = $(this).val();

                // Use the column().search() method to filter the table
                userTable.column(1).search(searchValue).draw();
            });
        });
    </script>
@endsection
