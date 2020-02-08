<template>
    <div class="h-full w-full rounded shadow-lg bg-white p-4">
        <loader :loading="!loaded || saving" :loader-classes="['text-5xl']">
            <div class="h-full w-full flex items-center justify-around">
            <font-awesome-icon :icon="['fas','minus']" @click="decrement" class="cursor-pointer"></font-awesome-icon>
            <div class="font-bold text-5xl">{{ current_game }}</div>
            <font-awesome-icon :icon="['fas','plus']" @click="increment" class="cursor-pointer"></font-awesome-icon>
            </div>
        </loader>
    </div>
</template>

<script>
export default {
    data() {
        return {
            current_game: -1,
            saving: false
        };
    },
    mounted() {
        this.fetchCurrentGame();
    },
    computed: {
        loaded() {
            return this.current_game !== -1;
        }
    },
    methods: {
        fetchCurrentGame() {
            axios
                .get("api/current-game")
                .then(response => {
                    this.current_game = response.data.data.current_game;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateCurrentGame(value) {
            this.saving = true;
            axios
                .put("api/current-game", { value: value })
                .then(response => {
                    this.current_game = response.data.data.current_game;
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.saving = false;
                });
        },
        decrement() {
            if (this.current_game > 0) {
                this.updateCurrentGame(this.current_game - 1);
            }
        },
        increment() {
            this.updateCurrentGame(this.current_game + 1);
        }
    }
};
</script>
