<template>
    <form @submit.prevent="handleSubmit">
        <div class="form-group">
            <label for="question-title">Question Title</label>
            <input type="text" name="title" v-model="title" :class="errorClass('title')">

            <div v-if="errors['title'][0]" class="invalid-feedback">
                <strong>{{ errors['title'][0] }}</strong>
            </div>
        </div>
        <div class="form-group">
            <label for="question-body">Explain you question</label>
            <m-editor :body="body" name="question-body">
                <textarea name="body" rows="10" :class="errorClass('body')" v-model="body"></textarea>

            <div v-if="errors['body'][0]" class="invalid-feedback">
                <strong>{{ errors['body'][0] }}</strong>
            </div>
            </m-editor>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg">{{ buttonText }}</button>
        </div>
    </form>
</template>

<script>
    import EventBus from '../event-bus'
    import MEditor from './MEditor.vue'
    export default {
        components: { MEditor },

        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },

        data () {
            return {
                title: '',
                body: '',
                errors: {
                    title: [],
                    body: []
                }
            }
        },

        // listen to the error event by saying event bus on error, and assign the error messages from the parent to local errors variable.
        mounted () {
            EventBus.$on('error', errors => this.errors = errors)

            // populate the form inputs if the isEdit is true
            if (this.isEdit) {
                this.fetchQuestion();
            }
        },

        computed: {
            // Change the button's text by props data
            buttonText () {
                return this.isEdit ? 'Update Question' : 'Ask Question'
            }
        },

        methods: {
            handleSubmit () {
                this.$emit('submitted', {
                    title: this.title,
                    body: this.body
                })
            },

            errorClass (column) {
                return [
                    'form-control',
                    this.errors[column] && this.errors[column][0] ? 'is-invalid' : '',
                ]
            },

            fetchQuestion () {
                // To assign the title and body from api response to title and body property respectively by using get request
                axios.get(`/questions/${this.$route.params.id}`)
                    .then(({ data }) => {
                        this.title = data.title
                        this.body = data.body
                    })
                    .catch(error => {
                        console.log(error.response);
                    })
            }

        }
    }
</script>
