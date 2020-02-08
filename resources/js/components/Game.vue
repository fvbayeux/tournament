<template>
    <div class="flex p-2 mb-8 max-h-340px rounded shadow-lg bg-white">
        <div class="w-1/5 flex justify-center items-center text-20xl font-bold">
            {{ game.number }}
        </div>
        <div class="w-4/5">
            <div class="h-1/2 p-4">
                <svg :viewBox="'0 0 '+ firstPlayerNameWidth + ' '+fontHeight" class="w-full h-full">
                    <text x="0" :y="fontHeight - 3">{{ game.first_player.name }}</text>
                </svg>
            </div>
            <div class="h-1/2 p-4">
                <svg :viewBox="'0 0 '+ secondPlayerNameWidth+' '+fontHeight" class="w-full h-full">
                    <text x="0" :y="fontHeight - 3">{{ game.second_player.name }}</text>
                </svg>
            </div>
        </div>
        <div ref="game"></div>
    </div>
</template>

<script>
export default {
    props: ["game"],
    data() {
        return {
            font: "",
            firstPlayerNameWidth: 0,
            secondPlayerNameWidth: 0,
            fontHeight: 0
        };
    },
    mounted() {
        this.font =
            this.css("font-style") +
            " " +
            this.css("font-size") +
            " " +
            this.css("font-family");
        this.computeWidths();
    },
    methods: {
        textWidth(text) {
            // https://www.tutorialspoint.com/Calculate-text-width-with-JavaScript
            const myCanvas =
                this.textWidth.canvas ||
                (this.textWidth.canvas = document.createElement("canvas"));
            const context = myCanvas.getContext("2d");
            context.font = this.font;

            return context.measureText(text).width;
        },
        css(property) {
            return window
                .getComputedStyle(this.$refs.game, null)
                .getPropertyValue(property);
        },
        computeWidths() {
            this.firstPlayerNameWidth =
                this.textWidth(this.game.first_player.name) + 10;
            this.secondPlayerNameWidth =
                this.textWidth(this.game.second_player.name) + 10;
            const fontSize = this.css("font-size");
            this.fontHeight =
                parseInt(fontSize.substr(0, fontSize.length - 2)) + 3;
        }
    },
    watch: {
        game: function() {
            this.computeWidths();
        }
    }
};
</script>
