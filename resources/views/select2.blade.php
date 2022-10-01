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
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            const el = state.element;
            let $state = `<div style="display: flex; align-items: center;">`;
            const image = $(el).data('img');
            if (image) {
                $state += `<div><img sytle="display: inline-block;" src="${image}" style="height: 34px;width: auto;" /></div>`;
            }
            $state += `<div style="margin-left: 10px;">${state.text}</div></div>`;
            return $($state);
        }

        Vue.directive('select2', {
            inserted(el) {
                $(el).on('select2:select', () => {
                    const event = new Event('change', {bubbles: true, cancelable: true});
                    el.dispatchEvent(event);
                });
                $(el).on('select2:unselect', () => {
                    const event = new Event('change', {bubbles: true, cancelable: true})
                    el.dispatchEvent(event)
                })
            },
        });
        new Vue({
            el: '#app',
            data: {
                categories: [],
                services: [],
                category_id: '',
                service_id: '',
            },
            mounted() {
                const THIS = this;
                $('#category_id').select2({
                    templateSelection: formatState,
                    templateResult: formatState,
                });
                $('#service_id').select2({
                    templateSelection: formatState,
                    templateResult: formatState,
                });
                $.ajax({
                    url: @json(route('categories.index')),
                    success: function (result) {
                        THIS.categories = result.data;
                    }
                });
            },
            methods: {
                onchangeCategory($event) {
                    const THIS = this;
                    const start = $event.target.value;
                    $.ajax({
                        url: @json(route('categories.index')) + '/' + start,
                        success: function (result) {
                            THIS.services = result.data;
                            THIS.$nextTick(() => {
                                $('#service_id').val(null).trigger('change');
                                $('#service_id').select2({
                                    templateSelection: formatState,
                                    templateResult: formatState,
                                });
                            });
                        }
                    });
                }
            }
        });
    </script>
@endpush
