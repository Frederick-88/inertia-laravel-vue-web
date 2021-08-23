<template>
    <div class="container mt-5">
        <h4>Hi There, its the Hello Component</h4>
        <Link href="/contact">Go to Contact Page</Link>

        <span
            v-if="errors.text || errors.message"
            class="mt-3 d-block p-3 bg-danger text-white"
        >
            {{ errors.text ? errors.text : errors.message }}
        </span>

        <span
            v-if="errors.successMessage"
            class="mt-3 d-block p-3 bg-success text-white"
        >
            {{ errors.successMessage }}
        </span>

        <div class="mt-3 row">
            <div class="col d-flex flex-wrap">
                <span
                    class="d-flex justify-content-between align-items-center border border-primary bg-light mt-2 mb-2 p-3 w-100"
                    v-for="(message, index) in messageList"
                    :key="index"
                >
                    <p class="m-0">{{ index + 1 }} - {{ message.text }}</p>
                    <div class="d-flex">
                        <button
                            type="button"
                            class="me-2 btn btn-success"
                            @click="setIsEdit(true, message)"
                        >
                            Edit
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            @click="deleteMessage(message)"
                        >
                            Delete
                        </button>
                    </div>
                </span>
            </div>

            <div class="col ms-5">
                <h4 class="mb-3">{{ formTitle }}</h4>

                <form @submit.prevent="onSubmit">
                    <textarea
                        class="d-block"
                        v-model="formInput.text"
                        rows="5"
                    />
                    <button type="submit" class="mt-3 btn btn-success">
                        Submit
                    </button>
                    <button
                        v-if="isEdit"
                        type="button"
                        class="mt-3 ms-2 btn btn-light"
                        @click="setIsEdit(false)"
                    >
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";

export default {
    name: "Hello",
    components: {
        Link
    },
    props: {
        messageList: { type: Array, default: () => [] },
        errors: { type: Object, default: () => {} }
    },
    data() {
        return {
            isEdit: false,
            selectedText: "",
            formInput: { id: -1, text: "" }
        };
    },
    watch: {
        errors: {
            handler(val) {
                console.log("errors: ", val);
            },
            deep: true
        }
    },
    computed: {
        formTitle() {
            return this.isEdit
                ? `Edit the "${this.selectedText}" Message Here`
                : "Add a New Message on the Form Here";
        }
    },
    methods: {
        resetData() {
            this.selectedText = "";
            this.formInput.text = "";
            this.isEdit = false;
        },
        onSubmit() {
            if (this.isEdit) {
                this.$inertia.put("/update-message", this.formInput);
            } else {
                this.$inertia.post("/add-message", this.formInput);
            }

            this.resetData();
        },
        deleteMessage(message) {
            if (window.confirm(`Are you sure to delete ${message.text}?`)) {
                // for delete, to receive the id need to use POST.
                // except if we are going to use controller with 'Route::resources' rather than 'Route::post'
                this.$inertia.post("/delete-message", { id: message.id });
            }
        },
        setIsEdit(boolean, selectedText) {
            this.isEdit = boolean;

            if (selectedText) {
                this.selectedText = selectedText.text;
                this.formInput = {
                    id: selectedText.id,
                    text: selectedText.text
                };
            } else {
                this.resetData();
            }
        }
    },
    mounted() {
        console.log("message-list data", this.messageList);
    }
};
</script>

<style></style>
