<template>
    <div class="container mt-5">
        <h4>Hi There, its the Hello Component</h4>
        <!-- <inertia-link href="/contact">Go to Contact Page</inertia-link> -->

        <span v-if="errors.text" class="mt-3 d-block p-3 bg-danger">
            {{ errors.text }}
        </span>

        <div class="mt-3 row">
            <div class="col d-flex flex-wrap">
                <span
                    class="p-3 bg-primary text-white mt-2 mb-2 w-100"
                    v-for="(message, index) in messageList"
                    :key="index"
                >
                    {{ index }} - {{ message.text }}
                </span>
            </div>

            <div class="col">
                <h4 class="mb-3">Fill the Form Here</h4>

                <form @submit.prevent="onSubmit">
                    <textarea
                        class="d-block"
                        v-model="formInput.text"
                        rows="5"
                    />
                    <button type="submit" class="mt-3 btn btn-success">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Hello",
    props: {
        messageList: { type: Array, default: () => [] },
        errors: { type: Object, default: () => {} }
    },
    data() {
        return {
            formInput: { text: "" }
        };
    },
    methods: {
        onSubmit() {
            this.$inertia.post("/add-message", this.formInput);
            this.formInput.text = "";
        }
    },
    mounted() {
        console.log("message-list data", this.messageList);
    }
};
</script>

<style></style>
