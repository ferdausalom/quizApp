<template>
    <div class="max-w-6xl mx-auto p-6">
        <div class="mb-6 flex justify-between">
            <div>
                Welcome! <span class="font-bold">{{ store.userName }}</span>
            </div>
            <div>
                <button
                    @click="logout"
                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                >
                    Logout
                </button>
            </div>
        </div>
        <div
            class="text-center mb-6 bg-white border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
            role="alert"
        >
            <div class="max-w-6xl mx-auto">
                <p
                    class="pt-2 font-semibold text-center text-green-600 text-xl"
                >
                    Here is your result.
                </p>
                <p class="py-2 text-center text-lg">
                    You got
                    <span class="font-semibold text-red-600">{{
                        store.result
                    }}</span>
                    out of
                    <span class="font-semibold text-red-600">{{
                        store.total
                    }}</span>
                    mark.
                </p>

                <p
                    class="font-bold text-red-600 text-xl"
                    v-if="emailSent !== null"
                >
                    {{ emailSent }}
                </p>

                <p
                    v-if="store.result > 0"
                    class="flex justify-center py-4 space-x-8"
                >
                    <button
                        @click="sendEmail(store.result)"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                    >
                        Email Me
                    </button>
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
import axios from "axios";
import { ref } from "vue";
import { useResultStore } from "@/stores/ResultStore";
import { useRouter } from "vue-router";
const router = useRouter();
const store = useResultStore();
let emailSent = ref(null);

function sendEmail(result) {
    // Make the request to the Laravel API endpoint
    axios
        .post("http://127.0.0.1:8000/api/send-email", {
            email: JSON.parse(localStorage.getItem("email")),
            result: result,
        })
        .then((response) => {
            emailSent.value = response.data.message;
        })
        .catch((error) => {});
}

function logout() {
    localStorage.removeItem("name");
    localStorage.removeItem("email");
    router.push("/login");
}
</script>
