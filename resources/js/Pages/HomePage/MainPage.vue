<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import PageHeader from "@/Components/PageHeader.vue";
import ApexCharts from "apexcharts";
import { Head } from "@inertiajs/inertia-vue3";
import { ref, onMounted, defineProps } from "vue";

const props = defineProps({
    receivedTransfer: Number,
    pendingToReceive: Number,
    transferedAsset: Number,
    pendingTransfer: Number,
    locationName: Array,
    locationID: Array,
});

const locationName = ref(props.locationName);
const locationID = ref(props.locationID);

const status = ref([
    {
        count: props.receivedTransfer,
        label: "RECEIVED TRANSFER",
        class: "bg-teal-400 border border-gray-200",
    },
    {
        count: props.pendingToReceive,
        label: "PENDING TO RECEIVE",
        class: "bg-blue-400 border border-gray-200",
    },
    {
        count: props.transferedAsset,
        label: "TRANSFERED ASSET",
        class: "bg-violet-400 border border-gray-200",
    },
    {
        count: props.pendingTransfer,
        label: "PENDING TRANSFER",
        class: "bg-red-400 border border-gray-200",
    },
]);

var lineChartOptions = {
    chart: {
        type: "line",
    },
    series: [
        {
            name: "Transfer",
            data: [30, 40, 35],
        },

        {
            name: "Received",
            data: [10, 20, 35],
        },

        {
            name: "Disposal",
            data: [120, 220, 15],
        },
    ],
    xaxis: {
        categories: [2020, 2021, 2022],
    },
};

var barChartOptions = {
    series: [
        {
            data: locationID.value,
        },
    ],
    chart: {
        type: "bar",
        height: "100%",
    },
    plotOptions: {
        bar: {
            borderRadius: 4,
            borderRadiusApplication: "end",
            horizontal: true,
        },
    },
    dataLabels: {
        enabled: true,
    },
    xaxis: {
        categories: locationName.value,
    },
};

var donutChartOptions = {
    series: [44, 55, 41, 17, 15],
    labels: locationName.value,
    chart: {
        type: "donut",
        height: "100%",
    },
    legend: {
        position: "bottom",
    },
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
                },
                legend: {
                    position: "bottom",
                },
            },
        },
    ],
};

onMounted(() => {
    const LineChart = new ApexCharts(
        document.querySelector("#line-chart"),
        lineChartOptions
    );
    LineChart.render();
    const BarChart = new ApexCharts(
        document.querySelector("#bar-chart"),
        barChartOptions
    );
    BarChart.render();
    const DonutChart = new ApexCharts(
        document.querySelector("#donut-chart"),
        donutChartOptions
    );
    DonutChart.render();
});
</script>

<template>
    <Head title="Home" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Home" />
        </template>

        <div class="py-12">
            <!-- <div class="max-w-full mx-[8rem] sm:px-6 lg:px-8"> -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <div
                                v-for="state in status"
                                :key="state.index"
                                :class="state.class"
                                class="max-w-sm p-6 rounded-lg shadow"
                            >
                                <h5
                                    class="mb-2 text-2xl font-semibold tracking-tight text-white"
                                >
                                    {{ state.count }}
                                </h5>
                                <p class="mb-3 text-gray-600 font-bold">
                                    {{ state.label }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <div
                                class="col-span-3 h-100 p-6 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700"
                            >
                                <div id="line-chart"></div>
                            </div>

                            <div class="col-span-1">
                                <div class="flex flex-col gap-4 h-full">
                                    <div
                                        class="h-1/2 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700"
                                    >
                                        <div id="bar-chart"></div>
                                    </div>

                                    <div
                                        class="h-1/2 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700"
                                    >
                                        <div id="donut-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
