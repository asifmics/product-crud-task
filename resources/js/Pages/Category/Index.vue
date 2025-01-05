<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import NoDataFound from "@/Components/NoDataFound.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faEdit, faPlus, faTrashCan} from "@fortawesome/free-solid-svg-icons";
import InputLabel from "@/Components/InputLabel.vue";


const $toast = useToast();

const props = defineProps({
    categories: Object,
    active: String,
    inactive: String,
    categoryStatus: Object,
})

const form = useForm({});

const shouldDelete = ref(false);

const categoryID = ref(null);

const selectForDeletion = (id) => {
    shouldDelete.value = true;
    categoryID.value = id;
}

const closeModal = () => {
    shouldDelete.value = false;
};

const deletePost = () => {
    form.delete(route('categories.destroy', categoryID.value), {
        preserveScroll: true,
        onSuccess: () => {
            $toast.success("Category deleted successfully!");
            closeModal();
            categoryID.value = 0;
        },
        onError: () => {
            $toast.error("Failed to deleted category!");
        },
    });
};

const formFilter = useForm({
    status: 'all',
    featured: 'all'
});

const filterHandle = () => {
    let tempUrl = new URL(window.location.href);
    let url = `${route('categories.index')}?status=${formFilter.status}`;

    setTimeout(() => {
        form.get(url, {
            preserveState: true,
            onError: () => {
                $toast.error("Failed to retrieve data!");
            },
        });
    });
}

</script>

<template>
    <Head>
        <title>Tasks</title>
    </Head>

    <AuthenticatedLayout>

        <div class="px-5 bg-white pt-5 h-screen">
            <div class="col-span-2 lg:col-span-2 flex flex-col gap-3 card-shadow mb-5">
                <div class="flex flex-row justify-end pb-6">

                    <Link :href="route('categories.create')"
                          class="text-white px-3 py-2 bg-sky-500 rounded hover:opacity-90 capitalize font-medium text-sm focus:outline-none flex space-x-2 items-center">
                        <font-awesome-icon :icon="faPlus"/>
                        <span> Add category</span>
                    </Link>
                </div>
                <div v-if="props.categories.length >0" class="flex flex-row justify-end gap-4">
                    <div>
                        <form>
                            <InputLabel class="text-left text-black">Filter by status</InputLabel>
                            <select @change="filterHandle" v-model="formFilter.status"
                                    class="bg-gray-100 border-0 focus:ring-gray-100 rounded-none capitalize text-14 text-black font-semibold">
                                <option value="all">All</option>
                                <option v-for="(status ,key) in props.categoryStatus" :key="key" :value="status">
                                    {{ status }}
                                </option>
                            </select>
                        </form>
                    </div>

                </div>
                <div class="flex flex-row">
                    <div v-if="props.categories.length" class="w-full">
                        <table class="w-full text-center">
                            <thead class="text-color">
                            <tr>
                                <th class="py-3 rounded-tl-2xl font-barlow w-20">#</th>
                                <th class="py-3 text-16 font-barlow font-semibold text-left">Title</th>
                                <th class="py-3 text-16 font-barlow font-semibold text-center">Description</th>
                                <th class="py-3 text-16 font-barlow font-semibold">Status</th>
                                <th class="py-3 text-16 font-barlow font-semibold">Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr v-for="(category ,key) in props.categories" :key="key"
                                class="border-b border-t border-gray-200 dark:border-gray-500 text-color group">
                                <td class="py-3 text-14 font-ibmPlex">
                                    {{ (key + 1) }}
                                </td>

                                <td class="text-left">
                                    <span> {{ category.category_name ?? '' }}</span>
                                </td>

                                <td class="py-3 text-14 font-ibmPlex">
                                    <span v-if="category.status"
                                             :class="category.status === 'active' ?'text-lime-600' : 'text-red-600'" class="px-3 py-1 rounded-[15px] text-12 text-black font-semibold capitalize">{{
                                                category.status
                                            }}</span>
                                </td>

                                <td>
                                    <div class="flex flex-row gap-2 justify-center">
                                        <Link :href="route('categories.edit',category.id)" type="button"
                                              class="self-center">
                                            <font-awesome-icon :icon="faEdit"
                                                               class="text-indigo-600 hover:text-orange pr-2"/>
                                        </Link>
                                        <button @click="selectForDeletion(category.id)" type="button"
                                                class="self-center">
                                            <font-awesome-icon :icon="faTrashCan"
                                                               class="text-red-400 hover:text-red-600"/>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <NoDataFound v-else/>
                </div>

                <div class="flex flex-col">

                </div>
            </div>
        </div>

        <Modal :show="shouldDelete" @close="closeModal">
            <div class="p-6 text-center">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this category?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your category is deleted, all of its resources and data will be permanently deleted.
                </p>


                <div class="mt-6 flex justify-center">
                    <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        @click="deletePost"
                    >
                        Delete Post
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
