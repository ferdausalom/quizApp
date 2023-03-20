import { defineStore } from "pinia";

export let useResultStore = defineStore("result", {
    state() {
        return {
            userName: JSON.parse(localStorage.getItem("name")),
            total: 0,
            result: 0,
        };
    },
});
