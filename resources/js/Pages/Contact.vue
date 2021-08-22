<template>
    <div>
        <h4>Hi There, its the Contact Component</h4>
        <Link href="/hello">Go to Hello Page</Link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
    name: "Contact",
    components: {
        Link
    }
};
</script>

<style></style>
