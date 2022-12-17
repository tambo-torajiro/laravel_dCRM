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
    rfmPrms: [
        14, 28, 60, 90, 7, 5, 3, 2, 300000, 200000, 100000, 30000
    ]
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
                    rfmPrms: form.rfmPrms
                },
            })
            .then((res) => {
                data.data = res.data.data;
                if (res.data.labels) { data.labels = res.data.labels };
                if (res.data.eachCount) { data.eachCount = res.data.eachCount };
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
                            <h1
                                class="inline-block px-2 py-1 mb-8 font-medium tracking-widest text-blue-500 border-b first-line:text-3xl title-font border-b-slate-600">
                                分析方法
                            </h1>
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
                                <input type="radio" id="rfm" name="rfm" v-model="form.type" class="mr-2" value="rfm" />
                                <label for="rfm" class="mr-8">RFM分析</label>
                            </div>
                            <div class="flex">
                                <div>
                                    <label for="startDate">From:</label>
                                    <input type="date" name="startDate" v-model="form.startDate"
                                        class="ml-4 mr-4 bg-gray-100 rounded" />
                                    <label for="endDate">To:</label>
                                    <input type="date" name="endDate" v-model="form.endDate"
                                        class="ml-4 mr-4 bg-gray-100 rounded" />
                                </div>
                                <div>
                                    <button
                                        class="px-2 py-2 ml-4 text-white bg-indigo-400 rounded shadow-md hover:bg-indigo-500 shadow-gray-300 hover:shadow-md hover:shadow-gray-500">
                                        GO
                                    </button>
                                </div>
                            </div>

                            <div v-if="form.type === 'rfm'" class="px-8 py-4 my-8">
                                <table class="mx-auto border-white">
                                    <thead>
                                        <tr>
                                            <th class="p-2 text-gray-500 bg-pink-200 border border-white">ランク</th>
                                            <th class="p-2 text-gray-500 bg-pink-200 border border-white">R (〇日以内)</th>
                                            <th class="p-2 text-gray-500 bg-pink-200 border border-white">F (〇回以上)</th>
                                            <th class="p-2 text-gray-500 bg-pink-200 border border-white">M (〇円以上)</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="p-2 text-center text-gray-500 bg-pink-200 border border-white">5
                                            </td>
                                            <td><input type="number" v-model="form.rfmPrms[0]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[4]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[8]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 text-center text-gray-500 bg-pink-200 border border-white">4
                                            </td>
                                            <td><input type="number" v-model="form.rfmPrms[1]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[5]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[9]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 text-center text-gray-500 bg-pink-200 border border-white">3
                                            </td>
                                            <td><input type="number" v-model="form.rfmPrms[2]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[6]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[10]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 text-center text-gray-500 bg-pink-200 border border-white">2
                                            </td>
                                            <td><input type="number" v-model="form.rfmPrms[3]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[7]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[11]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 text-center text-gray-500 bg-pink-200 border border-white">1
                                            </td>
                                            <td><input type="number" v-model="form.rfmPrms[3]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[7]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                            <td><input type="number" v-model="form.rfmPrms[11]"
                                                    class="text-gray-500 border-gray-200" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div v-show="data.data" class="mt-8">
                            <div v-if="data.type != 'rfm'">
                                <Chart :data="data" />
                            </div>
                            <div>
                                <ResultTable :data="data" />
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
