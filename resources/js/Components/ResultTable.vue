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
</template>
