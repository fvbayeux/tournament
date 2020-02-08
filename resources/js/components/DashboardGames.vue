<template>
    <div class="w-full h-full rounded overflow-y-scroll shadow-lg bg-white p-4 relative">
        <loader :loading="!loaded" :loader-classes="['text-5xl']">
            <dashboard-game v-for="game in games" :key="game.id" :game="game" :players="players" @updated="updateGames"></dashboard-game>
            <div class="w-full mt-4 p-2 flex items-center mb-260">
                <input type="text" class="shadow appearance-none border rounded w-12 py-2 px-3 mr-4 text-grey-darkest focus:outline-none"
                       :disabled="creating"
                       v-model="newGameNumber"
                       placeholder="N°">
                <div class="w-2/5 text-right mr-4">
                    <model-list-select :list="players"
                                       v-model="newGameFirstPlayer"
                                       option-value="id"
                                       option-text="name"
                                       placeholder="Joueur(s)">
                    </model-list-select>
                </div>
                <div class="w-12 mr-4">contre</div>
                <div class="w-2/5 mr-4">
                    <model-list-select :list="players"
                                       v-model="newGameSecondPlayer"
                                       option-value="id"
                                       option-text="name"
                                       placeholder="Joueur(s)">
                    </model-list-select>
                </div>
                <div class="flex-1"></div>
                <div class="w-16 text-right">
                    <loader :loading="creating" class="text-xl">
                        <button @click="createGame">
                        <font-awesome-icon :icon="['fas','plus']"
                                           :class="{'cursor-pointer': !!newGameNumber,  'text-grey': !newGameNumber}"
                                          ></font-awesome-icon>
                        </button>
                    </loader>
                </div>
            </div>
        </loader>
    </div>
</template>

<script>
import DashboardGame from "./DashboardGame";
import { ModelListSelect } from "vue-search-select";
export default {
    components: { DashboardGame, ModelListSelect },
    data() {
        return {
            games: null,
            players: null,
            creating: false,
            newGameNumber: null,
            newGameFirstPlayer: null,
            newGameSecondPlayer: null
        };
    },
    created() {
        this.$root.$options.eventHub.$on("playersUpdated", this.setPlayers);
    },
    mounted() {
        this.fetchGames();
        this.fetchPlayers();
    },
    computed: {
        loaded() {
            return this.games !== null && this.players !== null;
        }
    },
    methods: {
        fetchGames() {
            axios
                .get("api/games")
                .then(response => {
                    this.games = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchPlayers() {
            axios
                .get("api/players")
                .then(response => {
                    this.players = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        setPlayers(players) {
            this.players = players;
        },
        updateGames(games) {
            this.games = games;
        },
        createGame() {
            this.creating = true;
            axios
                .post("api/games", {
                    number: this.newGameNumber,
                    first_player_id: this.newGameFirstPlayer,
                    second_player_id: this.newGameSecondPlayer
                })
                .then(response => {
                    this.newGameNumber = null;
                    this.newGameFirstPlayer = null;
                    this.newGameSecondPlayer = null;
                    this.games = response.data.data;
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.creating = false;
                });
        }
    },
    watch: {
        games: function(newValue, oldValue) {
            if (newValue.length > 0) {
                this.newGameNumber = newValue[newValue.length - 1].number + 1;
            } else {
                this.newGameNumber = 1;
            }
        }
    }
};
</script>
