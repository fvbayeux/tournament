<template>
    <div class="w-full p-2 rounded hover:bg-grey-lighter">
        <div v-if="!editing" class="flex justify-between items-center">
            <div>{{player.name}}</div>
            <div v-if="!pendingDeletion">
                <font-awesome-icon :icon="['far','edit']" @click="startEditing" class="cursor-pointer"></font-awesome-icon>
                <font-awesome-icon :icon="['fas','trash']" @click="pendingDeletion = true" class="cursor-pointer ml-2"></font-awesome-icon>
            </div>
            <div v-else>
                <loader :loading="deleting">
                    <font-awesome-icon :icon="['fas','check']" @click="deletePlayer" class="cursor-pointer"></font-awesome-icon>
                    <font-awesome-icon :icon="['fas','times']" @click="pendingDeletion = false" class="cursor-pointer ml-2"></font-awesome-icon>
                </loader>
            </div>
        </div>
        <div v-else class="flex justify-between items-center">
            <input type="text"  class="shadow appearance-none border rounded flex-1 py-2 px-3 text-grey-darkest focus:outline-none"
                   :disabled="saving"
                   @keypress="saveOnEnter"
                   v-model="playerName">
            <div class="ml-16 text-xl">
                <loader :loading="saving">
                    <font-awesome-icon :icon="['far','save']" @click="save" class="mr-3 cursor-pointer"></font-awesome-icon>
                    <font-awesome-icon :icon="['fas','times']" @click="cancel" class="cursor-pointer"></font-awesome-icon>
                </loader>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["player"],
    data() {
        return {
            editing: false,
            saving: false,
            playerName: "",
            pendingDeletion: false,
            deleting: false,
        };
    },
    methods: {
        startEditing() {
            this.playerName = this.player.name;
            this.editing = true;
        },
        save() {
            this.saving = true;
            axios
                .put("api/players/" + this.player.id, { name: this.playerName })
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
        saveOnEnter(event) {
            if (event.key === "Enter") {
                this.save();
            }
        },
        cancel() {
            this.editing = false;
        },
        deletePlayer() {
            this.deleting = true;
            axios
              .delete("api/players/" + this.player.id)
              .then(response => {
                  this.$emit("updated", response.data.data);
              })
              .catch(error => {
                  console.error(error);
              })
              .finally(() => {
                  this.deleting = false;
              });
        }
    }
};
</script>
