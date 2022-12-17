<script setup>
import dayjs from "dayjs";


const props = defineProps({
    data: Object
})
</script>
<template>
    <div v-if="data.type === 'perDay' || data.type === 'perMonth' || data.type === 'perYear'"
        class="w-full mx-auto mt-16 overflow-auto lg:w-2/3">
        <table class="w-full text-left whitespace-no-wrap table-auto">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tl rounded-bl title-font">
                        年月日
                    </th>
                    <th class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font">
                        金額
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" :key="item.date" class="border-b-2 border-gray-200">
                    <td class="px-4 py-3">
                        {{
                                dayjs(item.date).format(
                                    "YYYY-MM-DD"
                                )
                        }}
                    </td>
                    <td class="px-4 py-3">
                        ￥ {{ Number(item.total).toLocaleString() }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="data.type === 'decile'" class="w-full mx-auto mt-16 overflow-auto lg:w-2/3">
        <table class="w-full text-left whitespace-no-wrap table-auto">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tl rounded-bl title-font">
                        グループ
                    </th>
                    <th class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font">
                        平均額
                    </th>
                    <th class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font">
                        合計金額
                    </th>
                    <th class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font">
                        構成比(%)
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" :key="item.date" class="border-b-2 border-gray-200">
                    <td class="px-4 py-3">
                        {{ item.decile }}
                    </td>
                    <td class="px-4 py-3">
                        ￥{{ Number(item.average).toLocaleString() }}
                    </td>
                    <td class="px-4 py-3">
                        ￥{{ Number(item.totalPerGroup).toLocaleString() }}
                    </td>
                    <td class="px-4 py-3">
                        {{ item.totalRatio }} %
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2
        class="inline-block mb-8 text-2xl font-medium tracking-widest text-center text-blue-400 border-b border-slate-400 first-line:text-2xl title-font">
        RFM分析</h2>
    <div v-if="data.type === 'rfm'" class="flex justify-around w-full mx-auto">

        <div>
            <h3
                class="inline-block px-2 py-1 mb-8 font-medium tracking-widest text-blue-500 border-b first-line:text-xl border-b-slate-400">
                合計人数</h3>
            <div class="mb-4 text-center">
                <span class="text-xl">合計：{{ data.totals }}</span> 人
            </div>

            <h3
                class="inline-block px-2 py-1 mb-8 font-medium tracking-widest text-blue-400 border-b first-line:text-xl border-b-slate-400">
                RFMランク毎の人数</h3>


            <table class="mx-auto border-collapse table-auto border-slate-300">
                <thead>
                    <tr>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white">Rank</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white">R</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white">F</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white">M</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="rfm in data.eachCount" :key="rfm.rank">
                        <td class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white">{{ rfm.rank }}
                        </td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rfm.r }}</td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rfm.f }}</td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rfm.m }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h3
                class="inline-block px-2 py-1 font-medium tracking-widest text-blue-400 border-b first-line:text-xl border-b-slate-400">
                R・Fの集計表</h3>
            <div class="mt-8 mb-10">
                <p>r: Recency 最新購入日</p>
                <p>f: Frequency 購入回数</p>
                <p>m: Monetary 購入金額合計</p>
            </div>
            <table class="mx-auto border border-collapse border-white table-auto">
                <thead>
                    <tr>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white">rRank</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white ">f_5</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white ">f_4</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white ">f_3</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white ">f_2</th>
                        <th class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white ">f_1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="rf in data.data" :key="rf.rRank">
                        <td class="w-16 p-4 text-center text-gray-500 bg-green-300 border border-white ">{{ rf.rRank }}
                        </td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rf.f_5 }}</td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rf.f_4 }}</td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rf.f_3 }}</td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rf.f_2 }}</td>
                        <td class="w-16 p-4 text-center border border-slate-200">{{ rf.f_1 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>
