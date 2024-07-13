@extends('layouts.admin-app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Oswald:300,400,500,700');
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');

        .design-text {
            font-family: 'Open Sans', sans-serif;
        }

        .design-text1 {
            font-family: 'Oswald', sans-serif;
        }

        .bg-profile {
            background-image: radial-gradient(circle farthest-corner at 17.1% 22.8%, rgba(226, 24, 24, 1) 0%, rgba(160, 6, 6, 1) 90%);
        }

        .profile-info-list {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }


        .profile-info-list>li.title {
            font-size: 0.625rem;
            font-weight: 700;
            color: #8a8a8f;
            padding: 0 0 0.3125rem;
        }

        .profile-info-list>li+li.title {
            padding-top: 1.5625rem;
        }

        .profile-info-list>li {
            padding: 0.625rem 0;
        }

        .profile-info-list>li .field {
            font-weight: 700;
        }

        .profile-info-list>li .value {
            color: #666;
        }

        .profile-info-list>li.img-list a {
            display: inline-block;
        }

        .profile-info-list>li.img-list a img {
            max-width: 2.25rem;
            -webkit-border-radius: 2.5rem;
            -moz-border-radius: 2.5rem;
            border-radius: 2.5rem;
        }

        .table.table-profile th {
            border: none;
            color: #000;
            padding-bottom: 0.3125rem;
            padding-top: 0;
        }

        .table.table-profile td {
            border-color: #c8c7cc;
        }

        .table.table-profile tbody+thead>tr>th {
            padding-top: 1.5625rem;
        }

        .table.table-profile .field {
            color: #666;
            font-weight: 600;
            width: 25%;
            text-align: right;
        }

        .table.table-profile .value {
            font-weight: 500;
        }

        @media (max-width: 767px) {
            .profile-container {
                padding: 0.9375rem 0.9375rem 3.6875rem;
            }

            .friend-list>li {
                float: none;
                width: auto;
            }
        }

        .profile-info-list {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .friend-list,
        .img-grid-list {
            margin: -1px;
            list-style-type: none;
        }

        .profile-info-list>li.title {
            font-size: 0.625rem;
            font-weight: 700;
            color: #8a8a8f;
            padding: 0 0 0.3125rem;
        }

        .profile-info-list>li+li.title {
            padding-top: 1.5625rem;
        }

        .profile-info-list>li {
            padding: 0.625rem 0;
        }

        .profile-info-list>li .field {
            font-weight: 700;
        }

        .profile-info-list>li .value {
            color: #666;
        }

        .profile-info-list>li.img-list a {
            display: inline-block;
        }

        .table.table-profile th {
            border: none;
            color: #000;
            padding-bottom: 0.3125rem;
            padding-top: 0;
        }

        .table.table-profile td {
            border-color: #c8c7cc;
        }

        .table.table-profile tbody+thead>tr>th {
            padding-top: 1.5625rem;
        }

        .table.table-profile .field {
            color: #666;
            font-weight: 600;
            width: 25%;
            text-align: right;
        }

        .table.table-profile .value {
            font-weight: 500;
        }

        .friend-list {
            padding: 0;
        }

        .friend-list>li {
            float: left;
            width: 50%;
        }

        .friend-list>li>a {
            display: block;
            text-decoration: none;
            color: #000;
            padding: 0.625rem;
            margin: 1px;
            background: #fff;
        }

        .friend-list>li>a:after,
        .friend-list>li>a:before {
            content: "";
            display: table;
            clear: both;
        }

        .friend-list .friend-info {
            margin-left: 3.625rem;
        }

        .friend-list .friend-info h4 {
            margin: 0.3125rem 0;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .friend-list .friend-info p {
            color: #666;
            margin: 0;
        }

        .bg-secondary-soft {
            background-color: rgba(208, 212, 217, 0.1) !important;
        }

        .rounded {
            border-radius: 5px !important;
        }

        .py-5 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .file-upload .square {
            height: 250px;
            width: 250px;
            margin: auto;
            vertical-align: middle;
            border: 1px solid #e5dfe4;
            background-color: #fff;
            border-radius: 5px;
        }

        .text-secondary {
            --bs-text-opacity: 1;
            color: rgba(208, 212, 217, 0.5) !important;
        }

        .btn-success-soft {
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }

        .btn-danger-soft {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.6;
            color: #29292e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e5dfe4;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 5px;
            -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        }
    </style>
    <div class="container-fluid pt-2 content-wrapper rounded">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card inventory-container">
                    <div class="card-header bg-profile text-white d-flex flex-row"
                        style="background-color: #000; height:200px;">
                        <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                            <img src="{!! url('assets/images/temp-profile.jpg') !!}"
                                alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                style="width: 150px; z-index: 1">
                            <button type="button" id="updateAdminProfile" class="btn btn-outline-dark border-4 text-uppercase design-text fw-bold"
                                style="z-index: 1;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                Edit profile
                            </button>
                        </div>
                        <div class="ms-3" style="margin-top: 130px;">
                            <h5>{{ Auth::user()->name }}</h5>
                            <p>Cabuyao</p>
                        </div>
                    </div>
                    <div class="p-4 text-black" style="background-color: #f8f9fa;">
                        <div class="d-flex justify-content-end text-center py-1">
                            <div class="px-3">
                                <p class="mb-4 h6 badge rounded-pill d-inline-block bg-primary">Administrator</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4" style="background-color: #f8f9fa;">
                        <div class="mb-5">
                            {{-- @foreach($userDetails as $userDetail) --}}
                            <div class="profile-container">
                                <div class="row row-space-20">
                                    <div class="col-md-8">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane active show" id="profile-about">
                                                <table class="table table-profile">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="background: #f8f9fa;">BASIC
                                                                INFORMATION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="field">Email</td>
                                                            <td class="value">
                                                                {{ $userDetails->email }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Contact Number</td>
                                                            <td class="value">
                                                                {{ $userDetails->contact }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Address</td>
                                                            <td class="value">
                                                                {{ $userDetails->address }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Birth of Date</td>
                                                            <td class="value">
                                                                {{ $userDetails->birthdate }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Gender</td>
                                                            <td class="value">
                                                                Male
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 hidden-xs hidden-sm">
                                        <ul class="profile-info-list">
                                            <li class="title">PERSONAL INFORMATION</li>
                                            <li>
                                                <div class="field">Birth of Date:</div>
                                                <div class="value">{{ $userDetails->birthdate }}</div>
                                            </li>
                                            <li>
                                                <div class="field">Country:</div>
                                                <div class="value">Philippines</div>
                                            </li>
                                            <li>
                                                <div class="field">Address:</div>
                                                <div class="value">
                                                    <address class="m-b-0">
                                                        {{ $userDetails->address }}
                                                    </address>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="field">Phone No.:</div>
                                                <div class="value">
                                                    {{ $userDetails->contact }}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fw-bold design-text" id="editProfileLabel">My Profile</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="updateProfileForms" class="modal-body">
                    <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                        <ul class="nav nav-tabs justify-content-end" style="flex-grow: 1;">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                                    href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                                    aria-selected="true">Manage Profile Information</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab"
                                    href="#ex-with-icons-tabs-2" role="tab" aria-controls="ex-with-icons-tabs-2"
                                    aria-selected="false">Change Email Address</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ex-with-icons-tab-3" data-bs-toggle="tab"
                                    href="#ex-with-icons-tabs-3" role="tab" aria-controls="ex-with-icons-tabs-3"
                                    aria-selected="false">Change Passwords</a>
                            </li>
                        </ul>
                    </ul>
                    <div class="tab-content" id="ex-with-icons-content">
                        <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                            aria-labelledby="ex-with-icons-tab-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="file-upload">
                                        <div class="row mb-2">
                                            <div class="col-xxl-12">
                                                <div class="px-4 pt-4 rounded">
                                                    <div class="row ">
                                                        <h4 class="mb-4 mt-0 design-text text-muted fw-bold text-capitalize">
                                                            Profile Information</h4>

                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label design-text text-muted">User Name
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" id="updateAdminName"
                                                                class="form-control" placeholder="Enter your Name"
                                                                aria-label="User name">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label design-text text-muted">Contact Number
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" id="updateAdminContact"
                                                                class="form-control"
                                                                placeholder="Enter your Contact Number"
                                                                aria-label="Contact number">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label design-text text-muted">Birth of Date
                                                                <span class="text-danger">*</span></label>
                                                            <input id="updateAdminBirthdate" class="form-control"
                                                                type="date" placeholder="Enter your Birthdate"
                                                                aria-label="Birth of Date">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label design-text text-muted">Address <span
                                                                    class="text-danger">*</span></label>
                                                            <input id="updateAdminAddress" class="form-control"
                                                                type="text" value=""
                                                                placeholder="Enter your Address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel"
                            aria-labelledby="ex-with-icons-tab-2">
                            <div class="row mb-2">
                                <div class="col-xxl-12">
                                    <div class="px-4 rounded">
                                        <div class="row">
                                            <h4 class="my-4 design-text text-muted fw-bold text-capitalize">
                                                Change Email</h4>
                                            <div class="col-md-6">
                                                <label class="form-label design-text text-muted">Email Address
                                                    <span class="text-danger">*</span></label>
                                                <input id="updateAdminEmail" class="form-control"
                                                    type="email" value=""
                                                    placeholder="Enter your Email Address">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="exampleInputPassword2"
                                                    class="form-label design-text text-muted">Password
                                                    <span class="text-danger">*</span></label>
                                                <input id="updateAdminPass" class="form-control"
                                                    type="password" value=""
                                                    placeholder="Enter your New Password">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="exampleInputPassword3"
                                                    class="form-label design-text text-muted">Confirm Password
                                                    <span class="text-danger">*</span></label>
                                                <input id="updateAdminConfirm" class="form-control"
                                                    type="password" value=""
                                                    placeholder="Enter your Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel"
                            aria-labelledby="ex-with-icons-tab-3">
                            <div class="row mb-2">
                                <div class="col-xxl-12">
                                    <div class="px-4 rounded">
                                        <div class="row">
                                            <h4 class="my-4 design-text text-muted fw-bold text-capitalize">
                                                Change Password</h4>
                                            <div class="col-md-12">
                                                <label for="exampleInputPassword1"
                                                    class="form-label design-text text-muted">Old password
                                                    <span class="text-danger">*</span></label>
                                                <input id="updateAdminOldPass" class="form-control"
                                                    type="password" value=""
                                                    placeholder="Enter your Old Password">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="exampleInputPassword2"
                                                    class="form-label design-text text-muted">New password
                                                    <span class="text-danger">*</span></label>
                                                <input id="updateAdminNewPass" class="form-control"
                                                    type="password" value=""
                                                    placeholder="Enter your New Password">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="exampleInputPassword3"
                                                    class="form-label design-text text-muted">Confirm Password
                                                    <span class="text-danger">*</span></label>
                                                <input id="updateAdminNewConfirm" class="form-control"
                                                    type="password" value=""
                                                    placeholder="Enter your Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateAdminProfileBtn">Update profile</button>
                </div>
            </div>
        </div>
    </div>
@endsection
