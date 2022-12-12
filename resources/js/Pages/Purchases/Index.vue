<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { onMounted, ref } from "vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";
import dayjs from "dayjs";

const props = defineProps({
    orders: Object,
});
onMounted(() => {
    console.log(props.orders.data);
});
</script>

<template>
    <Head title="購入履歴" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                購入履歴
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <FlashMessage />
                            <div class="flex w-full pl-4 mx-auto my-4 lg:w-2/3">
                                <div>
                                    <input
                                        type="text"
                                        name="search"
                                        v-model="search"
                                        class="rounded focus:outline-none"
                                    />
                                    <button
                                        class="px-2 py-2 ml-4 text-white bg-blue-300 rounded hover:bg-blue-400"
                                        @click="searchCustomers"
                                    >
                                        検索
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex flex-wrap justify-between w-full pl-4 mx-auto my-4 lg:w-2/3"
                            >
                                <div>
                                    全<span class="px-2 font-bold">{{
                                        props.orders.total
                                    }}</span
                                    >件のデータ
                                </div>
                                <div>
                                    <span class="px-2 font-bold">{{
                                        props.orders.last_page
                                    }}</span
                                    >ページ中<span class="px-2 font-bold">{{
                                        props.orders.current_page
                                    }}</span
                                    >ページ目を表示中
                                </div>
                            </div>
                            <div class="w-full mx-auto overflow-auto lg:w-2/3">
                                <table
                                    class="w-full text-left whitespace-no-wrap table-auto"
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tl rounded-bl title-font"
                                            >
                                                ID
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                氏名
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                合計金額
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                ステータス
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                購入日
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="order in props.orders.data"
                                            :key="order.id"
                                            class="border-b-2 border-gray-200"
                                        >
                                            <td class="px-4 py-3">
                                                <Link
                                                    class="p-2 text-blue-400 rounded hover:text-red-600 hover:bg-blue-100"
                                                    :href="
                                                        route(
                                                            'purchases.show',
                                                            {
                                                                purchase:
                                                                    order.id,
                                                            }
                                                        )
                                                    "
                                                >
                                                    {{ order.id }}
                                                </Link>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ order.customer_name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ order.total }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-lg text-gray-900"
                                            >
                                                {{ order.status }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-lg text-gray-900"
                                            >
                                                {{
                                                    dayjs(
                                                        order.created_at
                                                    ).format(
                                                        "YYYY-MM-DD HH:mm:ss"
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-center">
                                <Pagination
                                    class="mt-6"
                                    :links="props.orders.links"
                                ></Pagination>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
