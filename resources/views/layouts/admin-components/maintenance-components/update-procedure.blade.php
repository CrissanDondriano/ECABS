@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
            <h3 class=" fw-bold mb-4">Update Maintenance Procedure</h3>

            <div class="table-responsive">
                <table id="update-procedure" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addTask as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->description }}</td>
                                <td><button type="submit" class="btn btn-warning updateProcedureView" data-bs-toggle="modal"
                                        data-id="{{ $task->id }}" data-name="{{ $task->name }}"
                                        data-description="{{ $task->description }}" data-bs-target="#updateModal">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Update Procedure Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateModalLabel">Update Procedure</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <p class="mb-3 updateTaskId">Task ID: <span id="updateTaskId" name="updateTaskId"></span>
                                </p>
                                <p class="mb-3 updateTaskProcedureName">Task Name: <span id="updateTaskProcedureName"
                                        name="updateTaskProcedureName"></span></p>
                                <div class="mb-2">
                                    <p for="updateTaskProcedureDescription">Procedure Details: </p>
                                    <textarea id="updateTaskProcedureDescription" class="form-control" name="updateTaskProcedureDescription" rows="4"
                                        style="width: 440px"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateTaskProcedure">Update Procedure</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateTaskProcedure() {
            $('.updateProcedureView').click(function() {

                var taskId = $(this).data('id');
                var taskName = $(this).data('name');
                var taskDescription = $(this).data('description');

                $('#updateTaskId').text(taskId);
                $('#updateTaskProcedureName').text(taskName);
                $('#updateTaskProcedureDescription').val(taskDescription);

                $('#updateTaskProcedure').click(function() {
                    var updatedTask = {
                        id: $('#taskId').val(),
                        name: $('#updateTaskProcedureName').val(),
                        description: $('#updateTaskProcedureDescription').val(),
                    };

                    var formData = new FormData();
                    formData.append('id', updatedTask.id);
                    formData.append('name', updatedTask.name);
                    formData.append('description', updatedTask.description);

                    // Perform AJAX request to update the facility
                    $.ajax({
                        url: '/admin/maintenance/updateTaskProcedure/' +
                            taskId, // Update this with the correct route URL
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle the success response
                            swal({
                                title: 'Success',
                                text: 'Update Task Information successfully',
                                icon: 'success'
                            }).then(function() {
                                window.location.href =
                                    '/admin/maintenance/updateProcedure';
                            });
                        },
                        error: function(xhr) {
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error Updating Task: <br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        }

        $(document).ready(function() {
            $('#update-procedure').dataTable({
                responsive: true,
                fixedheader: true,
                drawCallback: function(settings) {
                    updateTaskProcedure();
                }
            });

        });
    </script>
@endsection
