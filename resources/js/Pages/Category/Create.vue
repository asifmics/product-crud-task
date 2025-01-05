<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import 'vue-toast-notification/dist/theme-sugar.css';
import {useToast} from 'vue-toast-notification';

const $toast = useToast();

import {Head, useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const form = useForm({
    category_name: '',
    status: '',
})

const submit = () => {
    form.submit('post', route("categories.store"), {
        onSuccess: () => {
            $toast.success("Category created successfully!");
        },
        onError: () => {
            $toast.error("Failed to created category!");
        }
    })
}
</script>

<template>
    <Head>
        <name>Categories</name>
    </Head>
    <AuthenticatedLayout>

        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-4 px-5 pt-5 max-h-96">
            <div class="col-span-2 border rounded-xl shadow-xl max-h-96">
                <div class="w-full mx-auto">
                    <div class="p-4 sm:p-8 bg-white rounded-xl shadow sm:rounded-lg">
                        <h2 class="p-0 text-secondary text-20 font-medium">Add category</h2>
                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div class="grid grid-cols-3 w-full gap-8">
                                <div
                                    class="col-span-3 grid grid-cols-2 gap-4 p-5 border-gray-100 border rounded-2xl shadow-sm">
                                    <div class="w-full">
                                        <InputLabel for="name" value="Category name" icon="*"/>

                                        <TextInput
                                            id="name"
                                            type="text"
                                            placeholder="ex: Category name here"
                                            class="mt-1 block w-full"
                                            v-model="form.category_name"/>

                                        <InputError class="mt-2" :message="form.errors.category_name"/>

                                    </div>

                                </div>

                            </div>


                            <div class="flex items-center gap-4 justify-end">
                                <PrimaryButton>
                                    <span class="pl-2">save Post</span>
                                </PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                </Transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
