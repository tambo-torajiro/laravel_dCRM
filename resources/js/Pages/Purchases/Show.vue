<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { onMounted, reactive, ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import VallidationErrors from "@/Components/VallidationErrors.vue";
import dayjs from "dayjs";

const props = defineProps({
    items: Array,
    order: Array,
});

onMounted(() => {
    console.log(props.items);
    console.log(props.order);
});
</script>

<template>
    <Head title="購入履歴 詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                購入履歴 詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <VallidationErrors class="mb-4" />
                        <section class="relative text-gray-600 body-font">
                            <form @submit.prevent="storePurchase">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="mx-auto lg:w-1/2 md:w-2/3">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="w-full p-2">
                                                <div class="relative">
                                                    <label
                                                        for="date"
                                                        class="text-sm leading-7 text-gray-600"
                                                        >購入日</label
                                                    >
                                                    <div
                                                        id="date"
                                                        class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
                                                    >
                                                        {{
                                                            dayjs(
                                                                props.order[0]
                                                                    .created_at
                                                            ).format(
                                                                "YYYY-MM-DD HH:mm:ss"
                                                            )
                                                        }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="w-full p-2">
                                                <div class="relative">
                                                    <label
                                                        for="customer_name"
                                                        class="text-sm leading-7 text-gray-600"
                                                        >会員名</label
                                                    >
                                                    <div
                                                        id="customer_name"
                                                        class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
                                                    >
                                                        {{
                                                            props.order[0]
                                                                .customer_name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="w-full mx-auto mt-8 overflow-auto"
                                            >
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
                                                                商品名
                                                            </th>
                                                            <th
                                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                                            >
                                                                金額
                                                            </th>
                                                            <th
                                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                                            >
                                                                数量
                                                            </th>
                                                            <th
                                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                                            >
                                                                小計
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="item in props.items"
                                                            :key="item.id"
                                                        >
                                                            <td
                                                                class="px-4 py-3 border-b-2 border-gray-200"
                                                            >
                                                                {{
                                                                    item.item_id
                                                                }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-3 border-b-2 border-gray-200"
                                                            >
                                                                {{
                                                                    item.item_name
                                                                }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-3 border-b-2 border-gray-200"
                                                            >
                                                                {{
                                                                    item.item_price
                                                                }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-3 border-b-2 border-gray-200"
                                                            >
                                                                {{
                                                                    item.quantity
                                                                }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-3 border-b-2 border-gray-200"
                                                            >
                                                                {{
                                                                    item.subtotal
                                                                }}円
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="mt-4">
                                                    <label
                                                        for="total"
                                                        class="text-sm font-semibold leading-7 text-gray-600"
                                                        >合計金額</label
                                                    >
                                                    <div
                                                        class="w-full px-3 py-1 text-base leading-8 text-gray-700 bg-gray-100 border border-gray-300 rounded outline-none"
                                                    >
                                                        {{
                                                            props.order[0]
                                                                .total
                                                        }}円
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <label
                                                        for="status"
                                                        class="text-sm font-semibold leading-7 text-gray-600"
                                                        >ステータス</label
                                                    >
                                                    <div
                                                        v-if="
                                                            props.order[0]
                                                                .status == true
                                                        "
                                                        class="w-full px-3 py-1 text-base leading-8 text-gray-700 bg-gray-100 border border-gray-300 rounded outline-none"
                                                    >
                                                        未キャンセル
                                                    </div>
                                                    <div
                                                        v-if="
                                                            props.order[0]
                                                                .status == false
                                                        "
                                                        class="w-full px-3 py-1 text-base leading-8 text-purple-700 bg-pink-100 border border-gray-300 rounded outline-none"
                                                    >
                                                        キャンセル済
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <label
                                                        for="cancel_date"
                                                        class="text-sm font-semibold leading-7 text-gray-600"
                                                        >キャンセル日</label
                                                    >
                                                    <div
                                                        v-if="
                                                            props.order[0]
                                                                .status == false
                                                        "
                                                        class="w-full px-3 py-1 text-base leading-8 text-gray-700 bg-gray-100 border border-gray-300 rounded outline-none"
                                                    >
                                                        {{
                                                            dayjs(
                                                                props.order[0]
                                                                    .updated_at
                                                            ).format(
                                                                "YYYY-MM-DD HH:mm:ss"
                                                            )
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex w-full p-2 mt-2">
                                                <Link
                                                    as="button"
                                                    :href="
                                                        route('purchases.index')
                                                    "
                                                    class="flex px-6 py-2 mx-auto text-lg text-white bg-gray-400 border-0 rounded focus:outline-none hover:bg-gray-600"
                                                    >一覧へ戻る
                                                </Link>

                                                <Link
                                                    as="button"
                                                    v-if="
                                                        props.order[0].status ==
                                                        true
                                                    "
                                                    :href="
                                                        route(
                                                            'purchases.edit',
                                                            {
                                                                purchase:
                                                                    props
                                                                        .order[0]
                                                                        .id,
                                                            }
                                                        )
                                                    "
                                                    class="flex px-6 py-2 mx-auto text-lg text-white bg-indigo-400 border-0 rounded focus:outline-none hover:bg-indigo-600"
                                                    >編集する
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
