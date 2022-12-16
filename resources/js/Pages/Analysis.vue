<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, onMounted } from "vue";
import { getToday } from "@/common";
import axios, { Axios } from "axios";
import Chart from "@/Components/Chart.vue";
import ResultTable from "@/Components/ResultTable.vue";

onMounted(() => {
    form.startDate = getToday();
    form.endDate = getToday();
});

const form = reactive({
    startDate: null,
    endDate: null,
    type: "perDay",
});

const data = reactive({});

const getDate = async () => {
    try {
        await axios
            .get("/api/analysis/", {
                params: {
                    startDate: form.startDate,
                    endDate: form.endDate,
                    type: form.type,
                },
            })
            .then((res) => {
                data.data = res.data.data;
                data.labels = res.data.labels;
                data.totals = res.data.totals;
                data.type = res.data.type
                console.log(res.data);
            });
    } catch (e) {
        console.log(e.message);
    }
};
</script>

<template>

    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                データ分析
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getDate">
                            <h2
                                class="inline-block px-2 py-1 mb-8 font-medium tracking-widest text-white bg-orange-400 rounded first-line:text-3xl title-font">
                                分析方法
                            </h2>
                            <div class="px-8 mb-8">
                                <input type="radio" id="perDay" name="perDay" v-model="form.type" value="perDay"
                                    class="mr-2" checked />
                                <label for="perDay" class="mr-8">日別</label>
                                <input type="radio" id="perMonth" name="perMonth" v-model="form.type" class="mr-2"
                                    value="perMonth" />
                                <label for="perMonth" class="mr-8">月別</label>
                                <input type="radio" id="perYear" name="perYear" v-model="form.type" class="mr-2"
                                    value="perYear" />
                                <label for="perYear" class="mr-8">年別</label>
                                <input type="radio" id="decile" name="decile" v-model="form.type" class="mr-2"
                                    value="decile" />
                                <label for="decile" class="mr-8">デシル分析</label>
                            </div>

                            <label for="startDate">From:</label>
                            <input type="date" name="startDate" v-model="form.startDate"
                                class="ml-4 mr-4 bg-gray-100 rounded" />
                            <label for="endDate">To:</label>
                            <input type="date" name="endDate" v-model="form.endDate"
                                class="ml-4 mr-4 bg-gray-100 rounded" />
                            <button class="px-2 py-2 ml-4 text-white bg-blue-300 rounded hover:bg-blue-400">
                                GO
                            </button>
                        </form>
                        <div v-show="data.data" class="mt-8">
                            <Chart :data="data" />
                            <ResultTable :data="data" />
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
