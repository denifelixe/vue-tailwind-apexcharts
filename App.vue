<script setup>
    import { onMounted, ref } from 'vue';
    import moment from 'moment';

    import ApexChartSplineArea from './ApexChartSplineArea.vue';

    // Audience Chart
    let chartIsLoaded = ref(false);
        let showSomethingChartFromDate = ref();
        let showSomethingChartToDate = ref();
        const xAxis = ref();
        const tooltip = ref();
        const series = ref();

        function setSomethingChart() {

            chartIsLoaded.value = false;

            window.axios.get('/webapi/somethings-chart', {
                params: {
                    showSomethingChartFromDate: showSomethingChartFromDate.value ? moment(showSomethingChartFromDate.value).toISOString(true) : moment().subtract(31, 'days').startOf('day').toISOString(true),
                    showSomethingChartToDate: showSomethingChartToDate.value ? moment(showSomethingChartToDate.value).toISOString(true) : moment().startOf('day').toISOString(true),
                }
            }).then((response) => {

                showSomethingChartFromDate.value = response.data.showSomethingChartFromDate;
                showSomethingChartToDate.value = response.data.showSomethingChartToDate;

                xAxis.value = {
                    type: 'datetime',
                    labels: {
                        format: 'dd MMMM yyyy'
                    },
                    categories: response.data.somethingChartDatesWithinRange
                };
                tooltip.value = {
                    x: {
                        format: 'dd MMMM yyyy'
                    },
                };
                series.value = [
                    {
                        name: 'Something',
                        data: response.data.somethingCountDateByDateWithinDateRange.map((item) => {
                            return item.count;
                        })
                    },
                    {
                        name: 'Something Deleted',
                        data: response.data.somethingDeletedCountDateByDateWithinDateRange.map((item) => {
                            return item.count;
                        })
                    }
                ];

                chartIsLoaded.value = true;
            })
        }

        onMounted(() => {
            setSomethingChart();
        });
    //
</script>

<template>
    <!-- Default with Example -->
    <div class="min-h-[500px]">
        <Transition>
            <ApexChartSplineArea v-if="chartIsLoaded" :xAxis="xAxis" :tooltip="tooltip" :series="series" class="mb-[-50px]" />
        </Transition>
    </div>

    <button @click="setSomethingChart">Set Something Chart</button>
</template>

<style>
    .v-enter-active,
    .v-leave-active {
        transition: opacity 3s ease;
    }
    
    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }
</style>