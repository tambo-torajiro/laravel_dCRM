<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, onMounted } from "vue";
import { getToday } from "@/common";
import axios, { Axios } from "axios";
import dayjs from "dayjs";
import Chart from "@/Components/Chart.vue";

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
                            <label for="startDate">From:</label>
                            <input
                                type="date"
                                name="startDate"
                                v-model="form.startDate"
                                class="ml-4 mr-4 bg-gray-100 rounded"
                            />
                            <label for="endDate">To:</label>
                            <input
                                type="date"
                                name="endDate"
                                v-model="form.endDate"
                                class="ml-4 mr-4 bg-gray-100 rounded"
                            />
                            <button
                                class="px-2 py-2 ml-4 text-white bg-blue-300 rounded hover:bg-blue-400"
                            >
                                GO
                            </button>
                        </form>
                        <div v-show="data.data" class="mt-8">
                            <Chart :data="data" />
                        </div>

                        <div
                            v-show="data.data"
                            class="w-full mx-auto mt-16 overflow-auto lg:w-2/3"
                        >
                            <table
                                class="w-full text-left whitespace-no-wrap table-auto"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tl rounded-bl title-font"
                                        >
                                            年月日
                                        </th>
                                        <th
                                            class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                        >
                                            金額
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in data.data"
                                        :key="item.date"
                                        class="border-b-2 border-gray-200"
                                    >
                                        <td class="px-4 py-3">
                                            {{
                                                dayjs(item.date).format(
                                                    "YYYY-MM-DD"
                                                )
                                            }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ item.total }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
