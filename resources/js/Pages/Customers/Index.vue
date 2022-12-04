<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({ customers: Object });

const search = ref("");

const searchCustomers = () => {
    Inertia.get(route("customers.index", { search: search.value }));
};
</script>

<template>
    <Head title="顧客一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                顧客一覧
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
                                <Link
                                    as="button"
                                    :href="route('customers.create')"
                                    class="flex px-6 py-2 ml-auto text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600"
                                    >顧客登録</Link
                                >
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
                                                顧客名
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                顧客名フリガナ
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                電話番号
                                            </th>
                                            <th
                                                class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                            >
                                                登録日
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="customer in customers.data"
                                            :key="customer.id"
                                            class="border-b-2 border-gray-200"
                                        >
                                            <td class="px-4 py-3">
                                                <Link
                                                    class="p-2 text-blue-400 rounded hover:text-red-600 hover:bg-blue-100"
                                                    :href="
                                                        route(
                                                            'customers.show',
                                                            {
                                                                customer:
                                                                    customer.id,
                                                            }
                                                        )
                                                    "
                                                >
                                                    {{ customer.id }}
                                                </Link>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ customer.name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ customer.kana }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-lg text-gray-900"
                                            >
                                                {{ customer.tel }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-lg text-gray-900"
                                            >
                                                {{ customer.created_at }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-center">
                                <Pagination
                                    class="mt-6"
                                    :links="customers.links"
                                ></Pagination>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
