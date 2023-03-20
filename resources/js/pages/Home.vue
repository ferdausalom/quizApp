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
            <div>
                <p class="font-bold text-xl">
                    Total questions: {{ totalQuestions }}
                </p>
                <p class="font-bold text-xl border-b pb-3 mb-3">
                    Total marks: {{ totalQuestions }}
                </p>
                <p class="text-xl mb-6 text-xl">
                    Please select one answer carefully! And answer all
                    questions.
                </p>
                <p class="mx-auto mb-6">
                    <router-link
                        to="/result"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                    >
                        Show Result
                    </router-link>
                </p>
            </div>
        </div>
        <div>
            <p class="font-bold py-6 text-blue-700 text-xl">Questions:</p>
        </div>
        <AccordionList>
            <AccordionItem v-for="category in categories" :key="category">
                <template #summary>{{ category }}</template>
                <template #icon><Icon icon="clarity:angle-line" /></template>
                <div
                    class="mb-6"
                    v-for="(question, index) in filteredQuestions(category)"
                    :key="question.question"
                >
                    {{ question.question }}

                    <div v-if="question.incorrect_answers.length > 1">
                        <p
                            v-for="(
                                incorrect_answer, i
                            ) in question.incorrect_answers"
                            :key="i"
                        >
                            <input
                                :id="trimStringValue(incorrect_answer)"
                                :name="'ans' + index"
                                type="radio"
                                :value="incorrect_answer"
                                @click="givenAnswer(incorrect_answer, 'False')"
                            />
                            <label
                                class="ml-2"
                                :for="trimStringValue(incorrect_answer)"
                                >{{ incorrect_answer }}</label
                            >
                        </p>
                        <p>
                            <input
                                :id="trimStringValue(question.correct_answer)"
                                type="radio"
                                :name="'ans' + index"
                                :value="question.correct_answer"
                                @click="givenAnswer('True', 'True')"
                            />
                            <label
                                class="ml-2"
                                :for="trimStringValue(question.correct_answer)"
                                >{{ question.correct_answer }}</label
                            >
                        </p>
                    </div>
                    <div v-else>
                        <p
                            v-for="(
                                incorrect_answer, i
                            ) in question.incorrect_answers"
                            :key="i"
                        >
                            <input
                                :id="
                                    trimStringValue(question.question) +
                                    index +
                                    incorrect_answer
                                "
                                :name="'ans' + index"
                                type="radio"
                                :value="incorrect_answer"
                                @click="givenAnswer('False', 'True')"
                            />
                            <label
                                class="ml-2"
                                :for="
                                    trimStringValue(question.question) +
                                    index +
                                    incorrect_answer
                                "
                                >{{ incorrect_answer }}</label
                            >
                        </p>
                        <p>
                            <input
                                :id="
                                    trimStringValue(question.question) +
                                    index +
                                    question.correct_answer
                                "
                                type="radio"
                                :name="'ans' + index"
                                :value="question.correct_answer"
                                @click="givenAnswer('True', 'True')"
                            />
                            <label
                                class="ml-2"
                                :for="
                                    trimStringValue(question.question) +
                                    index +
                                    question.correct_answer
                                "
                                >{{ question.correct_answer }}</label
                            >
                        </p>
                    </div>
                </div>
            </AccordionItem>
        </AccordionList>
    </div>
</template>

<script setup>
import { ref, computed, onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import { useResultStore } from "@/stores/ResultStore";

import { Icon } from "@iconify/vue";
import { AccordionList, AccordionItem } from "vue3-rich-accordion";
import "vue3-rich-accordion/accordion-library-styles.css";

let questionsCats = ref([]);
let correctAnsCount = ref(0);
let totalQuestions = ref(0);

// Trim string
function trimStringValue(value) {
    return value.toLowerCase().replace(/[, ]+/g, "").trim();
}

// Count result/Mark
function givenAnswer(val, correctAns, index) {
    if (val === "True" || (correctAns === val && correctAns !== null)) {
        correctAnsCount.value++;
    } else {
        if (correctAnsCount.value < 1) {
            correctAnsCount.value = 0;
        } else {
            correctAnsCount.value--;
        }
    }
}

const store = useResultStore();
store.result = correctAnsCount;

const filteredQuestions = computed(() => (category) => {
    // Filter the questions by category
    return questionsCats.value.filter(
        (question) => question.category === category
    );
});

const categories = computed(() => {
    // Get all unique categories from the data
    const categories = new Set(
        questionsCats.value.map((question) => question.category)
    );
    return Array.from(categories);
});

const router = useRouter();

function logout() {
    localStorage.removeItem("name");
    localStorage.removeItem("email");
    router.push("/login");
}

onBeforeMount(() => {
    fetch("http://127.0.0.1:8000/api/questions")
        .then((response) => response.json())
        .then((response) => {
            // console.log(response);
            questionsCats.value = response;
            store.total = questionsCats.value.length;
            totalQuestions.value = store.total;
        })
        .catch((err) => console.error(err));
});
</script>

<style>
div input,
div label {
    cursor: pointer;
}
.disabled {
    pointer-events: none;
    color: #ccc;
}
</style>
