<template>
    <div class="w-full p-2 rounded hover:bg-grey-lighter flex items-center">
        <div class="w-12 text-xl text-right mr-4">{{ game.number }}</div>
        <div class="w-2/5 text-right mr-4">
            <span v-if="!editing">{{ firstPlayerName }}</span>
            <model-list-select v-else :list="players"
                               v-model="currentFirstPlayer"
                               option-value="id"
                               option-text="name"
                               placeholder="Joueur(s)">
            </model-list-select>
        </div>
        <div class="w-12 mr-4">contre</div>
        <div class="w-2/5 mr-4">
            <span v-if="!editing">{{ secondPlayerName }}</span>
            <model-list-select v-else :list="players"
                               v-model="currentSecondPlayer"
                               option-value="id"
                               option-text="name"
                               placeholder="Joueur(s)">
            </model-list-select>
        </div>
        <div class="flex-1"></div>
        <font-awesome-icon v-if="!editing" :icon="['far','edit']" @click="startEditing" class="cursor-pointer"></font-awesome-icon>
        <div v-else class="w-16 text-right">
            <loader :loading="saving" class="text-xl">
                <font-awesome-icon :icon="['far','save']" @click="save" class="mr-3 cursor-pointer" v-if="!saving"></font-awesome-icon>
                <font-awesome-icon :icon="['fas','times']" @click="cancel" class="cursor-pointer" v-if="!saving"></font-awesome-icon>
            </loader>
        </div>
    </div>
</template>

<script>
import { ModelListSelect } from "vue-search-select";
export default {
    components: {
        ModelListSelect
    },
    props: ["game", "players"],
    data() {
        return {
            editing: false,
            saving: false,
            currentFirstPlayer: null,
            currentSecondPlayer: null
        };
    },
    methods: {
        startEditing() {
            this.currentFirstPlayer =
                this.firstPlayer == null ? null : this.firstPlayer.id;
            this.currentSecondPlayer =
                this.secondPlayer == null ? null : this.secondPlayer.id;
            this.editing = true;
        },
        save() {
            this.saving = true;
            axios
                .put("api/games/" + this.game.id, {
                    first_player_id: this.currentFirstPlayer,
                    second_player_id: this.currentSecondPlayer
                })
                .then(response => {
                    this.$emit("updated", response.data.data);
                    this.editing = false;
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.saving = false;
                });
        },
        cancel() {
            this.editing = false;
        },
        playerName(player) {
            if (player == null) {
                return "??";
            }
            return player.name;
        }
    },
    computed: {
        firstPlayer() {
            if (this.game.first_player_id == null || !this.players) {
                return null;
            }
            return this.players.find(player => {
                return player.id === this.game.first_player_id;
            });
        },
        secondPlayer() {
            if (this.game.second_player_id == null || !this.players) {
                return null;
            }
            return this.players.find(player => {
                return player.id === this.game.second_player_id;
            });
        },
        firstPlayerName() {
            return this.playerName(this.firstPlayer);
        },
        secondPlayerName() {
            return this.playerName(this.secondPlayer);
        }
    }
};
</script>
