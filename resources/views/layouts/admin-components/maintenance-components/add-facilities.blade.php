@extends('layouts.admin-app')

@section('content')
    <style>
        .hover {
            overflow: hidden;
            position: relative;
            padding-bottom: 60%;
        }

        .hover-overlay {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 90;
            transition: all 0.4s;
        }

        .hover img {
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: all 0.3s;
        }

        .hover-content {
            position: relative;
            z-index: 0;
        }

        .hover-4 img {
            width: 110%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hover-4 .hover-overlay {
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .hover-4-title {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 3rem;
            z-index: 0;
        }

        .hover-4-description {
            position: absolute;
            top: 2rem;
            left: 2rem;
            text-align: right;
            border-right: 3px solid #fff;
            padding: 0 1rem;
            z-index: 0;
            transform: translateX(-1.5rem);
            opacity: 0;
            transition: all 0.3s;
        }

        @media (min-width: 992px) {
            .hover-4-description {
                width: 50%;
            }
        }

        .hover-4:hover img {
            width: 100%;
        }

        .hover-4:hover::after {
            opacity: 1;
            transform: none;
        }

        .hover-4:hover .hover-4-description {
            opacity: 1;
            transform: none;
        }

        .hover-4:hover .hover-overlay {
            background: rgba(0, 0, 0, 0.8);
        }
    </style>

    <div class="container-fluid content-wrapper">
        <div class="row mt-4">
            <h1 class="fw-bold text-start">Available Facilities</h1>
            <div class="py-5">
                <div class="d-flex justify-content-end mb-1" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
                    <button class="btn btn-success">
                        <i class="fas fa-plus px-1"></i>
                        Add Facilities
                    </button>
                    <button class="btn btn-warning mx-3" style="color: #fff;" data-bs-toggle="modal"
                        data-bs-target="#updateModal" class="btn btn-success updateFacilityBtn" data-bs-toggle="modal">
                        <i class="fas fa-edit px-1"></i>
                        Update Facility
                    </button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash px-1"></i>
                        Delete Facility
                    </button>
                    
                </div>
                <hr>
                <div class="row">
                    @foreach ($addFacilities as $addFacility)
                        <div class="col-lg-6 mb-3 mt-4 mb-lg-0">
                            <div class="hover hover-4 text-white rounded">
                                <img src="{{ asset('storage/images/' . $addFacility->image) }}" alt="" loading="lazy">
                                <div class="hover-overlay"></div>
                                <div class="hover-4-content">
                                    <h3 class="hover-4-title text-uppercase fw-bold mb-0">{{ $addFacility->name }}</h3>
                                    <p class="hover-4-description text-uppercase mb-0 small">{{ $addFacility->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Add Facilities Modal -->
    <div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="addModalLabel">Add Facilities</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Warning Alert -->
                    <div class="alert alert-warning alert-dismissible fade show">
                        <strong>Attention!</strong> Please avoid uploading large image files.
                        <p class="mb-2 mt-2">To keep things running smoothly and ensure a better user experience, we kindly
                            request that you refrain from uploading big image files. Excessive file sizes can cause delays
                            and
                            system issues.</p>
                        <p class="mb-2">If you have any questions or need assistance, feel free to reach out to our
                            support
                            team.</p>
                        <p class="mb-2">Thank you for your cooperation!</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <form method="POST" action="{{ url('/admin/maintenance/addFacility') }}" enctype="multipart/form-data"
                        id="formAddFacility">
                        @csrf
                        <div class="m-3">
                            <label for="facilityName" class="form-label">Name of the Facility</label>
                            <input type="text" class="form-control" id="facilityName" name="facilityName" required>
                        </div>
                        <div class="m-3">
                            <label for="facilityDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="facilityDescription" name="facilityDescription" rows="3" required></textarea>
                        </div>
                        <div class="m-3">
                            <label for="facilityImage" class="form-label">Image File</label>
                            <input class="form-control" type="file" id="facilityImage" name="facilityImage" required>
                        </div>
                        <div class="text-end ">
                            <button type="submit" class="btn btn-success ms-1">Add Facility</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Facilities Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateModalLabel">Update Facilities</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">

                            <div class="col-md-12">
                                <div class="my-3">
                                    <select class="form-select" id="facilitySelect" aria-label="Default select example">
                                        <option selected>Select Facility ID</option>
                                        @foreach ($addFacilities as $facility)
                                            <option data-image="{{ asset('storage/images/' . $facility->image) }}"
                                                data-name="{{ $facility->name }}"
                                                data-description="{{ $facility->description }}">
                                                {{ $facility->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-floating my-3">
                                    <input type="text" id="updateFacilityName" class="form-control"
                                        placeholder=" " name="updateFacilityName" />
                                    <label for="updateFacilityName">Facility Name</label>
                                </div>
                                <div class="form-floating my-3">
                                    <textarea id="description" class="form-control" placeholder=" " name="description" rows="4"></textarea>
                                    <label for="description">Description</label>
                                </div>
                                <div class=" my-3 text-center">
                                    <img class="img mb-2 border border-warning" style="width: 50%; height: 50%;"
                                        id="updateFacilityImage" src="" alt="">
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning "id="updateFacility">Update Facilities</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Facilities List Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete Facilities</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <select class="form-select" id="deletefacilitySelect"
                                        aria-label="Default select example">
                                        <option selected>Select Facility ID</option>
                                        @foreach ($addFacilities as $facility)
                                            <option data-name="{{ $facility->name }}" data-id="{{ $facility->id }}"> <!-- Change here -->
                                                {{ $facility->id }} - {{ $facility->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="my-3">
                                    <p>Are you sure you want to delete this facility?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="facilityDelete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
