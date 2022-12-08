<script setup>
import axios from "axios";
import { ref, reactive, onMounted } from "vue";

const search = ref("");
const customers = reactive({});
// onMounted(() => {
//   axios.get('/api/user')
//   .then( res => {
//     console.log(res.data)
//   })
// })
const isShow = ref(false);
const toggleStatus = () => {
    isShow.value = !isShow.value;
};
const searchCustomers = async () => {
    try {
        await axios
            .get(`/api/searchCustomers/?search=${search.value}`)
            .then((res) => {
                console.log(res.data);
                customers.value = res.data;
            });
        toggleStatus();
    } catch (e) {
        console.log(e);
    }
};
const emit = defineEmits(["update:customerId"]);
const setCustomer = (e) => {
    search.value = e.kana;
    emit("update:customerId", e.id);
    toggleStatus();
};
</script>
<template>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div
                class="w-2/3 modal__container"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-1-title"
            >
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">顧客検索</h2>
                    <button
                        @click="toggleStatus"
                        type="button"
                        class="modal__close"
                        aria-label="Close modal"
                        data-micromodal-close
                    ></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <div
                        v-if="customers.value"
                        class="w-full mx-auto overflow-auto lg:w-2/3"
                    >
                        <table
                            class="w-full text-left whitespace-no-wrap table-auto"
                        >
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 rounded-tl rounded-bl title-font"
                                    >
                                        Id
                                    </th>
                                    <th
                                        class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                    >
                                        氏名
                                    </th>
                                    <th
                                        class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                    >
                                        カナ
                                    </th>
                                    <th
                                        class="px-4 py-3 text-sm font-medium tracking-wider text-gray-900 bg-gray-100 title-font"
                                    >
                                        電話番号
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="customer in customers.value.data"
                                    :key="customer.id"
                                >
                                    <td
                                        class="px-4 py-3 border-b-2 border-gray-200"
                                    >
                                        <button
                                            @click="
                                                setCustomer({
                                                    id: customer.id,
                                                    kana: customer.kana,
                                                })
                                            "
                                            type="button"
                                            class="p-2 text-blue-400 rounded hover:text-orange-500 hover:bg-gray-100"
                                        >
                                            {{ customer.id }}
                                        </button>
                                    </td>
                                    <td
                                        class="px-4 py-3 border-b-2 border-gray-200"
                                    >
                                        {{ customer.name }}
                                    </td>
                                    <td
                                        class="px-4 py-3 border-b-2 border-gray-200"
                                    >
                                        {{ customer.kana }}
                                    </td>
                                    <td
                                        class="px-4 py-3 border-b-2 border-gray-200"
                                    >
                                        {{ customer.tel }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </main>
                <footer class="modal__footer">
                    <button
                        @click="toggleStatus"
                        type="button"
                        class="modal__btn"
                        data-micromodal-close
                        aria-label="Close this dialog window"
                    >
                        閉じる
                    </button>
                </footer>
            </div>
        </div>
    </div>
    <div class="flex">
        <input
            name="customer"
            v-model="search"
            class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200"
        />
        <button
            @click="searchCustomers"
            type="button"
            data-micromodal-trigger="modal-1"
            class="px-4 ml-2 leading-8 text-white bg-teal-500 border-0 rounded focus:outline-none hover:bg-teal-600"
        >
            GO
        </button>
    </div>
</template>
