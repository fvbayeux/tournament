<template>
    <div class="w-full h-full">
        <slot v-if="!loading"></slot>
        <div v-else class="h-full w-full flex items-center justify-center" :class="loaderClasses">
            <font-awesome-icon :icon="['fas','spinner']" class="text-grey spinner" ></font-awesome-icon>
        </div>
    </div>
</template>
<script>
export default {
    props: ["loading", "loaderClasses"]
};
</script>
