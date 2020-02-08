<template>
    <div class="w-full h-full overflow-y-scroll rounded shadow-lg bg-white p-4">
        <loader :loading="!loaded" :loader-classes="['text-5xl']">
            <player v-for="player in players" :player="player" :key="player.id" @updated="updatePlayers"></player>
            <div class="my-4 flex justify-between items-center">
                <input type="text" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-grey-darkest focus:outline-none"
                       :disabled="creating"
                       v-model="newPlayer"
                       placeholder="Nouveau joueur">
                <div class="ml-16 text-xl mr-3">
                    <loader :loading="creating">
                        <button @click="createPlayer">
                        <font-awesome-icon :icon="['fas','plus']"
                                           :class="{'cursor-pointer': !!newPlayer,  'text-grey': !newPlayer}"
                                           ></font-awesome-icon>
                        </button>
                    </loader>
                </div>
            </div>
        </loader>
    </div>
</template>

<script>
import Player from "./Player";
export default {
    components: {
        Player
    },
    data() {
        return {
            players: null,
            newPlayer: "",
            creating: false
        };
    },
    mounted() {
        this.fetchPlayers();
    },
    computed: {
        loaded() {
            return this.players !== null;
        }
    },
    methods: {
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
        updatePlayers(players) {
            this.players = players;
            this.playersUpdated();
        },
        createPlayer() {
            if (!this.newPlayer) {
                return;
            }
            this.creating = true;
            axios
                .post("api/players", { name: this.newPlayer })
                .then(response => {
                    this.players = response.data.data;
                    this.newPlayer = "";
                    this.playersUpdated();
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.creating = false;
                });
        },
        playersUpdated() {
            this.$root.$options.eventHub.$emit("playersUpdated", this.players);
        }
    }
};
</script>
