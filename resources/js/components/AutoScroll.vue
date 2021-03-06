<!-- Edited from vue-plugin-autoscroll : https://github.com/rppld/vue-plugin-autoscroll-->
<template>
    <div class="autoscroll-container h-screen">
        <slot />
    </div>
</template>

<script>
export default {
    props: {
        loop: {
            default: true,
            type: Boolean
        },
        loopUp: {
            default: false,
            type: Boolean
        },
        slow: {
            default: false,
            type: Boolean
        }
    },

    data() {
        return {
            scrollDown: true,
            firstChild: null,
            lastChild: null,
            children: null,
            clones: [],
            fps: 30,
            ts: null,
            then: Date.now(),
            scrollUpAF: null,
            scrollDownAF: null
        };
    },
    mounted() {
        if (!this.isTouchDevice()) {
            const wheel =
                "onwheel" in document.createElement("div")
                    ? "wheel" // Modern browsers support "wheel"
                    : document.onmousewheel !== undefined
                        ? "mousewheel" // Webkit and IE support at least "mousewheel"
                        : "DOMMouseScroll"; // let's assume that remaining browsers are older Firefox

            window.addEventListener(wheel, e => {
                this.stopAutoScroll();

                if (e.deltaY > 0) {
                    // Scroll down
                    this.scrollDown = true;
                    this.startAutoScroll();
                } else {
                    // Scroll up
                    this.scrollDown = false;
                    this.startAutoScroll();
                }
            });
        }

        window.addEventListener("touchstart", e => {
            this.ts = e.touches[0].clientY;
        });

        window.addEventListener("touchmove", e => {
            const te = e.changedTouches[0].clientY;
            if (this.ts > te) {
                // Scroll down
                this.scrollDown = true;
            } else {
                // Scroll up
                this.scrollDown = false;
            }
        });

        window.addEventListener("scroll", this.handleScroll);
    },

    updated() {
        this.clearChildNodes(this.$el);

        this.children = Array.from(this.$el.childNodes);
        this.firstChild = this.children[0];
        this.lastChild = this.children[this.children.length - 1];

        if (this.loop) {
            this.cloneChildNodes(this.$el);
        }

        if (!this.isTouchDevice()) {
            this.startAutoScroll();
        }
    },

    methods: {
        throttle(callback) {
            const now = Date.now();
            const delta = now - this.then;
            const interval = 1000 / this.fps;

            if (delta > interval) {
                this.then = now - (delta % interval);
                callback();
            }
        },
        isTouchDevice() {
            return (
                "ontouchstart" in window ||
                navigator.MaxTouchPoints > 0 ||
                navigator.msMaxTouchPoints > 0
            );
        },
        stopAutoScroll() {
            window.cancelAnimationFrame(this.scrollUpAF);
            window.cancelAnimationFrame(this.scrollDownAF);
        },
        autoScrollUp() {
            this.slow
                ? this.throttle(() => window.scrollBy(0, -1))
                : window.scrollBy(0, -1);
            this.scrollUpAF = window.requestAnimationFrame(this.autoScrollUp);
        },
        autoScrollDown() {
            this.slow
                ? this.throttle(() => window.scrollBy(0, 1))
                : window.scrollBy(0, 1);
            this.scrollDownAF = window.requestAnimationFrame(
                this.autoScrollDown
            );
        },
        startAutoScroll() {
            this.stopAutoScroll();
            this.scrollDown ? this.autoScrollDown() : this.autoScrollUp();
        },
        isFullyAboveViewport(el) {
            const rect = el.getBoundingClientRect();
            return rect.bottom <= 0;
        },
        isAboveViewport(el) {
            const rect = el.getBoundingClientRect();
            return !rect.top <= 0;
        },
        resetScrollDown() {
            if (this.isFullyAboveViewport(this.lastChild)) {
                window.scrollTo(0, 0);
            }
        },
        resetScrollUp() {
            if (this.loopUp) {
                if (!this.isAboveViewport(this.firstChild)) {
                    this.clones[0].scrollIntoView();
                }
            }
        },
        resetScrollPos() {
            this.scrollDown ? this.resetScrollDown() : this.resetScrollUp();
        },
        handleScroll() {
            if (this.loop) {
                requestAnimationFrame(this.resetScrollPos);
            }
        },
        clearChildNodes(parent) {
            this.clones.map(clone => {
                parent.removeChild(clone);
            });
            this.clones = [];
        },
        cloneChildNodes(parent) {
            this.children.map(child => {
                const clone = child.cloneNode(true);
                parent.appendChild(clone);
                this.clones.push(clone);
            });
        }
    }
};
</script>
