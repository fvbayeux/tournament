<template>
    <div class="h-screen w-full flex justify-center items-center bg-grey-lightest">
        <div class="font-bold text-screen">{{ count }}</div>
    </div>
</template>

<script>
export default {
    props: ["initial_value"],
    data() {
        return {
            count: 0
        };
    },
    mounted() {
        this.count = this.initial_value;

        Echo.channel("messages").listen(".current_game.updated", message => {
            this.count = message.current_game;
        });
    }
};
</script>
