@extends('layouts.app')

@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4 ps-5">To-Do list</h4>
    <div class="card p-2 ms-3" style="width: 1225px;">
        <div class="row gy-3">
            <div>
                <button type="button" class="btn btn-primary float-end ms-2 mb-2 me-4" id="user_modalbtn">
                    Add 
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table pt-2 " id="usertable">
                    <thead class="table-light  mt-3">
                        <tr class="text-nowrap">
                            <th class="text-dark">No</th>
                            <th class="text-dark">Title</th>
                            <th class="text-dark">Discription</th>
                            <th class="text-dark">Status</th>
                            <th class="text-dark">Date : When Created</th>
                            <th class="text-dark">Date : When Updated</th>
                            <th class="text-dark">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AdduserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="AddUser_from" onsubmit="return false;">

                    @csrf
                    <div class="mb-3">
                        <label for="name" class="p-1"> Title</label>
                        <input type="hidden" name="hid" id="hid">
                        <input type="text" class="form-control" id="title" placeholder="Title" name="title">
                    </div>



                    <div class="mb-3">
                        <label for="description" class="p-1">Discription</label>
                        <input type="text" class="form-control" id="description" placeholder="Description" name="description">
                    </div>

               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit"> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection
