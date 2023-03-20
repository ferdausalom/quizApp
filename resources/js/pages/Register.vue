<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900"
    >
        <div v-if="Object.keys(validationErrors).length > 0">
            <ul>
                <li
                    class="text-red-600"
                    v-for="(error, index) in validationErrors"
                    :key="index"
                >
                    {{ error[0] }}
                </li>
            </ul>
        </div>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <form>
                <!-- Name -->
                <div>
                    <label
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="name"
                    >
                        Name
                    </label>
                    <input
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        id="name"
                        type="text"
                        name="name"
                        required="required"
                        autofocus="autofocus"
                        autocomplete="name"
                        v-model="registerForm.name"
                    />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="email"
                    >
                        Email
                    </label>
                    <input
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        id="email"
                        type="email"
                        name="email"
                        required="required"
                        autocomplete="email"
                        v-model="registerForm.email"
                    />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="password"
                    >
                        Password
                    </label>

                    <input
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        id="password"
                        type="password"
                        name="password"
                        required="required"
                        v-model="registerForm.password"
                    />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <RouterLink
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        to="/login"
                        >Login</RouterLink
                    >
                    <button
                        @click.prevent="registerUser"
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ml-4"
                    >
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

let validationErrors = ref({});

let registerForm = {
    name: "",
    email: "",
    password: "",
};

function registerUser() {
    const getHeaders = {
        Accept: "application/json",
    };
    let body = new FormData();
    body.append("name", registerForm.name);
    body.append("email", registerForm.email);
    body.append("password", registerForm.password);
    body.append("_method", "POST");
    // axios
    axios
        .post("http://127.0.0.1:8000/api/sign-up", body, {
            method: "POST",
            getHeaders,
        })
        .then((res) => {
            router.push("/login");
        })
        .catch((error) => {
            if (error.response.status === 422) {
                validationErrors.value = error.response.data;
            }
        })
        .finally(() => {});
}
</script>
