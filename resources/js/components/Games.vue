<template>
    <auto-scroll class="bg-grey-lightest p-8">
        <game v-for="game in games" :key="game.id" :game="game"></game>
    </auto-scroll>
</template>

<script>
import Game from "./Game";

export default {
    components: {
        Game
    },
    props: ["initial_games"],
    data() {
        return {
            games: 0,
            playerFont: null
        };
    },
    mounted() {
        this.games = this.initial_games;

        Echo.channel("messages")
            .listen(".current_game.updated", this.fetchGames)
            .listen(".games.updated", this.fetchGames);
    },
    methods: {
        fetchGames() {
            axios
                .get("api/games/next-ones")
                .then(response => {
                    this.games = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
};
</script>
