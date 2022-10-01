@extends('layouts.main')

@push('styles')
    <style>
        .select2-container .select2-selection--single {
            height: 40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            height: 100%;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single {
            border-radius: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
    </style>
@endpush

@section('content')
    <div id="app">
        <div class="py-5 text-center">
            <h2>Select2: Dependent Dropdown</h2>
            <p class="lead">
                Here service depends on category.
            </p>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <div class="card">
                    <h5 class="card-header">Your Selection</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Selected Category ID</span>
                            <strong>@{{ category_id }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Selected Service ID</span>
                            <strong>@{{ service_id }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 order-md-1">
                <div class="card">
                    <h5 class="card-header">Services</h5>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" name="category_id" id="category_id" @change="onchangeCategory" v-model="category_id" v-select2>
                                    <option v-for="category in categories" :key="category.id" :data-img="category.image" :value="category.id">@{{ category.title }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="service_id">Service</label>
                                <select class="form-control" name="service_id" id="service_id" v-model="service_id" v-select2>
                                    <option v-for="service in services" :key="service.id" :data-img="service.image" :value="service.id">@{{ service.title }}</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const routes = {
            'categories.index': @json(route('categories.index')),
        };
    </script>
    @vite('resources/js/select2.js')
@endpush
