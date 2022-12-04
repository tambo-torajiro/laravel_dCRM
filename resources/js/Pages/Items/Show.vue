<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { nl2br } from "@/common";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    item: Object,
});

const deleteItem = (id) => {
    Inertia.delete(route("items.destroy", { item: id }), {
        onBefore: () => confirm("本当に削除しますか？"),
    });
};
</script>

<template>
    <Head title="商品詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                商品詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="relative text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="mx-auto lg:w-1/2 md:w-2/3">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="w-full p-2">
                                            <div class="relative">
                                                <label
                                                    for="name"
                                                    class="text-sm leading-7 text-gray-600"
                                                    >商品名</label
                                                >
                                                <div
                                                    id="name"
                                                    class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
                                                >
                                                    {{ item.name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full p-2">
                                            <div class="relative">
                                                <label
                                                    for="memo"
                                                    class="text-sm leading-7 text-gray-600"
                                                    >メモ</label
                                                >
                                                <div
                                                    id="memo"
                                                    v-html="nl2br(item.memo)"
                                                    class="w-full h-32 px-3 py-1 text-base leading-6 text-gray-700 transition-colors duration-200 ease-in-out bg-opacity-50 border border-gray-300 rounded outline-none resize-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
                                                ></div>
                                            </div>
                                        </div>

                                        <div class="w-full p-2">
                                            <div class="relative">
                                                <label
                                                    for="price"
                                                    class="text-sm leading-7 text-gray-600"
                                                    >価格</label
                                                >
                                                <div
                                                    id="price"
                                                    class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
                                                >
                                                    {{ item.price }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-full p-2">
                                            <div class="relative">
                                                <label
                                                    for="status"
                                                    class="text-sm leading-7 text-gray-600"
                                                    >ステータス</label
                                                >
                                                <div
                                                    id="status"
                                                    class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
                                                >
                                                    <span
                                                        v-if="
                                                            item.is_selling ===
                                                            1
                                                        "
                                                        >販売中</span
                                                    >
                                                    <span
                                                        v-if="
                                                            item.is_selling ===
                                                            0
                                                        "
                                                        >停止中</span
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="flex flex-wrap justify-around w-full p-2"
                                        >
                                            <Link
                                                as="button"
                                                :href="route('items.index')"
                                                class="flex px-6 py-2 mx-auto text-lg text-white bg-gray-400 border-0 rounded focus:outline-none hover:bg-gray-600"
                                                >一覧へ戻る
                                            </Link>
                                            <Link
                                                as="button"
                                                :href="
                                                    route('items.edit', {
                                                        item: item.id,
                                                    })
                                                "
                                                class="flex px-8 py-2 mx-auto text-lg text-white bg-indigo-500 border-0 rounded focus:outline-none hover:bg-indigo-600"
                                            >
                                                編集する
                                            </Link>

                                            <button
                                                @click="deleteItem(item.id)"
                                                class="flex px-8 py-2 mx-auto text-lg text-white bg-red-500 border-0 rounded focus:outline-none hover:bg-red-600"
                                            >
                                                削除する
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
