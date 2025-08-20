<template>
    <div class="w-64 rounded p-4 text-center shadow">
        <h2 class="mb-4 text-xl font-bold">⏱ Timer</h2>
        <p class="mb-4 font-mono text-3xl">{{ formattedTime }}</p>
        <div class="flex justify-center gap-2">
            <button @click="startTimer" :disabled="isRunning" class="rounded bg-green-500 px-4 py-2 text-white disabled:opacity-50">Start</button>
            <button @click="stopTimer" :disabled="!isRunning" class="rounded bg-red-500 px-4 py-2 text-white disabled:opacity-50">Stop</button>
            <button @click="resetTimer" class="rounded bg-gray-500 px-4 py-2 text-white">Reset</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Timer',
    data() {
        return {
            time: 0,
            timer: null,
            isRunning: false,
        };
    },
    computed: {
        formattedTime() {
            const minutes = String(Math.floor(this.time / 60)).padStart(2, '0');
            const seconds = String(this.time % 60).padStart(2, '0');
            return `${minutes}:${seconds}`;
        },
    },
    methods: {
        startTimer() {
            if (this.isRunning) return;
            this.isRunning = true;
            this.timer = setInterval(() => {
                this.time++;
            }, 1000);
        },
        stopTimer() {
            this.isRunning = false;
            clearInterval(this.timer);
            this.timer = null;
        },
        resetTimer() {
            this.stopTimer();
            this.time = 0;
        },
    },
    beforeUnmount() {
        this.stopTimer();
    },
};
</script>
