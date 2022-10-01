import Vue from "vue";

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
            url: routes['categories.index'],
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
                url: routes['categories.index'] + '/' + start,
                success: function (result) {
                    THIS.services = result.data;
                    THIS.service_id = '';
                    THIS.$nextTick(() => {
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
