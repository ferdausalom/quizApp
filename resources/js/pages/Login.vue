<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900"
    >
        <div>
            <p class="text-red-600">
                {{ validationError }}
            </p>
        </div>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <!-- Session Status -->

            <form>
                <input
                    type="hidden"
                    name="_token"
                    value="hjvKyJ9yexcjTSFbwysSx6UFlHPPwrbbhuOTvqYJ"
                />
                <!-- Email Address -->
                <div>
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
                        autofocus="autofocus"
                        autocomplete="email"
                        v-model="loginForm.email"
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
                        v-model="loginForm.password"
                    />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <RouterLink
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        to="/register"
                        >Register</RouterLink
                    >

                    <button
                        @click.prevent="loginUser"
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ml-3"
                    >
                        Log in
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

let validationError = ref(null);

let loginForm = {
    email: "",
    password: "",
};

function loginUser() {
    const email = loginForm.email;
    const password = loginForm.password;

    axios
        .post("http://127.0.0.1:8000/api/log-in", { email, password })
        .then((res) => {
            localStorage.setItem("name", JSON.stringify(res.data.user.name));
            localStorage.setItem("email", JSON.stringify(res.data.user.email));
            router.push("/");
        })
        .catch((error) => {
            if (error.response) {
                validationError.value = error.response.data.error;
            }
        })
        .finally(() => {});
}
</script>
